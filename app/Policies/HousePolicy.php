<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\House;
use App\Models\User;

class HousePolicy
{
    /**
     * Determine if the user can view any houses.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can view the house.
     */
    public function view(User $user, House $house): bool
    {
        return $user->id === $house->user_id;
    }

    /**
     * Determine if the user can create houses.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can update the house.
     */
    public function update(User $user, House $house): bool
    {
        return $user->id === $house->user_id;
    }

    /**
     * Determine if the user can delete the house.
     */
    public function delete(User $user, House $house): bool
    {
        return $user->id === $house->user_id;
    }

    /**
     * Determine if the user can restore the house.
     */
    public function restore(User $user, House $house): bool
    {
        return $user->id === $house->user_id;
    }

    /**
     * Determine if the user can permanently delete the house.
     */
    public function forceDelete(User $user, House $house): bool
    {
        return $user->id === $house->user_id;
    }
}
