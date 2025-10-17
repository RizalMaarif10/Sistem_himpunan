<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
class LoginController extends Controller
{
    public function show()
{
    if (auth()->check()) {
        $u = auth()->user()->loadMissing('roles');

        if ($u->hasRole(Role::ADMIN))      return redirect()->route('admin.dashboard');
        if ($u->hasRole(Role::SEKRETARIS)) return redirect()->route('sekretariat.dashboard');
        if ($u->hasRole(Role::BENDAHARA))  return redirect()->route('bendahara.dashboard');

        // bukan pengurus
        return redirect()->route('home');
    }
    return view('auth.login');
}


    public function store(Request $request)
{
    $credentials = $request->validate([
        'email'    => ['required','email'],
        'password' => ['required','string'],
    ]);

    if (! Auth::attempt($credentials, $request->boolean('remember'))) {
        return back()->withErrors(['email' => 'Email atau kata sandi tidak sesuai.'])
                     ->withInput($request->only('email','remember'));
    }

    $request->session()->regenerate();

    $user = $request->user()->loadMissing('roles');
    if ($user->roles->pluck('name')->intersect([Role::ADMIN, Role::SEKRETARIS, Role::BENDAHARA])->isEmpty()) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return back()->withErrors(['email' => 'Akun ini bukan pengurus (admin/sekretaris/bendahara).'])
                     ->withInput($request->only('email'));
    }

    // Langsung ke dashboard sesuai role (tanpa intended agar tidak nyasar ke /admin)
    if ($user->hasRole(Role::ADMIN))      return redirect()->route('admin.dashboard');
    if ($user->hasRole(Role::SEKRETARIS)) return redirect()->route('sekretariat.dashboard');
    if ($user->hasRole(Role::BENDAHARA))  return redirect()->route('bendahara.dashboard');

    return redirect()->route('home');
}


    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
