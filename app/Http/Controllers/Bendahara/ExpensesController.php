<?php
namespace App\Http\Controllers\Bendahara;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Account;
use Illuminate\Http\Request;

class ExpensesController extends Controller {
  public function index(){ $items = Transaction::expense()->latest('date')->paginate(15); return view('bendahara.expenses.index', compact('items')); }
  public function create(){
    $tx = new Transaction(['date'=>now()->toDateString()]);
    $categories = Category::where('type','expense')->orderBy('name')->get();
    $accounts   = Account::orderBy('name')->get();
    return view('bendahara.expenses.create', compact('tx','categories','accounts'));
  }
  public function store(Request $r){
    $data = $this->validated($r); $data['type']='expense'; $data['user_id']=auth()->id();
    $tx = Transaction::create($data);
    return redirect()->route('bendahara.expenses.edit',$tx)->with('success','Pengeluaran disimpan.');
  }
  public function edit(Transaction $expense){
    abort_unless($expense->type==='expense', 404);
    $tx=$expense; $categories=Category::where('type','expense')->orderBy('name')->get(); $accounts=Account::orderBy('name')->get();
    return view('bendahara.expenses.edit', compact('tx','categories','accounts'));
  }
  public function update(Request $r, Transaction $expense){
    abort_unless($expense->type==='expense', 404);
    $data = $this->validated($r); $data['type']='expense'; $expense->update($data);
    return back()->with('success','Pengeluaran diperbarui.');
  }
  public function destroy(Transaction $expense){
    abort_unless($expense->type==='expense', 404);
    $expense->delete(); return redirect()->route('bendahara.expenses.index')->with('success','Data dihapus.');
  }
  private function validated(Request $r): array{
    return $r->validate([
      'date'=>'required|date','category_id'=>'required|exists:categories,id',
      'account_id'=>'required|exists:accounts,id','amount'=>'required|numeric|min:0',
      'ref'=>'nullable|string|max:100','description'=>'nullable|string'
    ],[],['date'=>'Tanggal','category_id'=>'Kategori','account_id'=>'Akun','amount'=>'Jumlah']);
  }
}
