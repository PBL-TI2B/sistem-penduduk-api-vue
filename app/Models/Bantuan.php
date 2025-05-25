<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Bantuan extends Model
{
    protected $guarded = [];
    public $table = 'bantuan';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = Str::uuid();
            }
        });
    }

    public function kategoriBantuan()
    {
        return $this->belongsTo(KategoriBantuan::class, 'kategori_bantuan_id', 'id');
    }

    public function penerimaBantuan()
    {
        return $this->hasMany(PenerimaBantuan::class, 'bantuan_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
