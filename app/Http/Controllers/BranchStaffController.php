<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;

class BranchStaffController extends Controller
{
    /**
     * Return staff for a given branch as JSON.
     */
    public function index($branchId)
    {
        $branch = Branch::with('staff')->find($branchId);
        if(!$branch) return response()->json(['error' => 'Branch not found'], 404);

        return response()->json(['branch' => [
            'id' => $branch->id,
            'name' => $branch->name,
            'staff' => $branch->staff->map(function($s){ return [ 'id' => $s->id, 'name' => $s->name, 'role' => $s->role ?? null ]; })
        ]]);
    }
}
