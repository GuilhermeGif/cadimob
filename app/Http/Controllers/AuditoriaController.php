<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Models\Audit;
use Inertia\Inertia;

class AuditoriaController extends Controller
{
    //
    public function index (Request $request)
    {
        $authUser = Auth::user();
        if ($authUser->profile == 'A') {
            return redirect()->route('dashboard');
        }
        
        $query = Audit::query();

        // Filtros
        if ($request->filled('usuario')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->input('usuario') . '%');
            });
        }

        if ($request->filled('evento')) {
            $query->where('event', $request->input('evento'));
        }

        if ($request->filled('data')) {
            $query->whereDate('created_at', $request->input('data'));
        }

        if ($request->filled('tabela')) {
            $query->where('auditable_type', $request->input('tabela'));
        }
        
        // Paginação
        $auditorias = $query->with('user')->paginate(10)->appends($request->except('page'));

        return Inertia::render('Auditorias/Index', [
            'auditorias' => $auditorias
        ]);
    }
}
