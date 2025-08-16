<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderByDesc('id')->paginate(20);
        return view("admin.users.index", ['users' => $users]);
    }

    public function show($id)
    {
        $user = User::find($id);
        return view("admin.users.show", ['user' => $user]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view("admin.users.edit", ['user' => $user]);
    }

    public function update($id, Request $request)
    {
        // Recupera o usuário pelo ID
        $user = User::findOrFail($id);

        // Validação dos campos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'is_admin' => 'required|in:0,1',
        ]);

        // Atualiza os campos
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->is_admin = $request->input('is_admin');

        // Salva no banco
        $user->save();

        // Redireciona para a lista de usuários com mensagem de sucesso
        return redirect()->route('admin.users.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy($id)
    {
        // Recupera o usuário pelo ID
        $user = User::findOrFail($id);

        // Deleta o usuário
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'Usuário deletado com sucesso!');
    }
}
