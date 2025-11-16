<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\HouseType;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FrontController extends Controller
{
    /**
     * Display the public homepage with available houses.
     */
    public function index(Request $request): Response
    {
        $query = House::query()
            ->with(['images', 'houseType'])
            ->latest();

        // Filtres de recherche
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', (float) $request->get('price_min'));
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', (float) $request->get('price_max'));
        }

        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', (int) $request->get('bedrooms'));
        }

        if ($request->filled('house_type_id')) {
            $query->where('house_type_id', (int) $request->get('house_type_id'));
        }

        $houses = $query->paginate(9)->withQueryString();

        // Image pour le hero - prendre une belle maison avec images
        $heroHouse = House::query()
            ->with('images')
            ->whereHas('images')
            ->inRandomOrder()
            ->first();

        return Inertia::render('Front/Index', [
            'houses' => $houses,
            'houseTypes' => HouseType::all(),
            'filters' => $request->only(['search', 'price_min', 'price_max', 'bedrooms', 'house_type_id']),
            'heroImage' => $heroHouse?->images?->first()?->url,
        ]);
    }

    /**
     * Display a specific house details.
     */
    public function show(House $house): Response
    {
        $house->load(['images', 'houseType']);

        // Suggestions de biens similaires
        $similarHouses = House::query()
            ->with(['images', 'houseType'])
            ->where('id', '!=', $house->id)
            ->where('house_type_id', $house->house_type_id)
            ->limit(3)
            ->get();

        return Inertia::render('Front/Show', [
            'house' => $house,
            'similarHouses' => $similarHouses,
        ]);
    }
}
