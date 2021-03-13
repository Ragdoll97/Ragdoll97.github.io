<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGallery extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $date = ['deleted_at'];
    protected $table = 'product_gallery';
    protected $hidden = ['created_at','updated_at'];
}
