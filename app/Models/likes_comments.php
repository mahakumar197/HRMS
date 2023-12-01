<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class likes_comments extends Model
{
    use HasFactory;
        protected $table = 'likes_comments';

    protected $fillable = ['comments', 'likes'];
    protected $guarded = ['id'];
    Public function user(){

        return $this->belongsTo(User::class);

    }
    Public function announcements(){
        return $this->belongsTo(announcements::class);
    }

}
