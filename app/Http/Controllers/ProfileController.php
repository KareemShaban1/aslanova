<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Driver;
use App\Models\Location;
use App\Traits\Upload_image;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ProfileController extends Controller
{
    use Upload_image;
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updateProfile(Request $request , $id)
    {
        $user = User::find($id);
        $updateData = [
            'fname' => $request->fname,
            'lname' => $request->lname,
            'phoneNumber' => $request->phoneNumber,
            'location' => $request->location,
            // 'email' => $request->email,
        ];
        
        if ($request->hasFile('personImage')) {
            // إذا كانت هناك صورة مرفقة
            $image = $request->file('personImage')->getClientOriginalName();
            $updateData['personImage'] = $request->file('personImage')->storeAs('edit_img', $image, 'uploadImg');
        }
        
        $user->update($updateData);
        
        // Handle location update or creation
        if ($request->has('location_id') && $request->location_id) {
            // Update existing location
            $location = Location::where('id', $request->location_id)
                ->where('user_id', $user->id)
                ->first();
            
            if ($location) {
                $location->update([
                    'first_name' => $request->location_first_name,
                    'last_name' => $request->location_last_name,
                    'country' => $request->location_country,
                    'city' => $request->location_city,
                    'street' => $request->location_street,
                    'house_number' => $request->location_house_number,
                    'zip_code' => $request->location_zip_code,
                    'phone' => $request->location_phone,
                ]);
            }
        } else {
            // Create new location if location data is provided
            if ($request->has('location_country') && $request->location_country) {
                Location::create([
                    'user_id' => $user->id,
                    'first_name' => $request->location_first_name,
                    'last_name' => $request->location_last_name,
                    'country' => $request->location_country,
                    'city' => $request->location_city,
                    'street' => $request->location_street,
                    'house_number' => $request->location_house_number,
                    'zip_code' => $request->location_zip_code,
                    'phone' => $request->location_phone,
                ]);
            }
        }
        
        // $user->update($input);
        // return response()->json($user);
        // return response()->json($request->hasFile('personImage'));
    }
    public function updateAdminProfile(Request $request , $id)
    {
        $user = Driver::find($id);
        $personImage=null;
        $input =$request->all();
        if ($request->hasFile('personImage')) {
            // إذا كانت هناك صورة مرفقة
            $image = $request->file('personImage')->getClientOriginalName();
            $input['personImage'] = $request->file('personImage')->storeAs('edit_img', $image, 'uploadImg');
            $personImage=$input['personImage'];
        }
        $user->update([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'phoneNumber' => $request->phoneNumber,
            'location' => $request->location,
            // 'email' => $request->email,
            'personImage' => $personImage,
        ]);
        // $user->update($input);
        // return response()->json($user);
        // return response()->json($request->hasFile('personImage'));
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


   public function getUserInfo()
    {
        $userinfo = Auth::user()->load('locations');
        return $userinfo;
    }

//   public function getUserInfo()
// {
//     $userinfo = \DB::table('users')
//         ->join('locations', 'users.id', '=', 'locations.user_id') // ربط جدول المواقع بالمستخدمين
//         ->where('users.id', Auth::id()) // تصفية البيانات للمستخدم الحالي
//         ->select('users.*', 'locations.*') // تحديد الأعمدة المطلوبة
//         ->first(); // جلب أول سجل فقط

//     return response()->json($userinfo);
// }

    
    public function getAdminInfo()
    {
        $adminInfo =  Auth::guard('driver')->user();
        return response()->json([
            'adminInfo' => $adminInfo,
        ]);
    }

    public function statistics()
    {
        $totalUsersCount = User::count();
        return response()->json([
            'status' => 200,
            'totalUsersCount' => $totalUsersCount
        ]);
    }
}
