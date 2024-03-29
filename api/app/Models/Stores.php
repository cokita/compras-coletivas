<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    protected $table = 'stores';
    protected $fillable = [
        'id', 'name', 'active', 'user_id', 'description', 'image_id', 'file_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function usersPivot()
    {
        return $this->belongsToMany(User::class, 'stores_users',
            'store_id', 'user_id')->withTimestamps();
    }

    public function users()
    {
        return $this->hasMany(StoresUsers::class, 'store_id', 'id');
    }

    public function image()
    {
        return $this->hasOne(File::class, 'id', 'image_id');
    }

    public function file()
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }
}
