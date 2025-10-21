<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User; // قم باستيراد نموذج المستخدم الخاص بك
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // تأكد من إضافة هذا السطر في الجزء العلوي من الملف

class LoginController extends Controller
{
    // توجيه المستخدم إلى Google لتسجيل الدخول
    public function redirectToGoogle()
    {
        // $providers = Socialite::getProviders();
        // dd($providers); // يعرض قائمة الموفرين

        return Socialite::driver('google')->redirect();
    }

    // التعامل مع استجابة Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors('حدث خطأ أثناء تسجيل الدخول باستخدام Google');
        }
    
        // ابحث عن المستخدم باستخدام البريد الإلكتروني
        $user = User::where('email', $googleUser->getEmail())->first();
    
        // إذا كان المستخدم موجوداً، قم بتسجيل الدخول
        if ($user) {
            Auth::login($user);
        } else {
            // إذا لم يكن المستخدم موجوداً، قم بإنشاء مستخدم جديد
            $nameParts = explode(' ', $googleUser->getName(), 2); // تقسيم الاسم إلى أجزاء
            $firstName = $nameParts[0]; // الاسم الأول
            $lastName = isset($nameParts[1]) ? $nameParts[1] : ''; // الاسم الأخير
    
            // إنشاء كلمة مرور عشوائية
            $randomPassword = Str::random(10); // يمكنك تحديد الطول الذي تريده
    
            $user = User::create([
                'fname' => $firstName,
                'lname' => $lastName,
                'location' =>'',  
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(), // تخزين معرف Google
                'avatar' => $googleUser->getAvatar(), // تخزين الصورة الشخصية إذا كانت موجودة
                'password' => bcrypt($randomPassword),
                'phoneNumber'=>''
            ]);
    
            Auth::login($user);
        }
    
        // إعادة التوجيه إلى الصفحة الرئيسية بعد تسجيل الدخول
        return redirect('/');
    }
    
    

    // توجيه المستخدم إلى Facebook لتسجيل الدخول
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // التعامل مع استجابة Facebook
    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors('حدث خطأ أثناء تسجيل الدخول باستخدام Facebook');
        }

        // ابحث عن المستخدم باستخدام البريد الإلكتروني
        $user = User::where('email', $facebookUser->getEmail())->first();

        // إذا كان المستخدم موجوداً، قم بتسجيل الدخول
        if ($user) {
            Auth::login($user);
        } else {
            // إذا لم يكن المستخدم موجوداً، قم بإنشاء مستخدم جديد
            $user = User::create([
                'name' => $facebookUser->getName(),
                'email' => $facebookUser->getEmail(),
                'facebook_id' => $facebookUser->getId(), // إذا كنت تريد تخزين معرف Facebook
                'avatar' => $facebookUser->getAvatar(), // تخزين الصورة الشخصية إذا كانت موجودة
                // يمكنك إضافة المزيد من الحقول هنا إذا كنت بحاجة
            ]);

            Auth::login($user);
        }

        // إعادة التوجيه إلى الصفحة الرئيسية بعد تسجيل الدخول
        return redirect('/');
    }
}
