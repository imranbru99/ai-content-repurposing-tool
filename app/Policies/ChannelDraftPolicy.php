<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\ChannelDraft;
use App\Models\User;

class ChannelDraftPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role?->canAccessAdmin() ?? false;
    }

    public function view(User $user, ChannelDraft $channelDraft): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::Admin, UserRole::Manager, UserRole::Staff, UserRole::Demo], true);
    }

    public function update(User $user, ChannelDraft $channelDraft): bool
    {
        return $this->create($user);
    }

    public function delete(User $user, ChannelDraft $channelDraft): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::Admin, UserRole::Manager], true);
    }
}