<?php

namespace App\Http\Controllers\Sekretariat;

use App\Http\Controllers\Controller;
use App\Models\Contact; // ganti ke Hubungi jika modelmu bernama Hubungi
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index()
    {
        $items = Contact::latest()->paginate(20);
        return view('sekretariat.messages.index', compact('items'));
    }

    public function show(Contact $message)
    {
        return view('sekretariat.messages.show', compact('message'));
    }

    public function markRead(Contact $message)
    {
        $message->update(['read_at' => now()]);
        return back()->with('success','Pesan ditandai dibaca.');
    }

    public function destroy(Contact $message)
    {
        $message->delete();
        return redirect()->route('sekretariat.messages.index')->with('success','Pesan dihapus.');
    }
}
