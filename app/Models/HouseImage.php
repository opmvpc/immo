<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class HouseImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
    ];

    /**
     * Attributs à inclure dans la serialization JSON
     */
    protected $appends = [
        'url',
    ];

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    /**
     * Obtenir l'URL complète de l'image
     */
    public function getUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->path);
    }
}
