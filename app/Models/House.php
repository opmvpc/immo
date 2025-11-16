<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class House extends Model
{
    use HasFactory;

    protected $fillable = [
        'house_type_id',
        'title',
        'price',
        'address',
        'bedrooms',
        'size',
        'description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'size' => 'decimal:2',
        'bedrooms' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function houseType(): BelongsTo
    {
        return $this->belongsTo(HouseType::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(HouseImage::class);
    }

    /**
     * Scope pour la recherche.
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
            ;
        });
    }

    /**
     * Scope pour filtrer par prix min.
     */
    public function scopeMinPrice(Builder $query, ?float $price): Builder
    {
        if (!$price) {
            return $query;
        }

        return $query->where('price', '>=', $price);
    }

    /**
     * Scope pour filtrer par prix max.
     */
    public function scopeMaxPrice(Builder $query, ?float $price): Builder
    {
        if (!$price) {
            return $query;
        }

        return $query->where('price', '<=', $price);
    }

    /**
     * Scope pour filtrer par nombre de chambres.
     */
    public function scopeBedrooms(Builder $query, ?int $bedrooms): Builder
    {
        if (!$bedrooms) {
            return $query;
        }

        return $query->where('bedrooms', $bedrooms);
    }

    /**
     * Scope pour filtrer par taille minimale.
     */
    public function scopeMinSize(Builder $query, ?float $size): Builder
    {
        if (!$size) {
            return $query;
        }

        return $query->where('size', '>=', $size);
    }

    /**
     * Scope pour filtrer par type de bien.
     */
    public function scopeHouseType(Builder $query, ?int $houseTypeId): Builder
    {
        if (!$houseTypeId) {
            return $query;
        }

        return $query->where('house_type_id', $houseTypeId);
    }
}
