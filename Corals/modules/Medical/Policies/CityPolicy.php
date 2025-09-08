<?php

namespace Corals\Modules\Medical\Policies;

use Corals\Foundation\Policies\BasePolicy;
use Corals\Modules\Medical\Models\City;
use Corals\User\Models\User;

class CityPolicy extends BasePolicy
{
    protected $administrationPermission = 'Administrations::admin.medical';

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Medical::city.view')) {
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
        return $user->can('Medical::city.create');
    }

    /**
     * @param User $user
     * @param City $city
     * @return bool
     */
    public function update(User $user, City $city)
    {
        if ($user->can('Medical::city.update')) {
            return true;
        }

        return false;
    }

    /**
     * @param User $user
     * @param City $city
     * @return bool
     */
    public function destroy(User $user, City $city)
    {
        if ($user->can('Medical::city.delete')) {
            return true;
        }

        return false;
    }
}