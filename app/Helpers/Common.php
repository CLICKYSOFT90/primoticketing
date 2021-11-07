<?php

namespace App\Helpers;

use App;
use Config;
use App\managers\UserManager;
use App\Models\CycleCount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use App\TraitLibraries\ResponseWithHttpStatus;
use App\Models\Role;
use App\Models\UserRole;
use App\Models\Parties;
use App\Models\Configuration;
use App\Models\EmailLog;
use App\Models\CustomField;
use App\Models\CustomFieldResponse;
use Illuminate\Support\Facades\Log;

class Common
{
    use ResponseWithHttpStatus;

    public static function getConfig($module, $key)
    {
        $model = Configuration::where('module', $module)->where('key', $key)->get()->first();

        if (!empty($model)) {
            return $model->value;
        } else {
            return "";
        }
    }

    public static function getSetting($module, $name, $key, $value = "false", $description = "", $isCreate = 1)
    {
        $model = Configuration::where('module', $module)->where('name', $name)->where('key', $key)->get()->first();
        if (empty($model) && $isCreate == 1) {
            $model = new Configuration();
            $model->module = $module;
            $model->name = $name;
            $model->key = $key;
            $model->description = $description;
            $model->value = $value;
            $model->forAdmin = 1;
            $model->save();
        }

        if (!empty($model)) {
            return $model->value;
        } else {
            return "";
        }
    }

    public static function getCustomFields($model)
    {
        $return = array();
        $result = CustomField::where('model', $model)->orderBy('sort')->get();

        if ($result->count() > 0) {
            $return = $result;
        }
        return $return;
    }

    public static function getCustomFieldRules($model)
    {
        $rules = array();
        foreach (SELF::getCustomFields($model) as $row) {
            if (!empty($row->rules)) {
                $rules[$row->name] = $row->rules;
            }
        }
        return $rules;
    }

    public static function getCustomFieldValue($model, $fieldName, $modelId = 0)
    {
        $return = "";
        $fieldId = CustomField::where("model", $model)->where("name", $fieldName)->value('id');
        if (!empty($fieldId)) {
            $result = CustomFieldResponse::where('modelId', $modelId)->value('response');
            if (!empty($result)) {
                $return = @$result[$fieldName];
            }
        }
        return $return;
    }

    public static function select2Ajax()
    {
        $request = (object)$_POST;
        $return = [];
        if (!empty(@$request->term)) {
            if (@$request->source == "organization") {
                $query = "SELECT
                                id,
                                organization_name as text
                            FROM organizations
                            WHERE 1 AND active = 1";

                if (@$request->isDefault == 1) {
                    $query .= " AND id = '" . $request->term . "'";
                } else {
                    $query .= " AND (organization_name LIKE '%" . $request->term . "%')";
                }
            }

            if (@$request->source == "flag") {
                $query = "SELECT
                                id,
                                name as text
                            FROM flags
                            WHERE 1 AND active = 1";

                if (!empty(@$request->filter)) {
                    $query .= " AND flagType = '" . @$request->filter . "'";
                }

                if (@$request->isDefault == 1) {
                    $query .= " AND id = '" . $request->term . "'";
                } else {
                    $query .= " AND (name LIKE '%" . $request->term . "%')";
                }
            }

            if (@$request->source == "flag-for-parent") {
                $query = "SELECT
                                flags.id,
                                Concat(flags.name, ' - ', FT.name) as text
                            FROM flags
                            LEFT JOIN flag_types FT ON FT.code = flags.flagType
                            WHERE 1 AND flags.active = 1";

                if (!empty(@$request->filter)) {
                    $query .= " AND flags.flagType = '" . @$request->filter . "'";
                }

                if (@$request->isDefault == 1) {
                    $query .= " AND flags.id = '" . $request->term . "'";
                } else {
                    $query .= " AND (flags.name LIKE '%" . $request->term . "%')";
                }
            }

            if (@$request->source == "flag-name") {
                $query = "SELECT
                                name as id,
                                name as text
                            FROM flags
                            WHERE 1 AND active = 1";

                if (!empty(@$request->filter)) {
                    $query .= " AND flagType = '" . @$request->filter . "'";
                }

                if (@$request->isDefault == 1) {
                    $query .= " AND name = '" . $request->term . "'";
                } else {
                    $query .= " AND (name LIKE '%" . $request->term . "%')";
                }
            }

            if (@$request->source == "flagType") {
                $query = "SELECT
                                id,
                                name as text
                            FROM flag_types
                            WHERE 1 AND active = 1";

                if (@$request->isDefault == 1) {
                    $query .= " AND id = '" . $request->term . "'";
                } else {
                    $query .= " AND (name LIKE '%" . $request->term . "%')";
                }
            }

            if (@$request->source == "flagType-code") {
                $query = "SELECT
                                code as id,
                                name as text
                            FROM flag_types
                            WHERE 1 AND active = 1";

                if (@$request->isDefault == 1) {
                    $query .= " AND code = '" . $request->term . "'";
                } else {
                    $query .= " AND (name LIKE '%" . $request->term . "%')";
                }
            }
            if (!empty(@$query)) {
                if (empty($return)) {
                    $return = DB::select($query);
                }
                echo json_encode($return);
            }
        }
    }

