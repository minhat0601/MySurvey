<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $primaryKey = 'service_id';
    protected $fillable = [
        'name', 'create_at', 'update_at',
    ];
    protected $dateFormat = 'U';

}
