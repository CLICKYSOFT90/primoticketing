<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class EventType extends BaseModel
{
    public static $module = "GlobalSettings";
    protected $table = "event_types";

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
        'active'
    ];

    public static function validationRules(){
        $rules['ETRow.*.name'] = ['required','distinct'];
        return $rules;
    }

    public static function validationMsgs(){
        $msgs = [];
        foreach(request()->input('ETRow') as $key => $value) {
            $msgs['ETRow.'.$key.'.name.required'] = 'Event name is required on row #'.$key.".";
            $msgs['ETRow.'.$key.'.name.distinct'] = 'Event name is duplicate on row #'.$key.".";
        }
        return $msgs;
    }
}
