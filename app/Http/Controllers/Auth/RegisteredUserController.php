<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $roles = Role::whereIn('role_name', ['member', 'trainer'])->get();
        return view('auth.register', compact('roles'));
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'exists:roles,role_id'],
            'gender' => ['required', 'in:male,female,other'],
            'dob' => ['required', 'date', 'before:today'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'registration_date' => now(),
            'status' => 'active',
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect based on user role
        $role = $user->role->role_name ?? 'user';

        switch ($role) {
            case 'admin':
                return redirect('/admin/dashboard');
            case 'manager':
                return redirect('/manager/dashboard');
            case 'trainer':
                return redirect('/trainer/dashboard');
            case 'staff':
                return redirect('/staff/dashboard');
            case 'member':
                return redirect('/member/dashboard');
            default:
                return redirect('/dashboard');
        }
    }
}
