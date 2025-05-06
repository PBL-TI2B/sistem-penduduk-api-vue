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

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function notifikasi()
    {
        return $this->belongsTo(Notifikasi::class, 'notifikasi_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(Penduduk::class, 'penerima_id', 'id');
    }
    
}
