<?php

namespace App\Models;

use App\Models\UserRole;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends BaseModel
{

    public static $module = "Notification";

    public $fillable = ['model', 'model_id', 'url', 'title', 'description', 'read_at'];

    public function scopeUnread($q)
    {
        return $q->where('read_at', '=', null);
    }

}
