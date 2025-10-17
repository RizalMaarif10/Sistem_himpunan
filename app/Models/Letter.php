<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model {
  protected $fillable = ['type','number','date','from_name','to_name','subject','notes','file_path','user_id','read_at'];
  protected $casts = ['date'=>'date','read_at'=>'datetime'];
  public function user(){ return $this->belongsTo(User::class); }
}
