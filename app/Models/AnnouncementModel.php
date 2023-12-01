<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncementModel extends Model
{
    use HasFactory;

    protected $table = 'announcements';

    protected $fillable = ['title', 'description', 'status'];
    protected $guarded = ['id'];
}
