<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestItemsLine extends Model
{
    use SoftDeletes;

    protected $table = 'request_items_line';

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('m/d/Y - H:i');
    }
    public function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('m/d/Y - H:i');
    }
    
    
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
        
    public function request_item()
    {
        return $this->belongsTo(RequestItems::class);
    }

}
