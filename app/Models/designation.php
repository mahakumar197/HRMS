<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class designation extends Model
{
    use HasFactory;

    protected $fillable = ['designation'];
    protected $table = 'designation';
    protected $guarded = ['id'];


   
}
