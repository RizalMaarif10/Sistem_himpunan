<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Minute extends Model {
  protected $fillable = ['title','meeting_date','notes','file_path','user_id'];
  protected $casts = ['meeting_date'=>'date'];
  public function user(){ return $this->belongsTo(User::class); }
}
