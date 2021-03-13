<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductList extends Model
{
    use HasFactory;
    
    protected $date = ['deleted_at'];
    protected $table = 'cart';
    protected $hidden = ['created_at','updated_at'];
}
