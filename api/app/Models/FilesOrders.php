<?php

namespace App;

use App\Models\File;
use App\Models\Orders;
use Illuminate\Database\Eloquent\Model;

class FilesOrders extends Model
{
    protected $table = 'files_orders';
    protected $fillable = [
        'id', 'order_id', 'file_id', 'active'
    ];

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function orders()
    {
        return $this->hasMany(Orders::class);
    }
}
