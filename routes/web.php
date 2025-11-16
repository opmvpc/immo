<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\HouseController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

// Public routes - Frontend vitrine
Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/biens/{house}', [FrontController::class, 'show'])->name('front.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        $housesCount = auth()->user()->houses()->count();
        $totalValue = auth()->user()->houses()->sum('price');
        $averagePrice = $housesCount > 0 ? $totalValue / $housesCount : 0;
        $recentHouses = auth()->user()->houses()->with('images')->latest()->take(3)->get();

        return Inertia::render('Dashboard', [
            'stats' => [
                'houses_count' => $housesCount,
                'total_value' => $totalValue,
                'average_price' => $averagePrice,
            ],
            'recent_houses' => $recentHouses,
        ]);
    })->name('dashboard');

    // Routes pour les maisons
    Route::resource('houses', HouseController::class);
    Route::post('houses/{house}/images', [HouseController::class, 'uploadImages'])
        ->name('houses.images.store');
    Route::delete('houses/{house}/images/{image}', [HouseController::class, 'deleteImage'])
        ->name('houses.images.destroy');
});

require __DIR__.'/settings.php';
