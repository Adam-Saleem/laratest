<?php

namespace Corals\Modules\Medical\database\seeds;

use Corals\User\Models\Role;
use Corals\User\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

class MedicalPermissionsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [];

        $permissions[] = [
            'name' => 'Administrations::admin.medical',
        ];

        $models = ['patient'];

        $levels = ['view', 'create', 'update', 'delete', 'restore', 'hardDelete'];

        foreach ($models as $model) {
            foreach ($levels as $level) {
                $permissions[] = [
                    'name' => 'Medical::' . $model . '.' . $level,
                ];
            }
        }

        $permissions = array_map(function ($item) {
            return array_merge($item, [
                'guard_name' => config('auth.defaults.guard'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }, $permissions);

        DB::table('permissions')->insert($permissions);

        $medicalAdminRole = Role::create([
            'name' => 'medical_admin',
            'label' => 'Medical Admin',
            'guard_name' => config('auth.defaults.guard'),
        ]);

        $medicalAdminRole->givePermissionTo('Administrations::admin.medical');

        $jaAdminUser = tap(User::make([
            'name' => 'Medical',
            'last_name' => 'Admin',
            'email' => 'admin@corals.io',
            'username' => 'medical-admin',
            'password' => '123456',
            'job_title' => 'Medical Admin',
            'address' => null,
            'confirmed_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]), function (User $user) use ($medicalAdminRole) {
            $user->save();
            $user->assignRole($medicalAdminRole);
        });


        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
