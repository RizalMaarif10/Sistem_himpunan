<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventClick extends Model
{
    public $timestamps = false;
    protected $fillable = ['event_id','clicked_at','ip','user_agent'];
    protected $casts = ['clicked_at'=>'datetime'];

    public function event() { return $this->belongsTo(Event::class); }
}
