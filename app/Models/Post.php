<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = ['user_id','title','slug','excerpt','content','cover_image','status','published_at'];
    protected $casts = ['published_at'=>'datetime'];

    protected static function booted() {
        static::creating(function ($m) {
            if (empty($m->slug)) $m->slug = Str::slug($m->title.'-'.Str::random(4));
        });
    }

    public function user() { return $this->belongsTo(User::class); }
}
