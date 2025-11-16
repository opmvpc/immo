<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\HouseType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            ->minPrice($request->get('min_price') ? (float) $request->get('min_price') : null)
            ->maxPrice($request->get('max_price') ? (float) $request->get('max_price') : null)
            ->bedrooms($request->get('bedrooms') ? (int) $request->get('bedrooms') : null)
            ->minSize($request->get('min_size') ? (float) $request->get('min_size') : null)
            ->latest()
        ;

        return Inertia::render('Houses/Index', [
            'houses' => $query->paginate(12)->withQueryString(),
            'filters' => $request->only(['search', 'min_price', 'max_price', 'bedrooms', 'min_size']),
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
            'images.*' => ['nullable', 'image', 'max:2048'], // 2MB max par image
        ]);

        $house = auth()->user()->houses()->create($validated);

        // Gestion des images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('houses', 'public');
                $house->images()->create(['path' => $path]);
            }
        }

        return to_route('houses.index')
            ->with('success', 'Maison créée avec succès!')
        ;
    }

    /**
     * Display the specified house.
     */
    public function show(House $house): Response
    {
        $this->authorize('view', $house);

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
        $this->authorize('update', $house);

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
        $this->authorize('update', $house);

        $validated = $request->validate([
            'house_type_id' => ['required', 'exists:house_types,id'],
            'title' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'address' => ['required', 'string', 'max:255'],
            'bedrooms' => ['required', 'integer', 'min:0'],
            'size' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'images.*' => ['nullable', 'image', 'max:2048'],
        ]);

        $house->update($validated);

        // Gestion des nouvelles images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('houses', 'public');
                $house->images()->create(['path' => $path]);
            }
        }

        return back()->with('success', 'Maison mise à jour avec succès!');
    }

    /**
     * Remove the specified house from storage.
     */
    public function destroy(House $house): RedirectResponse
    {
        $this->authorize('delete', $house);

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
     * Delete a specific image from a house.
     */
    public function deleteImage(House $house, int $imageId): RedirectResponse
    {
        $this->authorize('update', $house);

        $image = $house->images()->findOrFail($imageId);

        // Supprimer le fichier du storage
        Storage::disk('public')->delete($image->path);

        // Supprimer l'enregistrement
        $image->delete();

        return back()->with('success', 'Image supprimée avec succès!');
    }
}
