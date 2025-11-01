<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    public function run()
    {
        $branches = [
            [
                'key' => 'banilad',
                'name' => 'Banilad Town Centre',
                'address' => '2nd Level, Banilad Town Centre, Gov. M. Cuenco Ave., Cebu City',
                'location_detail' => '(2nd level of Banilad Town Centre)',
                'hours' => '<div><strong>Mon</strong><br><strong>Tue - Sun</strong></div><div>Closed<br>10:00 am - 07:30 pm</div>',
                'map_src' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3925.263004968588!2d123.9016596739544!3d10.320824489801565!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a9990509381945%3A0x73e7592e1d0f982f!2sSkin911%20Medical!5e0!3m2!1sen!2sph!4v1755606033060!5m2!1sen!2sph',
            ],
            [
                'key' => 'ayala',
                'name' => 'Ayala Center Cebu',
                'address' => 'Archbishop Reyes Ave, Cebu City, 6000 Cebu',
                'location_detail' => '(Ayala Center Cebu)',
                'hours' => '<div><strong>Mon - Sun</strong></div><div>10:00 am - 09:00 pm</div>',
                'map_src' => 'https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d3925.295290702664!2d123.90181517053274!3d10.318236315795497!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x33a9993c27f7ca1d%3A0x5b901072be141a1!2sArchbishop%20Reyes%20Ave%2C%20Cebu%20City%2C%206000%20Cebu!3m2!1d10.320865699999999!2d123.9041927!5e0!3m2!1sen!2sph!4v1755874091860!5m2!1sen!2sph',
            ],
            [
                'key' => 'vrama',
                'name' => 'V. Rama Avenue',
                'address' => '2211 V. Rama Ave, Cebu City, Cebu',
                'location_detail' => '(V. Rama Avenue)',
                'hours' => '<div><strong>Mon - Sat</strong><br><strong>Sun</strong></div><div>9:00 am - 6:00 pm<br>Closed</div>',
                'map_src' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3925.66693574932!2d123.8860074758835!3d10.30739946609938!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a99955776a3103%3A0x28945a1f4965c401!2s2211%20V%20Rama%20Ave%2C%20Cebu%20City%2C%20Cebu!5e0!3m2!1sen!2sph!4v1678887234567!5m2!1sen!2sph',
            ],
            [
                'key' => 'smcebu',
                'name' => 'SM City Cebu',
                'address' => 'Juan Luna Ave. corner Cabahug and Kaohsiung St., North Reclamation Area, Cebu City',
                'location_detail' => '(SM City Cebu)',
                'hours' => '<div><strong>Mon - Sun</strong></div><div>10:00 am - 10:00 pm</div>',
                'map_src' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3925.434823483981!2d123.9161218758837!3d10.326758865882885!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a999212456102b%3A0x6318371832222853!2sSM%20City%20Cebu!5e0!3m2!1sen!2sph!4v1678887345678!5m2!1sen!2sph',
            ],
            [
                'key' => 'smseaside',
                'name' => 'SM Seaside City',
                'address' => 'South Road Properties, Cebu City, Cebu',
                'location_detail' => '(SM Seaside City)',
                'hours' => '<div><strong>Mon - Sun</strong></div><div>10:00 am - 09:00 pm</div>',
                'map_src' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3925.992817293529!2d123.8790014758832!3d10.281898766318187!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a99c001802052d%3A0x321a556396e83f3b!2sSM%20Seaside%20City%20Cebu!5e0!3m2!1sen!2sph!4v1678887456789!5m2!1sen!2sph',
            ],
        ];
        foreach ($branches as $branch) {
            Branch::updateOrCreate(
                ['key' => $branch['key']],
                $branch
            );
        }
    }
}
