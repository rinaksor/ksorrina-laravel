<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    //Quy uoc ten table
    /*
    Ten Model: Post => table:posts'
    Ten Model: ProductCategory: product_categories
    */

    protected $table = 'posts';

    //Quy uoc khoas chinhs . mac dinh laravel se lay field id lam khoa chinh

    public $primaryKey = 'id';

    // public $incrementing = false;

    // protected $keyType = 'string';

    public $timestamps = true;

    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';

    protected $attributes = [
        'status' => 0
    ];
}
