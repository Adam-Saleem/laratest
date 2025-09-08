<?php

namespace Corals\Modules\Medical\Policies;

use Corals\Foundation\Policies\BasePolicy;
use Corals\Modules\Medical\Models\Patient;
use Corals\User\Models\User;

class PatientPolicy extends BasePolicy
{
    protected $administrationPermission = 'Administrations::admin.medical';

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Medical::patient.view')) {
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
        return $user->can('Medical::patient.create');
    }

    /**
     * @param User $user
     * @param Patient $patient
     * @return bool
     */
    public function update(User $user, Patient $patient)
    {
        if ($user->can('Medical::patient.update')) {
            return true;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Patient $patient
     * @return bool
     */
    public function destroy(User $user, Patient $patient)
    {
        if ($user->can('Medical::patient.delete')) {
            return true;
        }

        return false;
    }
}
