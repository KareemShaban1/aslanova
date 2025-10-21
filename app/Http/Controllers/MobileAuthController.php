<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Mail\VerificationCodeMail;
use App\Models\VerificationCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache; // ✅ تم التصحيح
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class MobileAuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $request->authenticate();

        if ($request->wantsJson()) {
            $request->user()->tokens()->delete();

            $token = $request->user()->createToken('register_token')->plainTextToken;
            $user_data = [
                "id" => $request->user()->id,
                "name" => $request->user()->fname . ' ' . $request->user()->lname,
                "phoneNumber" => $request->user()->phoneNumber,
                "location" => $request->user()->location,
                "email" => $request->user()->email,
                "fname" => $request->user()->fname,
                "lname" => $request->user()->lname,
            ];
            return response()->json([
                'token' => $token,
                'user' => $user_data,
                'message' => __('Success'),
            ], 200);
        }

        $request->session()->regenerate();

        //return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function register(Request $request)
    {
        $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'location' => 'required|string',
            'phoneNumber' => 'required|string',
        ]);
    
        // إنشاء كود تحقق عشوائي
        $verificationCode = rand(100000, 999999);
    
        // حفظ كود التحقق في قاعدة البيانات
        VerificationCode::updateOrCreate(
            ['email' => $request->email],
            [
                'verification_code' => $verificationCode,
                'expires_at' => now()->addMinutes(10),
            ]
        );
    
        // إرسال كود التحقق عبر البريد الإلكتروني
        Mail::to($request->email)->send(new VerificationCodeMail($verificationCode));
    
        // تخزين البيانات مؤقتًا في Redis (صالح لمدة 15 دقيقة)
        Cache::put('user_data_' . $request->email, [
            'fname' => $request->fname,
            'lname' => $request->lname,
            'location' => $request->location,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phoneNumber' => $request->phoneNumber,
        ], now()->addMinutes(15));
    
        return response()->json([
            'message' => 'تم إرسال كود التحقق إلى بريدك الإلكتروني. يرجى إدخال الكود لإكمال التسجيل.',
        ], 200);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'verification_code' => 'required|numeric',
        ]);
    
        $email = $request->email;
    
        // جلب آخر كود تحقق لهذا البريد
        $verificationRecord = VerificationCode::where('email', $email)
            ->where('expires_at', '>=', now())
            ->orderBy('created_at', 'desc')
            ->first();
    
        if (!$verificationRecord || $verificationRecord->verification_code != $request->verification_code) {
            return response()->json(['message' => 'الكود غير صحيح أو منتهي الصلاحية.'], 400);
        }
    
        // جلب بيانات المستخدم من الكاش
        $userData = Cache::get('user_data_' . $email);
    
        if (!$userData) {
            return response()->json(['message' => 'انتهت صلاحية البيانات، يرجى إعادة التسجيل.'], 400);
        }
    
        // إنشاء الحساب
        $user = User::create([
            'fname' => $userData['fname'],
            'lname' => $userData['lname'],
            'location' => $userData['location'],
            'email' => $userData['email'],
            'password' => $userData['password'],
            'phoneNumber' => $userData['phoneNumber'],
        ]);
    
        // حذف البيانات من الكاش بعد التسجيل
        Cache::forget('user_data_' . $email);
    
        // تسجيل الدخول تلقائيًا
        Auth::login($user);
    
        // حذف كود التحقق المستخدم
        $verificationRecord->delete();
    
        // إنشاء التوكن
        $token = $user->createToken('register_token')->plainTextToken;
    
        return response()->json([
            'token' => $token,
            'user' => [
                "id" => $user->id,
                "name" => $user->fname . ' ' . $user->lname,
                "phoneNumber" => $user->phoneNumber,
                "location" => $user->location,
                "email" => $user->email,
                "fname" => $user->fname,
                "lname" => $user->lname,
            ],
            'message' => 'تم التحقق بنجاح، حسابك الآن مفعل.',
        ], 200);
    }
    




    public function logout(Request $request)
    {
        Auth::logout();
        if ($request->wantsJson()) {
            return response()->json([
                'message' => __('Successfully logged out'),
            ], 200);
        }
        return redirect('/');
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $request->validate([
            'fname' => 'string',
            'lname' => 'string',
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'string|min:6',
            'location' => 'string',
            'phoneNumber' => 'string',
        ]);
        if ($request->has('fname')) {
            $user->fname = $request->fname;
        }
        if ($request->has('lname')) {
            $user->lname = $request->lname;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        if ($request->has('location')) {
            $user->location = $request->location;
        }
        if ($request->has('phoneNumber')) {
            $user->phoneNumber = $request->phoneNumber;
        }
        $user->save();

        return response()->json(['message' => 'User updated successfully'], 200);
    }


    public function getUserInfo()
{
    $user = Auth::user();

    if (!$user) {
        return response()->json(['message' => 'User not authenticated'], 401);
    }

    $user_data = [
        "id" => $user->id,
        "name" => $user->fname . ' ' . $user->lname,
        "phoneNumber" => $user->phoneNumber,
        "location" => $user->location,
        "email" => $user->email,
        "fname" => $user->fname,
        "lname" => $user->lname,
        "locations" => $user->locations, // تأكد من أن العلاقة locations معرفة في الموديل
    ];

    return response()->json([
        'user' => $user_data,
        'message' => 'User info retrieved successfully',
    ], 200);
}

}


