<?php

namespace App\Http\Controllers\DriverAuth;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Providers\RouteServiceProvider;
use App\Traits\Upload_image;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    use Upload_image;
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('driver.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        // dd($request->all());
        $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'phoneNumber' => ['required','max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.Driver::class],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $upload_img = null; // تعيين قيمة افتراضية للصورة في حال عدم تحديدها

        if ($request->has('personImage')) {
            $request->validate([
                'personImage' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // تأكيد صحة الصورة إذا تم تحديدها
        ]);
            $upload_img = $this->uploadImage($request , 'admin');
        }
        $user = Driver::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'location' => $request->location,
            'phoneNumber' => $request->phoneNumber,
            'notes' => $request->notes,
            'personImage' => $upload_img,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('driver.index');
    }
}
