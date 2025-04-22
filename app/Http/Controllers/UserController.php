<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    //
    use AuthorizesRequests;
    public function index() 
    {
        $this->authorize('viewAny', User::class);
        $users = User::paginate(10);
       //$users);
        return Inertia::render('Users/Index', compact('users'));
    }

    public function show(User $user)
    {
        return Inertia::render('Users/Show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return Inertia::render('Users/Edit', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        
        // Validação dos dados recebidos
        $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'cpf' => 'required|string|max:14',
        'profile' => 'required|string',
        'active' => 'required|string',
    ]);

    // Encontrar o usuário pelo ID
    $user = User::findOrFail($id);

    // Atualizar os dados do usuário
    $user->update($validatedData);

    // Redirecionar com mensagem de sucesso
    return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }
}
