<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Throwable;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle registration.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
        } catch (Throwable $e) {
            Log::error('Registration validation failed', [
                'input' => $request->all(),
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        } catch (Throwable $e) {
            Log::error('User creation failed', [
                'input' => $request->all(),
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }

        try {
            $user->assignRole('customer');
        } catch (Throwable $e) {
            Log::error('Assigning default role failed', [
                'user_id' => $user->id ?? null,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }

        try {
            $user->profile()->create([]);
        } catch (Throwable $e) {
            Log::error('Creating empty user profile failed', [
                'user_id' => $user->id ?? null,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('home');
    }
}
