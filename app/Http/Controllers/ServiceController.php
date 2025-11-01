<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $treatmentDetails = [
            'Skin911 Complete Facial' => 'A deep cleansing facial that rejuvenates and hydrates your skin.',
            'Diamond Peel with complete facial' => 'Removes dead skin cells and improves skin texture.',
            'Hydrafacial' => 'Hydrates and cleanses the skin using advanced technology.',
            'Wart removal (face and neck)' => 'Safe and effective removal of facial and neck warts.',
            'Microneedling' => 'Stimulates collagen production for smoother skin.',
            'Skin Rejuvenation Laser + Facial' => 'Laser treatment combined with facial for rejuvenation.',
            'Pigmentation Laser + Facial' => 'Targets pigmentation issues for a more even skin tone.',
            'Acne laser + Acne Facial' => 'Laser and facial treatment for acne-prone skin.',
            'HIFU Ultralift' => 'Non-surgical lifting and tightening of the skin.',
            'Immuno gold + Vitamin C' => 'Boosts immunity and skin health.',
            'Elea White Drip' => 'Brightens and whitens skin tone.',
            'Cindella Drip' => 'Antioxidant drip for skin radiance.',
            'Luminous White Drip' => 'Intensive whitening and brightening treatment.',
            'Collagen Injection' => 'Improves skin elasticity and firmness.',
            'Placenta Injection' => 'Promotes skin regeneration and healing.',
            'Radio frequency RF' => 'Non-invasive slimming and contouring.',
            'Lipo Cavitation + RF' => 'Fat reduction and skin tightening combo.',
            'Lipo-cavitation' => 'Ultrasound fat reduction treatment.',
            'Diode Lipo Laser' => 'Laser-based fat reduction.',
            'TRIO slim' => 'Triple-action slimming treatment.',
            'Underarms' => 'Permanent hair removal for underarms.',
            'Bikini' => 'Permanent hair removal for bikini area.',
            'Full Brazilian' => 'Permanent hair removal for full Brazilian area.',
            'Mustache' => 'Permanent hair removal for mustache.',
            'Beard' => 'Permanent hair removal for beard.',
            'Mustache & Beard' => 'Permanent hair removal for mustache and beard.',
            'Half Legs' => 'Permanent hair removal for half legs.',
            'Full Legs' => 'Permanent hair removal for full legs.',
            'Full Arms' => 'Permanent hair removal for full arms.',
            'Full Face' => 'Permanent hair removal for full face.',
            'Chest/Back' => 'Permanent hair removal for chest and back.',
        ];

        $services = Service::all();

        return view('services.index', compact('services', 'treatmentDetails'));
    }
}
