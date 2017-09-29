<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeArticle extends Model
{
    //
    public $timestamps = false;
    protected $guarded = [];
    protected $table = 'type_article';

    public function articles()
    {
        return $this->hasMany(Article::class  ,'classify' ,'id');
    }
}
