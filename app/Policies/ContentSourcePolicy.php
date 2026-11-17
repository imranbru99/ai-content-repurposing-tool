<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\ContentSource;
use App\Models\User;

class ContentSourcePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role?->canAccessAdmin() ?? false;
    }

    public function view(User $user, ContentSource $contentSource): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::Admin, UserRole::Manager, UserRole::Staff, UserRole::Demo], true);
    }

    public function update(User $user, ContentSource $contentSource): bool
    {
        return $this->create($user);
    }

    public function delete(User $user, ContentSource $contentSource): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::Admin, UserRole::Manager], true);
    }
}