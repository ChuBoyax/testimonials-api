<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResumeController extends Controller
{
    /**
     * Verify the owner's credentials before the portfolio lets the résumé
     * download proceed. The password is checked against a bcrypt hash stored
     * server-side (config/resume.php ← .env), so it never reaches the browser.
     */
    public function verify(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'string', 'max:120'],
            'password' => ['required', 'string', 'max:200'],
        ]);

        $email = config('resume.owner_email');
        $hash = config('resume.owner_password_hash');

        $emailOk = is_string($email) && hash_equals(
            strtolower(trim($email)),
            strtolower(trim($data['email']))
        );
        $passOk = is_string($hash) && $hash !== '' && Hash::check($data['password'], $hash);

        if (! ($emailOk && $passOk)) {
            return response()->json([
                'ok' => false,
                'message' => 'Incorrect email or password.',
            ], 401);
        }

        return response()->json(['ok' => true]);
    }
}
