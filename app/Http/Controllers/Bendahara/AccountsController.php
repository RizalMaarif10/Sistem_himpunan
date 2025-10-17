<?php
// app/Http/Controllers/Bendahara/AccountsController.php
namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // <-- TAMBAHKAN

class AccountsController extends Controller
{
  public function index(){ $items = Account::orderBy('name')->paginate(12); return view('bendahara.accounts.index', compact('items')); }
  public function create(){ $item = new Account(['type'=>'cash']); return view('bendahara.accounts.create', compact('item')); }

  public function store(Request $r){
    $data = $r->validate([
      'name' => ['required','string','max:120'],
      'code' => ['nullable','string','max:50', Rule::unique('accounts','code')], // ← cek unik
      'type' => ['required', Rule::in(['cash','bank','other'])],
      'opening_balance' => ['nullable','numeric','min:0'],
    ], [
      'code.unique' => 'Kode sudah digunakan oleh akun lain.',
    ]);

    // normalisasi
    $data['code'] = isset($data['code']) && trim($data['code']) !== '' ? trim($data['code']) : null;
    $data['opening_balance'] = (int)($data['opening_balance'] ?? 0);

    Account::create($data);
    return redirect()->route('bendahara.accounts.index')->with('success','Akun disimpan.');
  }

  public function edit(Account $account){ $item = $account; return view('bendahara.accounts.edit', compact('item')); }

  public function update(Request $r, Account $account){
    $data = $r->validate([
      'name' => ['required','string','max:120'],
      'code' => ['nullable','string','max:50', Rule::unique('accounts','code')->ignore($account->id)], // ← abaikan diri sendiri
      'type' => ['required', Rule::in(['cash','bank','other'])],
      'opening_balance' => ['nullable','numeric','min:0'],
    ], [
      'code.unique' => 'Kode sudah digunakan oleh akun lain.',
    ]);

    $data['code'] = isset($data['code']) && trim($data['code']) !== '' ? trim($data['code']) : null;
    $data['opening_balance'] = (int)($data['opening_balance'] ?? 0);

    $account->update($data);
    return redirect()->route('bendahara.accounts.index')->with('success','Akun diperbarui.');
  }

  public function destroy(Account $account){ $account->delete(); return redirect()->route('bendahara.accounts.index')->with('success','Akun dihapus.'); }
}
