<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Rt extends Model
{
    protected $guarded = [];
    public $table = 'rt';

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

    public function rw() {
        return $this->belongsTo(Rw::class);
    }

    public function perangkatDesa() {
        return $this->hasOne(PerangkatDesa::class);
    }

    public function domisili() {
        return $this->hasOne(Domisili::class);
    }
}