<?php
// app/Models/Transaction.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
  protected $fillable = ['date','type','category_id','account_id','amount','ref','description','user_id'];
  protected $casts = ['date' => 'date'];
  public function category(){ return $this->belongsTo(Category::class); }
  public function account(){ return $this->belongsTo(Account::class); }
  public function user(){ return $this->belongsTo(User::class); }
  /* scope kecil: */
  public function scopeIncome($q){ return $q->where('type','income'); }
  public function scopeExpense($q){ return $q->where('type','expense'); }
}
