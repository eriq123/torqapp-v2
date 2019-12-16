<?php

namespace App;

use Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    protected $guard_name = 'web';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','first_name', 'last_name', 'username', 'password', 'department_id','course_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getRoleNameAttribute()
    {
        $user = Auth::user()->roles()->first();

        return $user->name;
    }

    public function getFullNameAttribute()
    {
        if ($this->title) {
            return ucfirst($this->title)." ".ucfirst($this->first_name)." ".ucfirst($this->last_name);
        }else{
            return ucfirst($this->first_name)." ".ucfirst($this->last_name);
        }
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function ppmp()
    {
        return $this->hasMany(Ppmp::class,'user_id','id');
    }
}
