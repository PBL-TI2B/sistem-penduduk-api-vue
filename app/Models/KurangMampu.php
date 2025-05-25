<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KurangMampu extends Model
{
    protected $guarded = [];
    public $table = 'kurang_mampu';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = Str::uuid();
            }
        });
    }
    public function anggotaKeluarga()
    {
        return $this->belongsTo(AnggotaKeluarga::class, 'anggota_keluarga_id', 'id');
    }

    public function penerimaBantuan()
    {
        return $this->hasMany(PenerimaBantuan::class, 'kurang_mampu_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
