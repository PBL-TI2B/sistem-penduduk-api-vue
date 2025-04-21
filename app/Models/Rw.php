<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Rw extends Model
{
    protected $guarded = [];
    public $table = 'rw';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = Str::uuid(); // Generate UUID saat create jika belum ada
            }
        });
    }
}
