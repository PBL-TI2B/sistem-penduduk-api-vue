<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Penduduk extends Model
{
    protected $guarded = [];
    public $table = 'penduduk';

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

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_id', 'id');
    }

    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class, 'pendidikan_id', 'id');
    }

    public function ayah()
    {
        return $this->belongsTo(Penduduk::class, 'ayah_id', 'id');
    }

    public function ibu()
    {
        return $this->belongsTo(Penduduk::class, 'ibu_id', 'id');
    }

    protected function foto() 
    {
        return Attribute::make(
            get: fn ($foto) => url('/storage/penduduk/' . $foto),
        );
    }
}
