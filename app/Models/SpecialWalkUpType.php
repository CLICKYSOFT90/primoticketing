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
            $builder->where('organization_id', '=', Admin::loggedUserData()['organization_id']);
        });
    }

    protected $fillable = [
        'id',
        'organization_id',
        'name',
        'active'
    ];


    public static function validationRules($id = 0){
        $rules['name'] = ['required',function($attr,$value,$fail) use ($id){
              $nameCheck = self::where('id','!=',$id)->where('name','=',$value)->count();
              if($nameCheck > 0){
                  $fail("Walk Up type name already exists.");
              }
        }];
        return $rules;
    }
}
