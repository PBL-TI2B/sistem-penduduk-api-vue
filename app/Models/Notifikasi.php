<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $guarded = [];
    public $table = 'notifikasi';

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

    public function user()
    {
        return $this->belongsTo(User::class, 'aksi_user_id', 'id');
    }

    public function notifikasiPenerima()
    {
        return $this->hasMany(Notifikasi_Penerima::class, 'notifikasi_id', 'id');
    }
}
