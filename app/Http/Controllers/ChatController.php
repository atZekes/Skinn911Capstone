<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Branch;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    // Get all unique service categories
    public function getCategories()
    {
        // Get all unique categories from services table
        $categories = Service::distinct()
            ->pluck('category')
            ->filter() // Remove null or empty values
            ->values() // Reset array keys
            ->toArray();

        return response()->json([
            'success' => true,
            'categories' => $categories
        ]);
    }

    // Get services by category
    public function getServicesByCategory($category)
    {
        // Get all services for the selected category
        // Group by name to avoid duplicates
        $services = Service::where('category', $category)
            ->select('id', 'name', 'price', 'description')
            ->orderBy('name')
            ->get()
            ->unique('name') // Remove duplicates by name
            ->values() // Reset array keys
            ->map(function($service) {
                return [
                    'id' => $service->id,
                    'name' => $service->name,
                    'price' => '₱' . number_format($service->price, 2),
                    'description' => $service->description
                ];
            });

        return response()->json([
            'success' => true,
            'category' => $category,
            'services' => $services
        ]);
    }

    // Get branch opening hours
    public function getBranchHours()
    {
        // Get all active branches with their hours
        $branches = Branch::where('active', 1)
            ->select('id', 'name', 'address', 'time_slot', 'operating_days', 'contact_number')
            ->orderBy('name')
            ->get()
            ->map(function($branch) {
                // Parse operating days
                $operatingDays = explode(',', $branch->operating_days);

                // Format the time slot (e.g., "10:00 - 22:00")
                $timeSlot = $branch->time_slot;

                return [
                    'id' => $branch->id,
                    'name' => $branch->name,
                    'address' => $branch->address,
                    'hours' => $timeSlot,
                    'days' => $operatingDays,
                    'contact' => $branch->contact_number
                ];
            });

        return response()->json([
            'success' => true,
            'branches' => $branches
        ]);
    }
}