    public static function getCompany()
    {
        return explode('.', @$_SERVER['HTTP_HOST'])[0];
    }

    public static function getCustomerRolePartyId()
    {
        if (!empty(auth()->user()->id)) {
            $roleId = UserRole::where('user_id', auth()->user()->id)->pluck('role_id')->first();
        }
        return 0;
    }

    public static function getRoleName()
    {
        if (!empty(auth()->user())) {
            $roleId = UserRole::where('user_id', auth()->user()->id)->pluck('role_id')->first();
            if (!empty($roleId)) {
                $roleName = Role::where('id', $roleId)->pluck('roleName')->first();
                return strtolower($roleName);
            }
        }
        return "";
    }

    private static function like($str, $searchTerm)
    {
        $searchTerm = strtolower($searchTerm);
        $str = strtolower($str);
        $pos = strpos($str, $searchTerm);
        if ($pos === false)
            return false;
        else
            return true;
    }

    public static function importDateFormatter($dateTime)
    {
        $date = $dateTime;
        $type = gettype($dateTime);

        if ($type == "string") {

            $date = null;
            if (!empty($dateTime)) {
                $strtotime = strtotime($dateTime);
                if ($strtotime == false) {
                    $strtotime = strtotime(str_replace('-', '/', $dateTime));
                }

                if ($strtotime == false) {
                    $strtotime = strtotime(str_replace('/', '-', $dateTime));
                }

                $date = date('Y-m-d', $strtotime);
            }
        }

        if ($type == "double" || $type == "integer") {
            $dateTime = ($dateTime - 25569) * 86400;
            $date = gmdate("Y-m-d", $dateTime);
        }
        return $date;
    }

    public static function returnZero($value)
    {
        if (empty($value) || !isset($value) || is_nan($value)) {
            $value = 0;
        }
        return $value;
    }

    public static function throwValidationError($field, $message)
    {
        if (self::isAPIRequest()):
            return self::responseFailure($message, 422);
        endif;

        throw ValidationException::withMessages([$field => $message]);
    }

    public static function throwValidationErrorAjax($message)
    {
        if (self::isAPIRequest()):
            return self::responseFailure($message, 422);
        endif;

        echo json_encode($message);
        exit();
    }

    public static function decimalPlace($number, $place)
    {
        return number_format((float)$number, $place, '.', '');
    }

    public static function getWeekDay($weekDay)
    {
        $days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        return $days[$weekDay];
    }

    public static function numberFormat($number, $decimal = 2)
    {
        return number_format(SELF::returnZero($number), $decimal);
    }

    public static function convertToBoolean($val)
    {
        $boolean_values = ["yes" => 1, "y" => 1, "no" => 0, "n" => 0, "1" => 1, "0" => 0, "true" => 1, "false" => 0, "active" => 1, "inactive" => 0];
        $val = strtolower($val);
        if ($val == "") {
            return "0";

        } else if (array_key_exists($val, $boolean_values)) {
            return $boolean_values[$val];
        } else {
            return -1;
        }

    }

    public static function sendEmail($recipients, $subject, $body, $attachment = "", $attachmentName = "")
    {
        foreach ($recipients as $recipient) {
            \Mail::send([], [], function ($m) use ($recipient, $subject, $body, $attachment, $attachmentName) {
                $m->to($recipient);
                $m->subject($subject);
                $m->setBody($body, 'text/html');
                if ($attachment) {
                    $m->attachData($attachment, $attachmentName);
                }
            });

            $response = "success";
            if (\Mail::failures()) {
                $response = Mail::failures();
            }

            EmailLog::create([
                'from' => env("MAIL_FROM_ADDRESS"),
                'to' => $recipient,
                'subject' => $subject,
                'body' => $body,
                'response' => $response,
            ]);
        }
    }

