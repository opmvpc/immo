<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\HouseType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class HouseController extends Controller
{
    /**
     * Display a listing of the houses.
     */
    public function index(Request $request): Response
    {
        $query = House::query()
            ->where('user_id', auth()->id())
            ->with(['images', 'houseType'])
            ->search($request->get('search'))
            ->houseType($request->get('house_type_id') ? (int) $request->get('house_type_id') : null)
            ->minPrice($request->get('min_price') ? (float) $request->get('min_price') : null)
            ->maxPrice($request->get('max_price') ? (float) $request->get('max_price') : null)
            ->bedrooms($request->get('bedrooms') ? (int) $request->get('bedrooms') : null)
            ->minSize($request->get('min_size') ? (float) $request->get('min_size') : null)
            ->latest()
        ;

        return Inertia::render('Houses/Index', [
            'houses' => $query->paginate(12)->withQueryString(),
            'filters' => $request->only(['search', 'house_type_id', 'min_price', 'max_price', 'bedrooms', 'min_size']),
            'houseTypes' => HouseType::all(),
        ]);
    }

    /**
     * Show the form for creating a new house.
     */
    public function create(): Response
    {
        return Inertia::render('Houses/Create', [
            'houseTypes' => HouseType::all(),
        ]);
    }

    /**
     * Store a newly created house in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'house_type_id' => ['required', 'exists:house_types,id'],
            'title' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'address' => ['required', 'string', 'max:255'],
            'bedrooms' => ['required', 'integer', 'min:0'],
            'size' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);

        $house = auth()->user()->houses()->create($validated);

        return to_route('houses.edit', $house)
            ->with('success', 'Maison créée avec succès! Vous pouvez maintenant ajouter des images.')
        ;
    }

    /**
     * Display the specified house.
     */
    public function show(House $house): Response
    {
        Gate::authorize('view', $house);

        $house->load('images', 'user', 'houseType');

        return Inertia::render('Houses/Show', [
            'house' => $house,
        ]);
    }

    /**
     * Show the form for editing the specified house.
     */
    public function edit(House $house): Response
    {
        Gate::authorize('update', $house);

        $house->load('images');

        return Inertia::render('Houses/Edit', [
            'house' => $house,
            'houseTypes' => HouseType::all(),
        ]);
    }

    /**
     * Update the specified house in storage.
     */
    public function update(Request $request, House $house): RedirectResponse
    {
        Gate::authorize('update', $house);

        $validated = $request->validate([
            'house_type_id' => ['required', 'exists:house_types,id'],
            'title' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'address' => ['required', 'string', 'max:255'],
            'bedrooms' => ['required', 'integer', 'min:0'],
            'size' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);

        $house->update($validated);

        return back()->with('success', 'Maison mise à jour avec succès!');
    }

    /**
     * Remove the specified house from storage.
     */
    public function destroy(House $house): RedirectResponse
    {
        Gate::authorize('delete', $house);

        // Supprimer les images du storage
        foreach ($house->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $house->delete();

        return to_route('houses.index')
            ->with('success', 'Maison supprimée avec succès!')
        ;
    }

    /**
     * Upload new images for a house.
     */
    public function uploadImages(Request $request, House $house): RedirectResponse
    {
        Gate::authorize('update', $house);

        $validated = $request->validate([
            'images' => ['required', 'array'],
            'images.*' => ['required', 'image', 'max:2048'], // 2MB max par image
        ]);

        if ($request->hasFile('images')) {
            $count = 0;
            foreach ($request->file('images') as $image) {
                $path = $image->store('houses', 'public');
                $house->images()->create([
                    'path' => $path,
                ]);
                ++$count;
            }

            return back()->with('success', "{$count} image(s) ajoutée(s) avec succès!");
        }

        return back()->with('error', 'Aucune image n\'a été uploadée.');
    }

    /**
     * Delete a specific image from a house.
     */
    public function deleteImage(House $house, int $imageId): RedirectResponse
    {
        Gate::authorize('update', $house);

        $image = $house->images()->findOrFail($imageId);

        // Supprimer le fichier du storage
        Storage::disk('public')->delete($image->path);

        // Supprimer l'enregistrement
        $image->delete();

        return back()->with('success', 'Image supprimée avec succès!');
    }
}
