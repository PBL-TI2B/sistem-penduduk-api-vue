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

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function kk()
    {
        return $this->belongsTo(KartuKeluarga::class, 'kk_id', 'id');
    }

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id', 'id');
    }

    public function statusKeluarga()
    {
        return $this->belongsTo(StatusKeluarga::class, 'status_keluarga_id', 'id');
    }
}
