<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleModel extends Model
{
    use HasFactory;
    protected $table ='tb_article';
    protected $fillable = [
        'id' , 'uuid' , 'date' , 'image_article' , 'doc_image' , 'title' , 'author' , 'description' , 'created_at' , 'updated_at'
    ];
}
