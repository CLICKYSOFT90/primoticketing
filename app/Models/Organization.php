<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Organization extends BaseModel implements HasMedia
{
    use InteractsWithMedia;
    public static $module = "Organizations";

    protected $fillable = [
        'id',
        'agent_name',
        'agent_phone_number',
        'organization_contact_name',
        'organization_contact_phone_number',
        'organization_name',
        'email',
        'organization_icon',
        'organization_website',
        'organization_unique_url',
        'active'
    ];

    public static function getList(){
        $return = self::with('user')->get();
        return $return;
    }

    public static function actionButtons($data){
        $return = '<div class="btn-group" role="group">';

        if(\Common::canUpdate(static::$module)) {
          $return .= '<a class="" href="'.route('organization.edit', $data->id).'" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>';
        }

       /* if(\Common::canDelete(static::$module)) {
           $return .= '<form class="form-inline" action="'.route('organization.destroy', $data->id).'" method="post" id="delete_form_'.$data->id.'">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <a class=" delete-confirm-id" title="Delete" data-id="'.$data->id.'">
                                <i class="fas fa-trash"></i>
                            </a>
                        </form>';
        }*/
        $return .= '</div>';
        return $return;
    }

    public static function validationRules($id = 0){
        $rules['agent_name'] = ['required'];
        $rules['agent_phone_number'] = ['required','numeric'];
        $rules['organization_contact_name'] = ['required'];
        $rules['organization_contact_phone_number'] = ['required','numeric'];
        $rules['organization_name'] = ['required'];
        $rules['email'] = ['required','email','unique:organizations,email,'.$id];
        $rules['organization_unique_url'] = ['required','regex:/^\S*$/u','unique:organizations,organization_unique_url,'.$id];
        $rules['active'] = [Rule::in(["1","0"])];
        return $rules;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function salesLead(){
        return $this->hasMany(SalesLead::class, 'customerId', 'id');
    }
}
