<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ShoppingCart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * Write static login information to the session.
 * Use for test purposes.
 */
class AuthController extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }

    public function showRegisterForm() {
        return view('auth.register');
    }

    public function login(Request $request) {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Finde den Benutzer mit der angegebenen E-Mail
        $user = User::where('ab_mail', $validated['email'])->first();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found!',
            ], 404);
        }

        // Überprüfen, ob das eingegebene Passwort mit dem gehashten Passwort in der DB übereinstimmt
        if (Hash::check($request->password, $user->ab_password)) {
            Auth::login($user);
            $request->session()->regenerate();
            $token = $user->createToken('WEB TOKEN')->plainTextToken;
            session(['auth_token' => $token]);
            return redirect()->route('articles');
        }

        throw ValidationException::withMessages([
            'credentials' => 'Invalid credentials.'
        ]);
    }


    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:ab_user,ab_mail',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'ab_name' => $validated['name'],
            'ab_mail' => $validated['email'],
            'ab_password' => Hash::make($validated['password']),
            ]);

        Auth::login($user);
        $request->session()->regenerate();

        $token = $user->createToken('WEB TOKEN')->plainTextToken;
        session(['auth_token' => $token]);

        ShoppingCart::createShoppingCart($user->id);

        return redirect()->route('articles');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->currentAccessToken()?->delete();
        }
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->forget('auth_token');

        return redirect('/');
    }

}
