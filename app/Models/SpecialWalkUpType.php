<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SpecialWalkUpType extends BaseModel
{
    public static $module = "GlobalSettings";
    protected $table = "special_walk_up_types";

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
        $rules['WTRow.*.name'] = ['required','distinct'];
        return $rules;
    }

    public static function validationMsgs(){
        $msgs = [];
        foreach(request()->input('WTRow') as $key => $value) {
            $msgs['WTRow.'.$key.'.name.required'] = 'Walk-up Name is required on row #'.$key.".";
            $msgs['WTRow.'.$key.'.name.distinct'] = 'Walk-up Name is duplicate on row #'.$key.".";
        }
        return $msgs;
    }
}
