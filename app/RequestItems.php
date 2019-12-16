<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestItems extends Model
{
    use SoftDeletes;

    protected $table = 'request_items';
    protected $casts = [
        'cost' => 'array',
    ];

    // total
    public function getTotalAttribute($total)
    {
        return $total / 100;
    }

    public function setTotalAttribute($total)
    {
        $this->attributes['total'] = $total * 100;
    }
    
    public function request()
    {
        return $this->belongsTo(Requests::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function request_items_line()
    {
        return $this->hasMany(RequestItemsLine::class,'request_items_id','id');
    }
}
