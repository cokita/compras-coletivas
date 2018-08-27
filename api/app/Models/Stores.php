<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    protected $table = 'stores';
    protected $fillable = [
        'id', 'name', 'active', 'user_id', 'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'stores_users',
            'store_id', 'user_id')->withTimestamps();
    }

    public function image()
    {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }
}
