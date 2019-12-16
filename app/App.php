<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class App extends Model
{
    use SoftDeletes;

    protected $casts = [
        'prepared' => 'array',
        'recommended' => 'array',
        'approved' => 'array',
    ];

    public function getCustomIdAttribute(){
        return "APP-".str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function ppmp()
    {
        return $this->belongsTo(Ppmp::class);
    }

    public function item()
    {
        return $this->hasMany(Item::class,'app_id','id');
    }

    public function request()
    {
        return $this->hasMany(Requests::class,'app_id','id');
    }
}
