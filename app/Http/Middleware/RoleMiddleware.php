<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $request->user()->loadMissing('roles'); // pakai relasi many-to-many
        $names = $request->user()->roles->pluck('name');

        if ($names->intersect($roles)->isEmpty()) {
            abort(403, 'Tidak memiliki hak akses.');
        }

        return $next($request);
    }
}
