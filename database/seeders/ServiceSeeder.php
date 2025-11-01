<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('services')->insert([
                // Facial Services
                ['name' => 'Skin911 Complete Facial', 'category' => 'Facial Services', 'price' => 1100, 'description' => null, 'treatment_details' => 'A deep cleansing facial that rejuvenates and hydrates your skin. Ideal for all skin types and helps restore a healthy glow.', 'image' => 'img/services/skin1.jpg'],
                ['name' => 'Diamond Peel with complete facial', 'category' => 'Facial Services', 'price' => 2000, 'description' => null, 'treatment_details' => 'Removes dead skin cells and improves skin texture. Perfect for reducing fine lines and brightening complexion.', 'image' => 'img/services/skin2.jpg'],
                ['name' => 'Hydrafacial', 'category' => 'Facial Services', 'price' => 2800, 'description' => null, 'treatment_details' => 'Hydrates and cleanses the skin using advanced technology. Leaves your skin feeling refreshed and deeply moisturized.', 'image' => 'img/services/skin3.jpg'],
                ['name' => 'Wart removal (face and neck)', 'category' => 'Facial Services', 'price' => 2000, 'description' => null, 'treatment_details' => 'Safe and effective removal of facial and neck warts. Quick procedure with minimal discomfort and downtime.', 'image' => 'img/services/skin4.jpg'],
                ['name' => 'Microneedling', 'category' => 'Facial Services', 'price' => 4500, 'description' => null, 'treatment_details' => 'Stimulates collagen production for smoother skin. Reduces scars, wrinkles, and improves overall skin texture.', 'image' => 'img/services/skin5.jpg'],
                ['name' => 'Skin Rejuvenation Laser + Facial', 'category' => 'Facial Services', 'price' => 3000, 'description' => null, 'treatment_details' => 'Laser treatment combined with facial for rejuvenation. Helps reduce pigmentation and signs of aging.', 'image' => 'img/services/skin1.jpg'],
                ['name' => 'Pigmentation Laser + Facial', 'category' => 'Facial Services', 'price' => 3000, 'description' => null, 'treatment_details' => 'Targets pigmentation issues for a more even skin tone. Effective for sun spots and melasma.', 'image' => 'img/services/skin2.jpg'],
                ['name' => 'Acne laser + Acne Facial', 'category' => 'Facial Services', 'price' => 2700, 'description' => null, 'treatment_details' => 'Laser and facial treatment for acne-prone skin. Minimizes breakouts and promotes clearer skin.', 'image' => 'img/services/skin3.jpg'],
                ['name' => 'HIFU Ultralift', 'category' => 'Facial Services', 'price' => 5000, 'description' => null, 'treatment_details' => 'Non-surgical lifting and tightening of the skin. Results in firmer, more youthful appearance.', 'image' => 'img/services/skin4.jpg'],
                // Immuno Boosters
                ['name' => 'Immuno gold + Vitamin C', 'category' => 'Immuno Boosters', 'price' => 1500, 'description' => null, 'treatment_details' => 'Boosts immunity and skin health. Enhances skin radiance and overall wellness.', 'image' => 'img/services/skin5.jpg'],
                ['name' => 'Elea White Drip', 'category' => 'Immuno Boosters', 'price' => 6500, 'description' => null, 'treatment_details' => 'Brightens and whitens skin tone. Provides antioxidant protection and hydration.', 'image' => 'img/services/skin1.jpg'],
                ['name' => 'Cindella Drip', 'category' => 'Immuno Boosters', 'price' => 3000, 'description' => null, 'treatment_details' => 'Antioxidant drip for skin radiance. Revitalizes dull skin and supports detoxification.', 'image' => 'img/services/skin2.jpg'],
                ['name' => 'Luminous White Drip', 'category' => 'Immuno Boosters', 'price' => 4500, 'description' => null, 'treatment_details' => 'Intensive whitening and brightening treatment. Improves skin clarity and luminosity.', 'image' => 'img/services/skin3.jpg'],
                ['name' => 'Collagen Injection', 'category' => 'Immuno Boosters', 'price' => 2000, 'description' => null, 'treatment_details' => 'Improves skin elasticity and firmness. Helps reduce wrinkles and maintain youthful skin.', 'image' => 'img/services/skin4.jpg'],
                ['name' => 'Placenta Injection', 'category' => 'Immuno Boosters', 'price' => 2000, 'description' => null, 'treatment_details' => 'Promotes skin regeneration and healing. Supports cell renewal for healthier skin.', 'image' => 'img/services/skin5.jpg'],
                // Slimming Services
                ['name' => 'Radio frequency RF', 'category' => 'Slimming Services', 'price' => 2500, 'description' => null, 'treatment_details' => 'Non-invasive slimming and contouring. Tightens skin and reduces stubborn fat.', 'image' => 'img/services/skin1.jpg'],
                ['name' => 'Lipo Cavitation + RF', 'category' => 'Slimming Services', 'price' => 4000, 'description' => null, 'treatment_details' => 'Fat reduction and skin tightening combo. Effective for body sculpting and cellulite reduction.', 'image' => 'img/services/skin2.jpg'],
                ['name' => 'Lipo-cavitation', 'category' => 'Slimming Services', 'price' => 2500, 'description' => null, 'treatment_details' => 'Ultrasound fat reduction treatment. Targets localized fat deposits for a slimmer look.', 'image' => 'img/services/skin3.jpg'],
                ['name' => 'Diode Lipo Laser', 'category' => 'Slimming Services', 'price' => 3500, 'description' => null, 'treatment_details' => 'Laser-based fat reduction. Safe and painless way to contour your body.', 'image' => 'img/services/skin4.jpg'],
                ['name' => 'TRIO slim', 'category' => 'Slimming Services', 'price' => 5000, 'description' => null, 'treatment_details' => 'Triple-action slimming treatment. Combines multiple technologies for maximum results.', 'image' => 'img/services/skin5.jpg'],
                // Permanent Hair Removal
                ['name' => 'Underarms', 'category' => 'Permanent Hair Removal', 'price' => 7000, 'description' => null, 'treatment_details' => 'Permanent hair removal for underarms. Leaves skin smooth and hair-free for longer.', 'image' => 'img/services/skin1.jpg'],
                ['name' => 'Bikini', 'category' => 'Permanent Hair Removal', 'price' => 5000, 'description' => null, 'treatment_details' => 'Permanent hair removal for bikini area. Gentle and effective for sensitive skin.', 'image' => 'img/services/skin2.jpg'],
                ['name' => 'Full Brazilian', 'category' => 'Permanent Hair Removal', 'price' => 9000, 'description' => null, 'treatment_details' => 'Permanent hair removal for full Brazilian area. Achieve long-lasting smoothness and comfort.', 'image' => 'img/services/skin3.jpg'],
                ['name' => 'Mustache', 'category' => 'Permanent Hair Removal', 'price' => 4000, 'description' => null, 'treatment_details' => 'Permanent hair removal for mustache. Quick and precise treatment for facial hair.', 'image' => 'img/services/skin4.jpg'],
                ['name' => 'Beard', 'category' => 'Permanent Hair Removal', 'price' => 7500, 'description' => null, 'treatment_details' => 'Permanent hair removal for beard. Suitable for all beard types and skin tones.', 'image' => 'img/services/skin5.jpg'],
                ['name' => 'Mustache & Beard', 'category' => 'Permanent Hair Removal', 'price' => 8000, 'description' => null, 'treatment_details' => 'Permanent hair removal for mustache and beard. Comprehensive solution for facial hair removal.', 'image' => 'img/services/skin1.jpg'],
                ['name' => 'Half Legs', 'category' => 'Permanent Hair Removal', 'price' => 7500, 'description' => null, 'treatment_details' => 'Permanent hair removal for half legs. Enjoy smooth legs with minimal maintenance.', 'image' => 'img/services/skin2.jpg'],
                ['name' => 'Full Legs', 'category' => 'Permanent Hair Removal', 'price' => 9500, 'description' => null, 'treatment_details' => 'Permanent hair removal for full legs. Ideal for those seeking complete leg smoothness.', 'image' => 'img/services/skin3.jpg'],
                ['name' => 'Full Arms', 'category' => 'Permanent Hair Removal', 'price' => 8000, 'description' => null, 'treatment_details' => 'Permanent hair removal for full arms. Effective for both men and women.', 'image' => 'img/services/skin4.jpg'],
                ['name' => 'Full Face', 'category' => 'Permanent Hair Removal', 'price' => 9000, 'description' => null, 'treatment_details' => 'Permanent hair removal for full face. Achieve flawless, hair-free facial skin.', 'image' => 'img/services/skin5.jpg'],
                ['name' => 'Chest/Back', 'category' => 'Permanent Hair Removal', 'price' => 10000, 'description' => null, 'treatment_details' => 'Permanent hair removal for chest and back. Great for larger areas and long-lasting results.', 'image' => 'img/services/skin1.jpg'],
        ]);
    }
}
