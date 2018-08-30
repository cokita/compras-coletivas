<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property boolean $active
 * @property string $bucket_amazon
 * @property string $created_at
 * @property string $name
 * @property string $path
 * @property string $unique_name
 * @property string $updated_at
 * @property Stores[] $stores_files
 * @property Stores[] $stores_images
 */
class File extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'active', 'bucket_amazon', 'created_at', 'name', 'path', 'unique_name', 'updated_at'];

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stores_files()
    {
        return $this->hasMany('App\Models\Store', 'file_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stores_images()
    {
        return $this->hasMany('App\Models\Store', 'image_id');
    }

    /**
     * @return BelongsTo User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
