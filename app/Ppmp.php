<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ppmp extends Model
{
	use SoftDeletes;

    protected $casts = [
        'prepared' => 'array',
        'recommended' => 'array',
        'evaluated' => 'array',
        'approved' => 'array',
    ];

    public function getCustomIdAttribute(){
        return "PPMP-".str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function app()
    {
        return $this->hasMany(App::class,'ppmp_id','id');
    }

    public function item()
    {
        return $this->hasMany(Item::class,'ppmp_id','id');
    }
}
