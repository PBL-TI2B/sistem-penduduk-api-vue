<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AnggotaKeluarga extends Model
{
    protected $guarded = [];
    public $table = 'anggota_keluarga';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = Str::uuid(); 
            }
        });
    }
}
