<?php namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $table = 'roles';
    public $timestamps = false;
    protected $fillable = [
        'name','display_name','description'
    ];
}



