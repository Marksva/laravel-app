<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        // $users = User::all();
        $users = User::paginate(5);
        return view('user/index', compact('users'));
    }


    public function create()
    {
        return view('user/create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        try {
            User::create($data);
            return redirect()->route('user.index')->with('success', 'Usuário criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao criar usuário.');
        }
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $user = user::find($id);
        return view('user.edit', compact('user'));
    }


    public function update(Request $request, string $id)
    {
        $data = $this->validatedData($request);

        try {
            $user = User::findOrFail($id);
            $user->update($data);
            return redirect()->route('user.index')->with('success', 'Usuário atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('user.index')->with('error', 'Erro ao atualizar usuário.');
        }
    }


    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Usuário deletado com sucesso!');
    }

    private function validatedData(Request $request): array
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        return $validated;
    }
}
