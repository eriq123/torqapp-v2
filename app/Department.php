<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
   		'department_name'
    ];
    public $timestamps = false;
    
    public function getNameAttribute()
    {
        return ucfirst($this->department_name);
    }

    public function course()
    {
        return $this->hasMany(Course::class,'department_id','id');
    }

    public function user()
    {
        return $this->hasMany(User::class,'department_id','id');
    }
}
