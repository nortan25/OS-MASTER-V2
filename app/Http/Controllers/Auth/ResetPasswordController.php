<?php



namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordChanged;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ResetPasswordController extends Controller
{
    /**
     * Reset user password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        // Validação dos dados recebidos
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        // Verifica se a senha atual do usuário está correta
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'Senha atual incorreta.'], 422);
        }

        // Atualiza a senha do usuário
        $user->password = Hash::make($request->password);
        $user->save();

        // Envia um email informando que a senha foi alterada (opcional)
        Mail::to($user->email)->send(new PasswordChanged());

        // Retorna uma resposta JSON com sucesso e uma mensagem
        return response()->json(['success' => 'Senha atualizada com sucesso. Um email de confirmação foi enviado.']);
    }



  /**
     * Exibe o formulário de esqueci a senha.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Envia o link de redefinição de senha por email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

    /**
     * Exibe o formulário de redefinição de senha.
     *
     * @param string $token
     * @param string $email
     * @return \Illuminate\View\View
     */
    public function showResetForm($token, $email)
    {
        return view('auth.passwords.reset', [
            'token' => $token,
            'email' => $email
        ]);
    }

    /**
     * Reseta a senha do usuário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = $this->broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->save();
            }
        );

        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }
}