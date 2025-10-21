<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $verificationCode;

    public function __construct($verificationCode)
    {
        $this->verificationCode = $verificationCode;
    }

    public function build()
    {
        return $this->subject('Your Verification Code')
                    ->view('emails.verification_code');
    }



    public function verifyCode(Request $request)
{
    $request->validate([
        'verification_code' => ['required', 'numeric'],
    ]);

    $storedCode = Cache::get('verification_code_' . Auth::user()->email);
    if (!$storedCode || $storedCode != $request->verification_code) {
        return back()->withErrors(['verification_code' => 'Invalid verification code.']);
    }

    // حذف الكود من الكاش بعد التحقق
    Cache::forget('verification_code_' . Auth::user()->email);

    // اكتمال تسجيل المستخدم
    $user = Auth::user();
    $user->email_verified_at = now();
    $user->save();

    return redirect(RouteServiceProvider::HOME);
}


}
