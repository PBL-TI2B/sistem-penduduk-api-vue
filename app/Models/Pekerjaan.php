<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pekerjaan extends Model
{
    protected $guarded = [];
    public $table = 'pekerjaan';


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
        return $this->hasMany(Penduduk::class, 'pekerjaan_id', 'id');
    }
}
