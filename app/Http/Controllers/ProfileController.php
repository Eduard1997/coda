<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
}
