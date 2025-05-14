<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Dusun extends Model
{
    protected $guarded = [];
    public $table = 'dusun';

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

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    public function perangkatDesa()
    {
        return $this->hasOne(PerangkatDesa::class);
    }

    public function rw()
    {
        return $this->hasMany(Rw::class);
    }
}
