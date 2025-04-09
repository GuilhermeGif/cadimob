<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Carbon\Carbon;


class UserController extends Controller
{
    //
    public function index() 
    {
        $users = User::paginate(10);
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

}
