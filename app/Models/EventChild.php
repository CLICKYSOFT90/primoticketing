<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class EventChild extends BaseModel
{
    public static $module = "EventManager";
    protected $table = "event_child";

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
        'name',
        'event_start',
        'event_end',
        'event_icon',
        'address',
        'active'
    ];

    public function parentEvent()
    {
        return $this->belongsTo(EventParent::class, 'parent_event_id', 'id');
    }

    public static function getList()
    {
        $return = self::with('parentEvent')->where('event_start','>',date('Y-m-d 23:59:59'))
            ->orderBy('event_start','ASC')->get();
        return $return;
    }

    public static function actionButtons($data){
        $return = '<div class="btn-group" role="group">';

        if(\Common::canUpdate(static::$module)) {
            $return .= '<a class="" href="'.route('eventManager.edit', $data->parentEvent->id).'" title="Edit">
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

}
