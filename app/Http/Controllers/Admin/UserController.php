<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::query()->orderByDesc('is_admin')->orderBy('name')->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create', [
            'user' => new User([
                'is_admin' => false,
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $payload = $this->validatedData($request, true);

        User::query()->create($payload);

        return redirect()->route('admin.users.index')->with('status', 'Usuario creado correctamente.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $payload = $this->validatedData($request, false, $user);

        if (($payload['is_admin'] ?? $user->is_admin) === false && $user->is_admin && $this->isLastAdmin($user)) {
            return back()->withErrors([
                'is_admin' => 'No puedes quitar el rol admin al último administrador disponible.',
            ])->withInput();
        }

        $user->update($payload);

        return redirect()->route('admin.users.index')->with('status', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user, Request $request): RedirectResponse
    {
        if ($request->user()->is($user)) {
            return back()->withErrors([
                'user' => 'No puedes eliminar tu propia cuenta mientras estás usando el panel.',
            ]);
        }

        if ($user->is_admin && $this->isLastAdmin($user)) {
            return back()->withErrors([
                'user' => 'No puedes eliminar al último administrador disponible.',
            ]);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'Usuario eliminado correctamente.');
    }

    private function validatedData(Request $request, bool $creating, ?User $user = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique(User::class, 'email')->ignore($user),
            ],
            'password' => [$creating ? 'required' : 'nullable', 'string', 'min:8'],
            'is_admin' => ['nullable', 'boolean'],
        ]);

        if (! $creating && empty($data['password'])) {
            unset($data['password']);
        }

        $data['is_admin'] = $request->boolean('is_admin');

        return $data;
    }

    private function isLastAdmin(User $user): bool
    {
        return User::query()
            ->where('is_admin', true)
            ->whereKeyNot($user->id)
            ->doesntExist();
    }
}