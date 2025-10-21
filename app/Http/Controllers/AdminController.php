<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Driver;
use Spatie\Permission\Models\Role;
use App\Traits\Upload_image;

class AdminController extends Controller
{
    use Upload_image;

    public function getAllUsers(){
        $users = User::all();
        $drivers = Driver::all();
        $mergedData = [];

    foreach ($users as $user) {
        $user->user_type = 'Customer';
        $mergedData[] = $user;
    }

    foreach ($drivers as $driver) {
        $driver->user_type = 'manager';
        $mergedData[] = $driver;
    }

    $usersData = collect($mergedData)->sortBy('created_at')->values();

    return response()->json(['users' => $usersData]);
    }

    public function showUser($id){
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'not found'
            ], 404);
        }
        return response()->json([
            'user' => $user,
            'status' => 200
        ], 200);
        }
    public function getAdmin($id){
        $admin = Driver::find($id);
        $adminRoles = $admin->getRoleNames();
        $allRoles = Role::all();
        if (!$admin) {
            return response()->json([
                'status' => 404,
                'message' => 'not found'
            ], 404);
        }
        return response()->json([
            'admin' => $admin,
            'adminRoles' => $adminRoles,
            'allRoles' => $allRoles,
            'status' => 200
        ], 200);
    }
    public function editAdmin(Request $request, $id){
        $user = Driver::find($id);
        $personImage=null;
        if ($request->hasFile('personImage')) {
            $image = $request->file('personImage')->getClientOriginalName();
            $input['personImage'] = $request->file('personImage')->storeAs('edit_img', $image, 'uploadImg');
            $personImage=$input['personImage'];
        }
        $user->update([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'location' => $request->location,
            'phoneNumber' => $request->phoneNumber,
            'personImage' => $personImage,
        ]);
        $selectedRoles = explode(',', $request->input('selectedRoles'));
        $user->syncRoles($selectedRoles);
        return response()->json([
            'message' => 'The information has been updated successfully',
            'status' => 200
        ], 200);
    }
    public function deleteAdmin($id)
    {
        if ($id == 1) {
            return response()->json([
                'status' => 400,
                'message' => 'Cannot delete admin with ID:1.'
            ], 400);
        }
        $admin = Driver::find($id);
        if (!$admin) {
            return response()->json([
                'status' => 404,
                'message' => 'Admin not found.'
            ], 404);
        }
        $admin->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Admin deleted successfully.'
        ], 200);
    }

}
