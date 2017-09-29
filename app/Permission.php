<?php namespace App;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $table = 'permission';
    public $timestamps = false;
    protected $fillable = [
        'name','display_name','description','pid','level'
    ];

    static function get_permissions()
    {
        return self::with(['children' =>function($query){
            $query->orderBy('id','asc');
        }])->where('pid',0)->orderBy('id','asc')->get();

    }

    public function children()
    {
        return $this->hasMany('App\Permission','pid','id');
    }

}