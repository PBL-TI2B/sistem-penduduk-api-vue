<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PerangkatDesa extends Model
{
    protected $guarded = [];
    public $table = 'perangkat_desa';

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

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id', 'id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id', 'id');
    }

    public function periode_jabatan()
    {
        return $this->belongsTo(PeriodeJabatan::class, 'periode_jabatan_id', 'id');
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'desa_id', 'id');
    }

    public function dusun()
    {
        return $this->belongsTo(Dusun::class, 'dusun_id', 'id');
    }

    public function rw()
    {
        return $this->belongsTo(Rw::class, 'rw_id', 'id');
    }
    
    public function rt()
    {
        return $this->belongsTo(Rt::class, 'rt_id', 'id'); 
    }
}