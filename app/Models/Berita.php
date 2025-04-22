<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Berita extends Model
{
    protected $guarded = [];
    public $table = 'berita';

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

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected function thumbnail() 
    {
        return Attribute::make(
            get: fn ($thumbnail) => url('/storage/berita/' . $thumbnail),
        );
    }
}
