<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Muestra el formulario para solicitar el restablecimiento de contraseña.
     */
    public function showLinkRequestForm()
    {
        return view('auth.forget'); // Asegúrate de que la vista forget.blade.php está en resources/views/auth/
    }
}
