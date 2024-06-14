<?php

namespace App\Http\Controllers\Admin;

use App\Actions\File\FileDelete;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();

            return $next($request);
        });
    }

    /**
     * Profile View.
     *
     * @return void
     */
    public function profile()
    {
        if (is_null($this->user) || ! $this->user->can('profile.view')) {
            abort(403, 'Sorry !! You are Unauthorized to profile.');
        }
        try {
            $user = auth()->user();

            return view('admin.profile.index', compact('user'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Profile Setting.
     *
     * @return void
     */
    public function setting()
    {
        if (is_null($this->user) || ! $this->user->can('profile.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to profile settings.');
        }
        try {
            $user = auth()->user();

            return view('admin.profile.setting', compact('user'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Profile Update.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile_update(ProfileRequest $request)
    {
        if (is_null($this->user) || ! $this->user->can('profile.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to profile settings.');
        }
        try {
            $data = $request->only(['name', 'email']);
            $user = auth('admin')->user();

            if ($request->hasFile('image')) {
                $data['image'] = uploadFileToPublic($request->image, 'user');
                FileDelete::delete($user->image);
            }
            if ($request->isPasswordChange == 1) {
                $data['password'] = bcrypt($request->password);
            }

            $user->update($data);

            return back()->with('success', 'Profile update successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }
}
