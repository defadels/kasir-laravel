<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Membuat permissions untuk sistem kasir toko ATK & Print
        $permissions = [
            // Category permissions
            'view-categories',
            'create-categories',
            'edit-categories',
            'delete-categories',

            // Product permissions
            'view-products',
            'create-products',
            'edit-products',
            'delete-products',
            'manage-stock',

            // Transaction permissions
            'view-transactions',
            'create-transactions',
            'edit-transactions',
            'delete-transactions',
            'view-all-transactions',
            'print-receipts',
            'export-transactions',

            // User permissions
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',

            // Report permissions
            'view-reports',
            'view-daily-reports',
            'view-weekly-reports',
            'view-monthly-reports',
            'view-dashboard',

            // POS permissions
            'access-pos',
            'process-sales',

            // Stock management
            'view-stock-alerts',
            'manage-inventory',
        ];

        // Membuat permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Membuat roles sesuai requirements: Owner dan Kasir
        $ownerRole = Role::firstOrCreate(['name' => 'owner']);
        $kasirRole = Role::firstOrCreate(['name' => 'kasir']);

        // Assign permissions ke roles

        // Owner - memiliki semua permissions (master akses)
        $ownerRole->syncPermissions(Permission::all());

        // Kasir - permissions untuk operasional kasir (transaksi dan monitoring stok)
        $kasirRole->syncPermissions([
            'view-categories',
            'view-products',
            'view-transactions',
            'create-transactions',
            'print-receipts',
            'view-dashboard',
            'access-pos',
            'process-sales',
            'view-stock-alerts',
        ]);

        // Membuat user owner default
        $ownerUser = User::where('email', 'owner@kasir.com')->first();
        if (!$ownerUser) {
            $ownerUser = User::create([
                'name' => 'Owner Toko',
                'email' => 'owner@kasir.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
        }
        $ownerUser->assignRole('owner');

        // Membuat user kasir default
        $kasirUser = User::where('email', 'kasir@kasir.com')->first();
        if (!$kasirUser) {
            $kasirUser = User::create([
                'name' => 'Kasir',
                'email' => 'kasir@kasir.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
        }
        $kasirUser->assignRole('kasir');

        $this->command->info('Roles and permissions seeded successfully!');
        $this->command->info('Owner: owner@kasir.com / password (akses penuh)');
        $this->command->info('Kasir: kasir@kasir.com / password (transaksi & monitoring)');
    }
}
