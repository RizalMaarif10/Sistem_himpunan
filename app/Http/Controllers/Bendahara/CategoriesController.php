<?php
// app/Http/Controllers/Bendahara/CategoriesController.php
namespace App\Http\Controllers\Bendahara;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller {
  public function index(){ $items = Category::orderBy('type')->orderBy('name')->paginate(20); return view('bendahara.categories.index', compact('items')); }
  public function create(){ $item = new Category(['type'=>'income']); return view('bendahara.categories.create', compact('item')); }
  public function store(Request $r){
    $data = $r->validate(['name'=>'required|string|max:120','type'=>'required|in:income,expense']);
    $item = Category::create($data);
    return redirect()->route('bendahara.categories.edit',$item)->with('success','Kategori disimpan.');
  }
  public function edit(Category $category){ $item = $category; return view('bendahara.categories.edit', compact('item')); }
  public function update(Request $r, Category $category){
    $data = $r->validate(['name'=>'required|string|max:120','type'=>'required|in:income,expense']);
    $category->update($data);
    return back()->with('success','Kategori diperbarui.');
  }
  public function destroy(Category $category){ $category->delete(); return redirect()->route('bendahara.categories.index')->with('success','Kategori dihapus.'); }
}
