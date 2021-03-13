<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variant extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $date = ['deleted_at'];
    protected $table = 'product_inventory_variant';
    protected $hidden = ['created_at','updated_at'];
}
