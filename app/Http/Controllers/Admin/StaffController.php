<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StaffController extends Controller
{
    /**
     * List every staff account.
     */
    public function index(): View
    {
        return view('admin.staff.index', [
            'users' => User::query()->orderBy('name')->get(),
        ]);
    }

    /**
     * Store a new staff account.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', Rule::enum(UserRole::class)],
            'password' => ['required', 'string', Password::min(8), 'confirmed'],
        ]);

        User::create($validated);

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Cuenta creada correctamente.');
    }

    /**
     * Update an existing staff account.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['required', Rule::enum(UserRole::class)],
            'password' => ['nullable', 'string', Password::min(8)],
        ]);

        $role = UserRole::from($validated['role']);

        if ($user->is($request->user()) && $role !== $user->role) {
            return back()->with('error', 'No puedes cambiar tu propio rol.');
        }

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $role,
        ]);

        if (! empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Cuenta actualizada correctamente.');
    }

    /**
     * Delete a staff account.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $user->delete();

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Cuenta eliminada.');
    }
}
