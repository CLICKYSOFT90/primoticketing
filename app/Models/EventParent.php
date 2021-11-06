<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class EventParent extends BaseModel
{
    public static $module = "EventManager";
    protected $table = "event_parent";

    public static function boot(){
        parent::boot();
        static::addGlobalScope('organizationScope', function (Builder $builder) {
            $builder->where('organization_id', '=', Admin::loggedUserData()['organizationId']);
        });
    }

    protected $fillable = [
        'id',
        'organization_id',
        'name',
        'event_type_id',
        'event_photo',
        'event_gallery',
        'default_limit',
        'active'
    ];

    public function childEvent()
    {
        return $this->hasMany(EventChild::class, 'parent_event_id', 'id');
    }

    public function parentEventTicket()
    {
        return $this->hasMany(EventTicket::class, 'parent_event_id', 'id');
    }

    public static function getList()
    {
        $return = self::with('childEvent')->get();
        return $return;
    }

    public static function actionButtons($data){
        $return = '<div class="btn-group" role="group">';

        if(\Common::canUpdate(static::$module)) {
            $return .= '<a class="" href="'.route('eventManager.edit', $data->id).'" title="Edit">
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

    public static function validationRules($id=0){
        $rules['name'] = ['required'];
        $rules['event_type_id'] = ['required'];

        $rules['event_photo_file'] = [$id==0 ? 'required' : 'nullable','mimes:jpeg,png,jpg,gif,svg|max:2048'];
        $rules['event_gallery_file'] = [$id==0 ? 'required' : 'nullable','mimes:jpeg,png,jpg,gif,svg|max:2048'];

        $rules['CERow.*.name'] = ['required'];
        $rules['CERow.*.event_icon'] = [$id==0 ? 'required' : 'nullable','mimes:jpeg,png,jpg,gif,svg|max:2048'];
        $rules['CERow.*.event_start'] = ['required','date','after:'.date('Y-m-d')];
        $rules['CERow.*.event_end'] = ['required','date','after:CERow.*.event_start'];
        $rules['CERow.*.address'] = ['required'];

        $rules['TTRow.*.ticket_type_id'] = ['required','distinct'];
        $rules['TTRow.*.ticket_default_price'] = ['required','numeric'];
        $rules['TTRow.*.ticket_default_limit'] = ['required','numeric'];
        return $rules;
    }

    public static function validationMsgs(){
        $msgs = [];
        $msgs['name.required'] = 'Event name is required.';
        $msgs['event_type_id.required'] = 'Event type is required.';

        $msgs['event_photo_file.required'] = 'Event photo is required.';
        $msgs['event_photo_file.mimes'] = 'Event photo only allowed the following format(jpeg,png,jpg,gif,svg).';
        $msgs['event_photo_file.max'] = 'Event photo maximum file size is 2 Mb.';

        $msgs['event_gallery_file.required'] = 'Event gallery photo is required.';
        $msgs['event_gallery_file.mimes'] = 'Event gallery photo only allowed the following format(jpeg,png,jpg,gif,svg).';
        $msgs['event_gallery_file.max'] = 'Event gallery photo maximum file size is 2 Mb.';

        foreach(request()->input('CERow') as $key => $value) {
            $msgs['CERow.'.$key.'.name.required'] = 'Event List event name is required on row #'.$key.".";

            $msgs['CERow.'.$key.'.event_icon.required'] = 'Event List event icon is required on row #'.$key.".";
            $msgs['CERow.'.$key.'.event_icon.mimes'] = 'Event List event icon only allowed the following format(jpeg,png,jpg,gif,svg) on row #'.$key.".";
            $msgs['CERow.'.$key.'.event_icon.max'] = 'Event List event icon maximum file size is 2 Mb. on row #'.$key.".";

            $msgs['CERow.'.$key.'.event_start.required'] = 'Event List start date is required on row #'.$key.".";
            $msgs['CERow.'.$key.'.event_end.required'] = 'Event List end date is required on row #'.$key.".";
            $msgs['CERow.'.$key.'.event_start.date'] = 'Event List start date is invalid on row #'.$key.".";
            $msgs['CERow.'.$key.'.event_end.date'] = 'Event List end date is invalid on row #'.$key.".";
            $msgs['CERow.'.$key.'.event_start.after'] = 'Event List start date should be greater than current date on row #'.$key.".";
            $msgs['CERow.'.$key.'.event_end.after'] = 'Event List end date should be greater than start date on row #'.$key.".";

            $msgs['CERow.'.$key.'.address.required'] = 'Event List address is required on row #'.$key.".";

            $msgs['TTRow.'.$key.'.ticket_type_id.required'] = 'Ticket name is required on row #'.$key.".";
            $msgs['ETRow.'.$key.'.ticket_type_id.distinct'] = 'Ticket name is duplicate on row #'.$key.".";

            $msgs['TTRow.'.$key.'.ticket_default_price.required'] = 'Default price is required on row #'.$key.".";
            $msgs['TTRow.'.$key.'.ticket_default_price.numeric'] = 'Only numeric data is allowed in default price field on row #'.$key.".";

            $msgs['TTRow.'.$key.'.ticket_default_limit.required'] = 'Default limit is required on row #'.$key.".";
            $msgs['TTRow.'.$key.'.ticket_default_limit.numeric'] = 'Only numeric data is allowed in default limit field on row #'.$key.".";
        }
        return $msgs;
    }
}
