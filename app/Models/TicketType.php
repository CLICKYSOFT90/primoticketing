<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class TicketType extends BaseModel
{
    public static $module = "GlobalSettings";
    protected $table = "ticket_types";

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
        'type',
        'event_type_id',
        'default_price',
        'default_limit',
        'active'
    ];


    public static function validationRules($id = 0){
        $rules['name'] = ['required',function($attr,$value,$fail) use ($id){
              $nameCheck = self::where('id','!=',$id)->where('name','=',$value)->count();
              if($nameCheck > 0){
                  $fail("Ticket name already exists.");
              }
        }];
        $rules['type'] = ['required'];
        $rules['event_type_id'] = ['required','exists:event_types,id'];
        $rules['default_price'] = ['required','numeric'];
        $rules['default_limit'] = ['required','numeric'];
        return $rules;
    }
}
