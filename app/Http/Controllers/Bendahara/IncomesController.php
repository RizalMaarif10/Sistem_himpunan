<?php
namespace App\Http\Controllers\Bendahara;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Account;
use Illuminate\Http\Request;

class IncomesController extends Controller {
  public function index(){ $items = Transaction::income()->latest('date')->paginate(15); return view('bendahara.incomes.index', compact('items')); }
  public function create(){
    $tx = new Transaction(['date'=>now()->toDateString()]);
    $categories = Category::where('type','income')->orderBy('name')->get();
    $accounts   = Account::orderBy('name')->get();
    return view('bendahara.incomes.create', compact('tx','categories','accounts'));
  }
  public function store(Request $r){
    $data = $this->validated($r); $data['type']='income'; $data['user_id']=auth()->id();
    $tx = Transaction::create($data);
    return redirect()->route('bendahara.incomes.index')->with('success','Pemasukan disimpan.');
  }
  public function edit(Transaction $income){
    abort_unless($income->type==='income', 404);
    $tx=$income; $categories=Category::where('type','income')->orderBy('name')->get(); $accounts=Account::orderBy('name')->get();
    return view('bendahara.incomes.edit', compact('tx','categories','accounts'));
  }
  public function update(Request $r, Transaction $income){
    abort_unless($income->type==='income', 404);
    $data = $this->validated($r); $data['type']='income'; $income->update($data);
    return redirect()->route('bendahara.incomes.index')->with('success','Pemasukan diperbarui.');
  }
  public function destroy(Transaction $income){
    abort_unless($income->type==='income', 404);
    $income->delete(); return redirect()->route('bendahara.incomes.index')->with('success','Data dihapus.');
  }
  private function validated(Request $r): array{
    return $r->validate([
      'date'=>'required|date','category_id'=>'required|exists:categories,id',
      'account_id'=>'required|exists:accounts,id','amount'=>'required|numeric|min:0',
      'ref'=>'nullable|string|max:100','description'=>'nullable|string'
    ],[],['date'=>'Tanggal','category_id'=>'Kategori','account_id'=>'Akun','amount'=>'Jumlah']);
  }
}

