<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission as Model;

class Permission extends Model
{
    public $table = 'permissions';

    public $fillable = [
        'name',
        'guard_name',
        'module',
        'created_by',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'guard_name' => 'string',
        'module' => 'string',
        'created_by' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = Auth::user() ? Auth::user()->id : null;
        });
    }

    protected $appends = ['permission_data'];

    public function getPermissionDataAttribute()
    {
        return $this->permissions->pluck('id', 'id');
    }

    public function permissionModule()
    {
        return $this->belongsTo(Module::class, 'module');
    }

    public function messages()
    {
        return ['name.*.unique' => 'Firstname of the user is required'];
    }

    public function modules()
    {
        return $this->belongsTo(Module::class, 'module');
    }
}
