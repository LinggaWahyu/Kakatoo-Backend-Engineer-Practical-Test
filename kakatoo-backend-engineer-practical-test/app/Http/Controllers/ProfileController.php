<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::get();

        foreach ($profiles as $profile) {
            unset($profile->created_at);
            unset($profile->updated_at);
        }

        return response($profiles);
    }
}
