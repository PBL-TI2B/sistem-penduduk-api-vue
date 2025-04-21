<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Domisili extends Model
{
    protected $guarded = [];
    public $table = 'domisili';

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

    public function rt() {
        return $this->belongsTo(Rt::class, 'rt_id', 'id');
    }

    public function penduduk() {
        return $this->belongsTo(Penduduk::class, 'penduduk_id', 'id');
    }
}
