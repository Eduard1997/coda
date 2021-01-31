<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\Input;

class ProfileController extends Controller
{
    protected Request $request;

    /**
     * ProfileController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getProfileData() {
        $user = User::where('id', \Auth::user()->id)->select('id', 'name', 'email', 'profile_picture')->first();
        return view('dashboard.profile.index')->with(['user' => $user]);
    }

    public function updateProfile($id) {
        $data = $this->request->all();
        $user = User::find($id);
        $user->name = $data['user-name'];
        $user->email = $data['user-email'];
        if(!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        if(!empty($data['user-picture'])) {
            $filenameWithExt = $this->request->file('user-picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $this->request->file('user-picture')->getClientOriginalExtension();
            $fileNameToStore = $filename.'.' . $extension;
            $user->profile_picture = $filename.'.' . $extension;
            $path = $this->request->file('user-picture')->storeAs('public/avatars/' . \Auth::user()->id,$fileNameToStore);
        }
        $user->save();
        return redirect(url('/'));
    }
}
