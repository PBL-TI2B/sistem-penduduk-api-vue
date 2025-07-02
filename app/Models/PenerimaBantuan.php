<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PenerimaBantuan extends Model
{
    protected $guarded = [];
    public $table = 'penerima_bantuan';

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

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }

    public function kurangMampu()
    {
        return $this->belongsTo(KurangMampu::class, 'kurang_mampu_id', 'id');
    }
    public function bantuan()
    {
        return $this->belongsTo(Bantuan::class, 'bantuan_id', 'id');
    }

    public function riwayatBantuan()
    {
        return $this->hasMany(RiwayatBantuan::class, 'penerima_bantuan_id', 'id');
    }
}