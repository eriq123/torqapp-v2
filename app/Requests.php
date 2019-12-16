<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requests extends Model
{
	use SoftDeletes;

    protected $table = 'requests';
    protected $casts = [
        'content' => 'array',
        'section_head' => 'array',
        'department_head' => 'array',
        'adaa' => 'array',
        'campus_director' => 'array',
        'attachment' => 'array',
    ];

    public function getCustomIdAttribute(){
        return "REQUEST-".str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function app()
    {
        return $this->belongsTo(App::class);
    }

    public function request_item()
    {
        return $this->hasMany(RequestItems::class,'request_id','id');
    }

    public function progress()
    {
        return $this->hasMany(Progress::class,'request_id','id');
    }

}
