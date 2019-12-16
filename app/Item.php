<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;
    
    // Cost
    public function getCostAttribute($Cost)
    {
        return $Cost / 100;
    }

    public function setCostAttribute($Cost)
    {
        $this->attributes['Cost'] = $Cost * 100;
    }

    // total
    public function getTotalAttribute($total)
    {
        return $total / 100;
    }

    public function setTotalAttribute($total)
    {
        $this->attributes['total'] = $total * 100;
    }

    public function ppmp()
    {
        return $this->belongsTo(Ppmp::class);
    }

    public function app()
    {
        return $this->belongsTo(App::class);
    }

    public function request_item()
    {
        return $this->hasMany(RequestItems::class,'item_id','id');
    }
}
