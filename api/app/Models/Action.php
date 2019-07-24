<?php

namespace App\Models;

use App\Services\FileService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property boolean $active
 * @property string $created_at
 * @property string $name
 * @property string $description
 * @property string $method
 */
class Action extends Model
{
    protected $table = 'actions';
    protected $fillable = ['name', 'description', 'method', 'active'];


}
