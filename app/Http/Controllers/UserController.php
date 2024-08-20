<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\Users;
use App\Models\Orders;
use App\Models\Wishlist;

class UserController extends Controller
{
    public function account()
    {
        $data = [
            'active_page' => 'account'
        ];
        return view('user.account', $data);
    }

    public function account_update(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(auth()->id())->where(function ($query) use ($request) {
                return $query->where('email', $request->email);
            })],
            'phone' => 'required|string|max:25',
            'company_name' => 'nullable|string|max:25',
            'address' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'flag' => 'required|string|max:25',
            'country' => 'required|string|max:100',
            'zip_code' => 'required|string|max:25'
        ], [
            'first_name.required' => 'The first name field is required.',
            'last_name.required' => 'The last name field is required.',
            'email.required' => 'The email field is required.',
            'email.unique' => 'The email has already been taken.',
            'phone.required' => 'The mobile number is required.',
            'address.required' => 'The address field is required.',
            'city.required' => 'The city field is required.',
            'state.required' => 'The state/region is required.',
            'flag.required' => 'The country flag is required.',
            'country.required' => 'The country field is required.',
            'zip_code.required' => 'The zip code field is required.'
        ]);

        $user = Users::findOrFail(auth()->id());
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->company_name = $request->input('company_name');
        $user->address = $request->input('address');
        $user->city = ucfirst($request->input('city'));
        $user->state = ucfirst($request->input('state'));
        $user->flag = $request->input('flag');
        $user->country = ucfirst($request->input('country'));
        $user->zip_code = $request->input('zip_code');

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
        }

        $user->save();
        return redirect()->back()->with('success', 'Your profile updated successfully');
    }

    public function account_change_password()
    {
        $data = [
            'active_page' => 'account_password'
        ];
        return view('user.account_password', $data);
    }

    public function account_change_password_update(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:6|different:current_password',
            'password_confirmation' => 'required|same:new_password'
        ]);
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return redirect()->back()->with('error', 'Incorrect current password!');
        }
        $user = Users::findOrFail(auth()->id());
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);
        return redirect()->back()->with('success', 'Your password has been changed successfully!');
    }

    public function account_delete(Request $request)
    {
        $request->validate([
            'password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, auth()->user()->password)) {
                    $fail('Incorrect current password!');
                }
            }],
            'verify' => 'required|in:confirm',
        ], [
            'verify.required' => 'Please type "confirm" correctly!',
            'verify.in' => 'Please type "confirm" correctly!',
        ]);
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("signin")->with("success", "We'll miss you! Thanks for being part of our family. Best of luck on your journey!");
    }
    
    public function account_update_img(Request $request)
    {
        $user = Users::findOrFail(auth()->id());

        if ($request->hasFile('avatar')) {
            if ($user->avatar !== "users/default_avatar.png") {
                Storage::disk('public')->delete($user->avatar);
            }
            $randomString = Str::random(25);
            $extension = $request->file('avatar')->getClientOriginalExtension();
            $imagePath = $request->file('avatar')->storeAs('users', $randomString . '.' . $extension, 'public');
            $user->avatar = $imagePath;
            $user->save();
            return redirect()->back()->with('success', 'Your profile updated successfully');
        }

        if ($request->has('selected_avatar')) {
            $selectedAvatarUrl = $request->input('selected_avatar');
            $filename = basename($selectedAvatarUrl);
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $newFilename = Str::random(25) . '.' . $extension;
            $source = storage_path('app/public/users/' . $filename);
            $destination = storage_path('app/public/users/' . $newFilename);

            if (file_exists($source)) {
                $copied = copy($source, $destination);
                if ($copied) {
                    if ($user->avatar !== "users/default_avatar.png") {
                        Storage::disk('public')->delete($user->avatar);
                    }
                    $user->avatar = 'users/' . $newFilename;
                    $user->save();

                    return redirect()->back()->with('success', 'Your profile picture has been updated');
                } else {
                    return redirect()->back()->with('error', 'Failed to set the selected profile picture');
                }
            } else {
                return redirect()->back()->with('error', 'Source profile picture file not found');
            }
        }
    }

    public function orders()
    {
        $orders = Orders::where('user_id', auth()->id())->where('status', 'success')->orderBy('status', 'asc')->orderBy('id', 'desc')->paginate(10);
        $data = [
            'active_page' => 'account_orders',
            'orders' => $orders
        ];
        return view('user.account_orders', $data);
    }

    public function wishlist()
    {
        $wishlist = Wishlist::orderBy('id', 'desc')->paginate(20);
        $data = [
            'active_page' => 'account_wishlist',
            'wishlist' => $wishlist
        ];
        return view('user.account_wishlist', $data);
    }
}