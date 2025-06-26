<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RiwayatBantuan extends Model
{
    protected $guarded = [];
    public $table = 'riwayat_bantuan';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = Str::uuid();
            }
        });
    }

    protected $casts = [
        'tanggal_penerimaan' => 'date', // Ini akan memastikan Laravel mengonversi ke format DATE yang benar
    ];

    public function penerimaBantuan()
    {
        return $this->belongsTo(PenerimaBantuan::class, 'penerima_bantuan_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}