<?php

namespace App\Http\Controllers\Sekretariat;

use App\Http\Controllers\Controller;
use App\Models\Minute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MinutesController extends Controller
{
    public function index()
    {
        $minutes = Minute::latest('meeting_date')->latest()->paginate(15);
        return view('sekretariat.minutes.index', compact('minutes'));
    }

    public function create()
    {
        $minute = new Minute(['meeting_date'=>now()->toDateString()]);
        return view('sekretariat.minutes.create', compact('minute'));
    }

    public function store(Request $r)
    {
        $data = $this->validated($r);
        if ($r->hasFile('file')) $data['file_path'] = $r->file('file')->store('minutes','public');
        $data['user_id'] = auth()->id();
        $minute = Minute::create($data);

        return redirect()->route('sekretariat.minutes.edit',$minute)->with('success','Notulen disimpan.');
    }

    public function edit(Minute $minute) { return view('sekretariat.minutes.edit', compact('minute')); }

    public function update(Request $r, Minute $minute)
    {
        $data = $this->validated($r);
        if ($r->hasFile('file')) {
            if ($minute->file_path && Storage::disk('public')->exists($minute->file_path)) {
                Storage::disk('public')->delete($minute->file_path);
            }
            $data['file_path'] = $r->file('file')->store('minutes','public');
        }
        $minute->update($data);
        return back()->with('success','Notulen diperbarui.');
    }

    public function destroy(Minute $minute)
    {
        if ($minute->file_path && Storage::disk('public')->exists($minute->file_path)) {
            Storage::disk('public')->delete($minute->file_path);
        }
        $minute->delete();
        return redirect()->route('sekretariat.minutes.index')->with('success','Notulen dihapus.');
    }

    private function validated(Request $r): array
    {
        return $r->validate([
            'title'        => ['required','string','max:200'],
            'meeting_date' => ['required','date'],
            'notes'        => ['nullable','string'],
            'file'         => ['nullable','file','mimes:pdf,doc,docx,jpg,jpeg,png,webp','max:6144'],
        ],[],['title'=>'Judul','meeting_date'=>'Tanggal Rapat','file'=>'Berkas']);
    }
}
