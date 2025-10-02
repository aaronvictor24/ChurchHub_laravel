<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Count all members
        $totalMembers = Member::count();

        return view('admin.dashboard', compact('totalMembers'));
    }
}
