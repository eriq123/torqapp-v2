<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'course_name','department_id'
    ];
    public $timestamps = false;    

    // Supplies
    public function getSuppliesAttribute($Supplies)
    {
        return $Supplies / 100;
    }

    public function setSuppliesAttribute($Supplies)
    {
        $this->attributes['Supplies'] = $Supplies * 100;
    }

    // Equipment
    public function getEquipmentAttribute($Equipment)
    {
        return $Equipment / 100;
    }

    public function setEquipmentAttribute($Equipment)
    {
        $this->attributes['Equipment'] = $Equipment * 100;
    }

    // Supplemental
    public function getSupplementalAttribute($Supplemental)
    {
        return $Supplemental / 100;
    }

    public function setSupplementalAttribute($Supplemental)
    {
        $this->attributes['Supplemental'] = $Supplemental * 100;
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function user()
    {
        return $this->hasMany(User::class,'course_id','id');
    }

    public function ppmp()
    {
        return $this->hasMany(Ppmp::class,'course_id','id');
    }

}
