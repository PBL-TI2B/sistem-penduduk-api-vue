<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Desa extends Model
{
    protected $guarded = [];
    public $table = 'desa';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = Str::uuid();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function dusun()
    {
        return $this->hasMany(Dusun::class, 'desa_id', 'id');
    }

    public function perangkatDesa()
    {
        return $this->hasOne(PerangkatDesa::class, 'desa_id', 'id');
    }
}
