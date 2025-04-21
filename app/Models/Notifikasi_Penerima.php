<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi_Penerima extends Model
{
    protected $guarded = [];
    public $table = 'notifikasi_penerima';

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