    public static function CTL($dateTime, $is_date = false, $dateFormat = "")
    {
        if (empty($dateTime)) {
            return null;
        }

        if (empty($dateFormat)) {
            //$dateFormat = SELF::getConfig('company', 'dateFormat');
            $dateFormat = "m/d/Y";
        }

        if ($is_date) {
            return \Timezone::convertToLocal(\Carbon\Carbon::parse($dateTime), $dateFormat);
        } else if (!empty(explode(' ', $dateTime)[1])) {
            return \Timezone::convertToLocal(\Carbon\Carbon::parse($dateTime), $dateFormat . ' g:i:s a');
        } else {
            return \Carbon\Carbon::parse($dateTime)->format($dateFormat);
        }
    }

    public static function CFL($dateTime)
    {
        if (empty($dateTime)) {
            return null;
        }
        $carbon = \Timezone::convertFromLocal($dateTime);
        return $carbon->toDateTimeString();
    }

    public static function CAMPM($time)
    {
        if (!empty(($time))) {
            return date("h:i A", strtotime($time));
        }
    }

    public static function isDateTime($string = "")
    {
        if (!empty($string)) {
            if (\DateTime::createFromFormat('Y-m-d H:i:s', $string) !== false) {
                return SELF::CTL($string);
            }
        }
        return $string;
    }

    public static function userRole()
    {
        if (!empty(session('user_role'))) {
            return session('user_role');
        } else {
            $user_alpha_role = auth()->user()->alphaRole;
            session(['user_role' => $user_alpha_role]);
            return $user_alpha_role;
        }
    }

