<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffInteractController extends Controller
{
    public function index()
    {
        return view('Staff.staffinteract');
    }
}
