<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;
class Article extends Model
{
    //
    protected $table = 'article';
    public $timestamps = false;
    protected $fillable = [
        'title', 'user_id', 'ctime','etime','description','contents','img','term','type','count','sort','status','hot','recommend','is_delete','classify'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment','article_id','id')->where('parent_id',0);
    }

    static public function financeInfo($gid)
    {
        return Cache::remember('finance', 300, function () use($gid) {
            $data = [];
            $data = finance($gid);
            return $data;
        });
    }

    public function type_name()
    {
        return $this->hasOne(TypeArticle::class , 'id','classify' );
    }
}









