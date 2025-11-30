<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use App\Mail\BienvenidaMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Muestra la vista de registro.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Maneja el registro de un nuevo usuario.
     */
    public function store(Request $request): RedirectResponse
    {
        // VALIDACIÓN
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'matricula' => ['required', 'string', 'max:255', 'unique:users,matricula'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
                function ($attribute, $value, $fail) {
                    // Validar dominio real del correo (DNS MX)
                    $domain = substr(strrchr($value, "@"), 1);

                    if (!$domain || !checkdnsrr($domain, 'MX')) {
                        $fail('El correo electrónico no parece ser válido o su dominio no existe.');
                    }
                },
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->letters()->numbers(), // mínimo 8, letras y números
            ],
        ]);

        // ROL POR DEFECTO: Estudiante
        $role = Role::where('nombre', 'Estudiante')->firstOrFail();

        // CREAR USUARIO
        $user = User::create([
            'name' => $request->name,
            'matricula' => $request->matricula,
            'email' => $request->email,
            'password' => Hash::make($request->password), // bcrypt
            'role_id' => $role->id,
        ]);

        // Dispara evento de registro (por si Breeze/Fortify lo usa)
        event(new Registered($user));

        // Inicia sesión automáticamente
        Auth::login($user);

        // ENVIAR CORREO DE BIENVENIDA
        Mail::to($user->email)->send(new BienvenidaMail($user));

        // Redirigir según rol
        return redirect()->intended('/redirect-by-role');
    }
}
