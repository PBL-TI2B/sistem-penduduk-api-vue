<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KategoriBantuan extends Model
{
    protected $table = 'kategori_bantuan';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = Str::uuid();
            }
        });
    }

    public $incrementing = false;
    protected $keyType = 'string';

    public function bantuan()
    {
        return $this->hasMany(Bantuan::class, 'kategori_bantuan_id', 'id');
    }
}
