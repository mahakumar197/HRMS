<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class feedback extends Model
{
    use HasFactory;
 

          protected $table = 'feedback';

          protected $fillable = ['feedback_date','type','regards','description','email'];


    Public function feeduser(){

    return $this->belongsTo(User::class);

  }

}