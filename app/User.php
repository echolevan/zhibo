<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $fillable = [
        'name','oauth_id','phone', 'password','thumb','gold','type','status','created_at','login_time'
        ,'ip','level','online_time','sign','pid','award','fake'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function lecturer()
    {
        return $this->hasOne('App\Models\Lecturer');
    }

    public function history()
    {
        return $this->hasOne('App\Models\Live_history');
    }

    public function oauth()
    {
        return $this->belongsTo('App\Models\Oauth');
    }
    //查看下级会员 关联
    public function children()
    {
        return $this->hasMany('App\User','pid');
    }

}
