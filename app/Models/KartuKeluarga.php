<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KartuKeluarga extends Model
{
    protected $table = 'kartu_keluarga'; // Nama tabel di database
    protected $guarded = []; // Agar dapat diisi massal
    public $incrementing = false; // Menggunakan UUID sebagai primary key
    protected $keyType = 'string'; // Jenis key adalah string (UUID)

    protected static function boot()
    {
        parent::boot();

        // Menghasilkan UUID ketika membuat record baru
        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    // Menentukan key route yang digunakan
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    // Relasi dengan model AnggotaKeluarga
    public function anggotaKeluarga()
    {
        return $this->hasMany(AnggotaKeluarga::class, 'kk_id', 'uuid');
    }

    public function rt()
    {
        return $this->belongsTo(Rt::class, 'rt_id', 'id');
    }
}