    public static function checkPermission($module, $key)
    {
        $user_role = SELF::userRole();
        if (strtolower($user_role) == strtolower(UserManager::AlphaRoleSuper)) {
            return true;
        } else {
            $permissions = session('permissions');
            $permissionName = strtolower($module . $key);
            if (!empty($permissions) && in_array($permissionName, $permissions)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function canCreate($module)
    {
        return SELF::checkPermission($module, "Create");
    }

    public static function canRead($module)
    {
        return SELF::checkPermission($module, "Read");
    }

    public static function canUpdate($module)
    {
        return SELF::checkPermission($module, "Update");
    }

    public static function canDelete($module)
    {
        return SELF::checkPermission($module, "Delete");
    }

    public static function isAPIRequest()
    {
        if (request()->has('entryStatus') && request()->input('entryStatus') == config('api.entry_status')) {
            return true;
        }
        return false;
    }

    public static function getModels($path = false, $all = false)
    {
        if (!$path)
            $path = app_path() . "/Models";

        $ignore = array("BillingRules", "Carrier", "CarrierType", "Category", "IbShipment", "IbShipmentGateEntry", "IbShipmentItem", "IbShipmentLpn", "IbShipmentPutaway", "Item", "Location", "Order", "OrderItem", "Parties");
        $out = [];
        $results = scandir($path);
        foreach ($results as $result) {
            if ($result === '.' or $result === '..') continue;

            if ($all) {
                $filename = $path . '/' . $result;
                if (is_dir($filename)) {
                    $out = array_merge($out, self::getModels($filename, true));
                } else {
                    $out[] = substr($result, 0, -4);
                }
            } else {
                $filename = $result;
                if (in_array(substr($filename, 0, -4), $ignore)) {
                    if (is_dir($filename)) {
                        $out = array_merge($out, self::getModels($filename));
                    } else {
                        $model = 'App\Models\\' . substr($filename, 0, -4);
                        $out[] = $model::$module;
                    }
                }
            }
        }
        return $out;
    }

    public static function getEnvHost()
    {
        $path = base_path() . "/env";

        $results = scandir($path);
        foreach ($results as $result) {
            if ($result === '.' or $result === '..') continue;
            $out[] = str_replace('.env.', '', $result);
        }
        return $out;
    }

    public static function getModelsCF()
    {
        $modelsCF = CustomField::distinct()->get(['model'])->pluck('model')->toArray();
        $models = SELF::getModels();
        $models = array_diff($models, $modelsCF);
        return $models;
    }

    public static function clean($string)
    {
        $string = preg_replace("/[^A-Za-z0-9 ]/", '', $string);
        $string = trim($string);
        $string = preg_replace('/\s+/', '_', $string);
        return strtolower($string);
    }

    public static function generateSpaceSeparatedCode($value)
    {
        if ($value != "") {
            $explode_val = explode(" ", $value);
            if (count($explode_val) == 1) {
                return strtoupper(substr($value, 0, 2));
            } else {
                $prefix = "";
                foreach ($explode_val as $i) {
                    $prefix .= substr($i, 0, 1);
                }
                return strtoupper($prefix);
            }
        } else {
            return false;
        }
    }

    public static function getRandomColor()
    {
        foreach (array('r', 'g', 'b') as $color) {
            $rgbColor[$color] = mt_rand(0, 255);
        }
        return "rgb(" . implode(",", $rgbColor) . ")";
    }

    public static function excelToDateTimeObject($value)
    {
        if (empty($value)) {
            return null;
        }
        return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
    }


    public static function getMonths($start = 1, $end = 12)
    {
        return array_reduce(range(1, 12), function ($rslt, $m) {
            $rslt[$m] = date('F', mktime(0, 0, 0, $m, 10));
            return $rslt;
        });
    }

    public static function getTotalMonthsBwDates($from, $to)
    {
        $fromYear = date("Y", strtotime($from));
        $fromMonth = date("m", strtotime($from));
        $toYear = date("Y", strtotime($to));
        $toMonth = date("m", strtotime($to));
        if ($fromYear == $toYear) {
            return ($toMonth - $fromMonth) + 1;
        } else {
            return (12 - $fromMonth) + 1 + $toMonth;
        }
    }

    public static function convertHMSToHours($time)
    {
        $hms = explode(":", $time);

        if (!isset($hms[0])) {
            $hms[0] = 1;
        }

        if (!isset($hms[1])) {
            $hms[1] = 0;
        }

        if (!isset($hms[2])) {
            $hms[2] = 0;
        }
        return ($hms[0] + ($hms[1] / 60) + ($hms[2] / 3600));
    }

    public static function hoursToMinutes($hours)
    {
        $minutes = 0;
        if (strpos($hours, ':') !== false) {
            // Split hours and minutes.
            list($hours, $minutes) = explode(':', $hours);
        }
        return $hours * 60 + $minutes;
    }

    public static function getScheduleType($scheduleId)
    {
        $result = \App\Models\ReportSchedule::where('id', $scheduleId)->first();
        $cronJob = \App\Models\CronJob::where('model_type', 'ReportSchedule')->where('model_id', $scheduleId)->first();

        if (@$cronJob->frequency_func == "everyMinute") {
            @$cronJob->frequency_func = "One Time At";
        }

        $day = " ";
        if (@$cronJob->frequency_func == "weeklyOn") {
            $day = " " . SELF::getWeekDay(@$cronJob->frequency_func_arg_1) . " At ";
        }

        if (@$cronJob->frequency_func == "monthlyOn") {
            $day = " " . @$cronJob->frequency_func_arg_1 . " At ";
        }

        return SELF::removeCamelCase(@$cronJob->frequency_func) . $day . SELF::getTimeOnly(SELF::CTL($result->startDateTime));
    }

    public static function removeCamelCase($string)
    {
        return ucwords(preg_replace('/([a-z])([A-Z])/s', '$1 $2', $string));
    }

    public static function getTimeOnly($dateTime)
    {
        return @explode(" ", $dateTime)[1] . " " . @explode(" ", $dateTime)[2];
    }

    public static function uploadFile($filePath, $file, $fileName = "")
    {
        $filePath = strtolower(env('APP_ENV')) . "/" . strtolower(env('APP_NAME')) . "/" . $filePath;
        if (empty($fileName)) {
            if (\Storage::put($filePath, $file, 'public')) {
                return $filePath;
            }
        } else {
            return \Storage::putFileAs($filePath, $file, $fileName, 'public');
        }
    }

    public static function isJSON($string)
    {
        return is_string($string) && is_array(json_decode($string, true)) ? true : false;
    }

    public static function getAddressLatitudeLongitude($address){
        $address =urlencode($address); // Google HQ
        $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyA2R3EBUQfI5amMJRppG1JrG353e80w1uc');
        $output= json_decode($geocode);
        $latitude = $output->results[0]->geometry->location->lat;
        $longitude = $output->results[0]->geometry->location->lng;
        return ['latitude'=>$latitude,'longitude'=>$longitude];

    }
    public static function getOrganizationUrl(){
        return Session::get('selected_organization');
    }
}
