<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Promo;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
      public function index()
    {
        $promos = Promo::where('active', true)
            ->where(function($query) {
                $query->whereNull('start_date')
                      ->orWhere('start_date', '<=', now());
            })
            ->where(function($query) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>=', now());
            })
            ->with(['services', 'branch'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->filter(function($promo) {
                return $promo->is_available;
            });

        return view('frontend.index', compact('promos'));
    }
    public function aboutus()
    {
        return view('frontend.aboutus');
    }
    public function services(Request $request)
    {
        $services = Service::query()->orderBy('category')->orderBy('name')->get();
        $promos = Promo::where('active', true)
            ->where(function($query) {
                $query->whereNull('start_date')
                      ->orWhere('start_date', '<=', now());
            })
            ->where(function($query) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>=', now());
            })
            ->with(['services', 'branch'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->filter(function($promo) {
                return $promo->is_available;
            });

        // Handle promo claiming
        $claimedPromo = null;
        if ($request->has('promo') && $request->promo && auth()->check()) {
            $promo = $promos->where('code', $request->promo)->first();

            if ($promo) {
                // Check if promo is available and user can claim it
                if ($promo->is_available && $promo->canUserClaim(auth()->id())) {
                    // Create promo claim
                    \App\Models\PromoClaim::create([
                        'user_id' => auth()->id(),
                        'promo_id' => $promo->id,
                        'quantity_claimed' => 1,
                        'claimed_at' => now(),
                    ]);

                    $claimedPromo = $promo;
                    session()->flash('success', 'Promo claimed successfully! Use code: ' . $promo->code);
                } else {
                    session()->flash('error', 'This promo is no longer available or you have already claimed it.');
                }
            } else {
                session()->flash('error', 'Invalid promo code.');
            }

            // Redirect to services page without promo parameter to avoid re-claiming
            return redirect()->route('services');
        }

        return view('frontend.services', compact('services', 'promos', 'claimedPromo'));
    }
    public function contact()
    {
        // Get all active branches from database with all contact information
        $branches = \App\Models\Branch::where('active', true)
                                     ->select('id', 'name', 'address', 'city', 'location_detail', 'hours', 'map_src', 'contact_number', 'telephone_number', 'operating_days')
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
