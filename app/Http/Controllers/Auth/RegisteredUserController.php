<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth; // استيراد Auth

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VerificationCode; // إضافة الموديل الجديد
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', Rules\Password::defaults()],
            'phoneNumber' => ['nullable', 'string', 'max:255'], // إذا كان الهاتف غير مطلوب
        ]);
    
        $verificationCode = rand(100000, 999999);
    
        VerificationCode::create([
            'email' => $request->email,
            'verification_code' => $verificationCode,
            'expires_at' => now()->addMinutes(10),
        ]);
    
        Mail::to($request->email)->send(new VerificationCodeMail($verificationCode));
    
        // **حفظ البيانات في الجلسة حتى يتمكن `verifyCode()` من استخدامها لاحقًا**
        session([
            'user_data' => $request->only(['fname', 'lname', 'location', 'email', 'password', 'phoneNumber'])
        ]);
    
        return redirect()->route('verify-code2')->with('email', $request->email);
    }
    

    // عرض صفحة إدخال الكود بعد إرسال البيانات
    public function showVerificationForm(Request $request): View
    {
        // استرجاع البريد الإلكتروني من الجلسة
        $email = session('email');
        return view('auth.verify', ['email' => $email]);
    }
    


    public function verifyCode(Request $request): RedirectResponse
    {
        $request->validate([
            'verification_code' => 'required|numeric',
            'email' => 'required|email',
        ]);
    
        $email = $request->email;
    
        // حذف الأكواد المنتهية أولاً
        VerificationCode::where('expires_at', '<', now())->delete();
    
        $verificationRecord = VerificationCode::where('email', $email)
            ->where('expires_at', '>=', now())
            ->orderBy('created_at', 'desc')
            ->first();
    
        if (!$verificationRecord || $verificationRecord->verification_code != $request->verification_code) {
            return back()->withErrors(['verification_code' => 'الكود غير صحيح أو منتهي الصلاحية.']);
        }
    
        // حذف الكود بعد الاستخدام لمنع إعادة استخدامه
        $verificationRecord->delete();
    
        $userData = session('user_data');
    
        if (!$userData) {
            return redirect()->route('register')->withErrors(['error' => 'انتهت صلاحية الجلسة، يرجى إعادة التسجيل.']);
        }
    
        $user = User::create([
            'fname' => $userData['fname'],
            'lname' => $userData['lname'],
            'location' => $userData['location'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
            'phoneNumber' => $userData['phoneNumber'] ?? null,
        ]);
    
        Auth::login($user);
    
        session()->forget('user_data');
    
        return redirect()->route('home')->with('status', 'تم التحقق بنجاح، حسابك الآن مفعل وتم تسجيل دخولك تلقائيًا.');
    }
    
    
    
}    
