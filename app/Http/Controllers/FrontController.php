<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
      public function index()
    {
        return view('frontend.index');
    }
    public function aboutus()
    {
        return view('frontend.aboutus');
    }
    public function services()
    {
        $services = Service::query()->orderBy('category')->orderBy('name')->get();
        return view('frontend.services', compact('services'));
    }
    public function contact()
    {
        // Get all active branches from database with all contact information
        $branches = \App\Models\Branch::where('active', true)
                                     ->select('id', 'name', 'address', 'location_detail', 'hours', 'map_src', 'contact_number', 'telephone_number', 'operating_days')
                                     ->orderBy('name')
                                     ->get();

        return view('frontend.contact', compact('branches'));
    }

    // Simple API endpoint to return branch contact data used by the contact page
    public function branchesData()
    {
        // Load branches and map to a simple structure
        $branches = \App\Models\Branch::orderBy('id')->get()->map(function($b){
            return [
                'key' => $b->slug ?? 'branch_'.$b->id,
                'mapSrc' => $b->map_embed ?? '',
                'locationDetail' => $b->location_detail ?? '',
                'address' => $b->address ?? '',
                'hours' => $b->hours_html ?? '',
                'contactNumber' => $b->contact_number ?? '',
                'telephoneNumber' => $b->telephone_number ?? '',
                'operatingDays' => $b->operating_days ?? '',
                'id' => $b->id,
            ];
        });

        return response()->json($branches);
    }
}
