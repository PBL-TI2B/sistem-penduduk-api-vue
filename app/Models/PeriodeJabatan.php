<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodeJabatan extends Model
{
    protected $guarded = [];
    public $table = 'periode_jabatan';

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
}
