<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KategoriBantuan extends Model
{
    protected $guarded = [];
    protected $table = 'kategori_bantuan';
    public $incrementing = true;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = Str::uuid();
            }
        });
    }

    public function bantuan()
    {
        return $this->hasMany(Bantuan::class, 'kategori_bantuan_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
