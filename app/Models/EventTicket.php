<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class EventTicket extends BaseModel
{
    public static $module = "EventManager";
    protected $table = "event_tickets";

    public static function boot(){
        parent::boot();
        static::addGlobalScope('organizationScope', function (Builder $builder) {
            $builder->where('organization_id', '=', Admin::loggedUserData()['organizationId']);
        });
    }

    protected $fillable = [
        'id',
        'organization_id',
        'parent_event_id',
        'ticket_type_id',
        'ticket_type_name',
        'ticket_default_price',
        'ticket_default_limit'
    ];

    public static function validationRules(){
        $rules['TTRow.*.name'] = ['required','distinct'];
        $rules['TTRow.*.type'] = ['required'];
        $rules['TTRow.*.event_type_id'] = ['required'];
        $rules['TTRow.*.default_price'] = ['required','numeric'];
        $rules['TTRow.*.default_limit'] = ['required','numeric'];
        return $rules;
    }

    public static function validationMsgs(){
        $msgs = [];
        foreach(request()->input('TTRow') as $key => $value) {
            $msgs['TTRow.'.$key.'.name.required'] = 'Ticket type name is required on row #'.$key.".";
            $msgs['TTRow.'.$key.'.name.distinct'] = 'Ticket type name is duplicate on row #'.$key.".";
            $msgs['TTRow.'.$key.'.type.required'] = 'Ticket type name is required on row #'.$key.".";
            $msgs['TTRow.'.$key.'.event_type_id.required'] = 'Ticket Event Type is required on row #'.$key.".";
            $msgs['TTRow.'.$key.'.default_price.required'] = 'Default price is required on row #'.$key.".";
            $msgs['TTRow.'.$key.'.default_price.numeric'] = 'Only numeric data is allowed in default price field on row #'.$key.".";
            $msgs['TTRow.'.$key.'.default_limit.required'] = 'Default limit is required on row #'.$key.".";
            $msgs['TTRow.'.$key.'.default_limit.numeric'] = 'Only numeric data is allowed in default limit field on row #'.$key.".";
        }
        return $msgs;
    }
}
