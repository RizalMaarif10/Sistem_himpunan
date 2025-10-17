<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $fillable = [
        'user_id','title','slug','description','location','start_at','end_at',
        'registration_link','cover_image','status'
    ];
    protected $casts = ['start_at'=>'datetime','end_at'=>'datetime'];

    protected static function booted() {
        static::creating(function ($m) {
            if (empty($m->slug)) $m->slug = Str::slug($m->title.'-'.Str::random(4));
        });
    }

    public function user()   { return $this->belongsTo(User::class); }
    public function clicks() { return $this->hasMany(EventClick::class); }
}
