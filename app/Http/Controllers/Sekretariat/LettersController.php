<?php

namespace App\Http\Controllers\Sekretariat;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LettersController extends Controller
{
    public function index(Request $r)
{
    // type: incoming | outgoing | all | (null) -> dianggap "Semua"
    $typeParam = $r->query('type');
    $type = in_array($typeParam, ['incoming','outgoing','all'], true) ? $typeParam : null;
    if ($type === 'all') { $type = null; } // "all" = semua

    $base = Letter::when($type, fn($q) => $q->where('type', $type))
        ->orderByDesc('date')
        ->orderByDesc('id');

    // Jika cetak PDF, ambil semua baris
    $letters = $r->boolean('print')
        ? $base->get()
        : $base->paginate(15)->withQueryString();

    return view('sekretariat.letters.index', compact('letters','type'));
}


    public function incoming() { return redirect()->route('sekretariat.letters.index', ['type'=>'incoming']); }
    public function outgoing() { return redirect()->route('sekretariat.letters.index', ['type'=>'outgoing']); }

    public function create()
    {
        $letter = new Letter(['type'=>'incoming','date'=>now()->toDateString()]);
        return view('sekretariat.letters.create', compact('letter'));
    }

    public function store(Request $r)
    {
        $data = $this->validated($r);
        if ($r->hasFile('file')) $data['file_path'] = $r->file('file')->store('letters','public');
        $data['user_id'] = auth()->id();
        $letter = Letter::create($data);

        return redirect()->route('sekretariat.letters.edit', $letter)->with('success','Surat disimpan.');
    }

    public function edit(Letter $letter) { return view('sekretariat.letters.edit', compact('letter')); }

    public function update(Request $r, Letter $letter)
    {
        $data = $this->validated($r);
        if ($r->hasFile('file')) {
            if ($letter->file_path && Storage::disk('public')->exists($letter->file_path)) {
                Storage::disk('public')->delete($letter->file_path);
            }
            $data['file_path'] = $r->file('file')->store('letters','public');
        }
        $letter->update($data);
        return back()->with('success','Surat diperbarui.');
    }

    public function destroy(Letter $letter)
    {
        if ($letter->file_path && Storage::disk('public')->exists($letter->file_path)) {
            Storage::disk('public')->delete($letter->file_path);
        }
        $letter->delete();
        return redirect()->route('sekretariat.letters.index')->with('success','Surat dihapus.');
    }

    private function validated(Request $r): array
    {
        return $r->validate([
            'type'        => ['required','in:incoming,outgoing'],
            'number'      => ['nullable','string','max:120'],
            'date'        => ['required','date'],
            'from_name'   => ['nullable','string','max:200'],
            'to_name'     => ['nullable','string','max:200'],
            'subject'     => ['required','string','max:200'],
            'notes'       => ['nullable','string'],
            'file'        => ['nullable','file','mimes:pdf,jpg,jpeg,png,webp','max:4096'],
        ],[],[
            'type'=>'Tipe Surat','number'=>'Nomor','date'=>'Tanggal','from_name'=>'Dari','to_name'=>'Kepada','subject'=>'Perihal','file'=>'Berkas'
        ]);
    }
}
