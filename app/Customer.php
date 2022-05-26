<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $primaryKey = 'customer_id';
    protected $fillable = ['fullname', 'address', 'phone', 'email', 'created_at', 'updated_at', 'user_id'];
    protected $dateFormat = 'U';
}
