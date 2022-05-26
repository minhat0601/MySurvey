<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $primaryKey = 'survey_id';
    protected $fillable = [
        'create_at', 'update_at', 'user_id', 'service_id', 'customer_id',
    ];
    protected $dateFormat = 'U';
}
