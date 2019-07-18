<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilesType extends Model
{
    protected $table = 'files_type';
    protected $fillable = [
        'id', 'name', 'active'
    ];
}
