<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the service.
     */
    public function update(User $user, Service $service)
    {
        return $user->id === $service->seller_id;
    }

    /**
     * Determine whether the user can delete the service.
     */
    public function delete(User $user, Service $service)
    {
        return $user->id === $service->seller_id;
    }
}
