<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $primaryKey = 'question_id';
    protected $fillable = ['question', 'note_require', 'created_at', 'updated_at'];
    protected $dateFormat = 'U';
}
