<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $unique_name
 * @property string $path
 * @property string $bucket_amazon
 * @property boolean $active
 * @property string $created_at
 * @property string $updated_at
 * @property Store[] $stores
 */
class Image extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'unique_name', 'path', 'bucket_amazon', 'active', 'created_at', 'updated_at'];

    /**
     * The connection name for the model.
     * 
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stores()
    {
        return $this->hasMany('App\Models\Store');
    }
}
