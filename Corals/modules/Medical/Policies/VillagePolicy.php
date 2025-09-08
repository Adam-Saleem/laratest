<?php

namespace Corals\Modules\Medical\Policies;

use Corals\Foundation\Policies\BasePolicy;
use Corals\Modules\Medical\Models\Village;
use Corals\User\Models\User;

class VillagePolicy extends BasePolicy
{
    protected $administrationPermission = 'Administrations::admin.medical';

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Medical::village.view')) {
            return true;
        }

        return false;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->can('Medical::village.create');
    }

    /**
     * @param User $user
     * @param Village $village
     * @return bool
     */
    public function update(User $user, Village $village)
    {
        if ($user->can('Medical::village.update')) {
            return true;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Village $village
     * @return bool
     */
    public function destroy(User $user, Village $village)
    {
        if ($user->can('Medical::village.delete')) {
            return true;
        }

        return false;
    }
}