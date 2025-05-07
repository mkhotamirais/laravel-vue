<?php

namespace App\Policies;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ListingPolicy
{
    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }

    public function view(?User $user, Listing $listing): bool
    {
        return $listing->user->role !== 'user' && $listing->approved;
    }

    public function create(User $user): bool
    {
        return $user->role !== 'user';
    }

    public function modify(User $user, Listing $listing): bool
    {
        return $user->id === $listing->user_id && $user->role !== 'user';
    }

    public function approve(User $user, Listing $listing)
    {
        return $user->isAdmin();
    }
}
