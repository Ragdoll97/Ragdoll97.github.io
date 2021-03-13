<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class favorite extends Model
{
    use HasFactory;
    
    protected $date = ['deleted_at'];
    protected $table = 'user_favorites';
    protected $hidden = ['created_at','updated_at'];
}
