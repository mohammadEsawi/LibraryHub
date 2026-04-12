<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private function routeForRole(string $role): string
    {
        return $role === 'admin' ? 'admin.dashboard' : 'books.index';
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:30|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:customer,reader,author',
        ]);

        $user = User::create($validated);

        Auth::login($user);

        return redirect()->route($this->routeForRole($user->role))->with('success', 'تم إنشاء الحساب وتسجيل الدخول بنجاح.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'بيانات تسجيل الدخول غير صحيحة.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = $request->user();

        return redirect()->intended(route($this->routeForRole($user->role)));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form')->with('success', 'تم تسجيل الخروج.');
    }
}
