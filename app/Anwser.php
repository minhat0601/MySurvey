<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anwser extends Model
{
    protected $primaryKey = 'anwser_id';
    protected $fillable = ['name', 'question_id', 'note_require', 'option_question', 'created_at', 'updated_at'];
    protected $dateFormat = 'U';
}
