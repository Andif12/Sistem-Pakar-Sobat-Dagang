<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DisdagSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'nip' => '196501011990031001',
                'email' => 'master_admin@disdag.local',
                'role' => 'master_admin',
            ],
            [
                'nip' => '197201021993041002',
                'email' => 'admin_perdagangan@disdag.local',
                'role' => 'admin_perdagangan',
            ],
            [
                'nip' => '197305031994051003',
                'email' => 'admin_industri@disdag.local',
                'role' => 'admin_industri',
            ],
            [
                'nip' => '197406041995061004',
                'email' => 'admin_metrologi@disdag.local',
                'role' => 'admin_metrologi',
            ],
            [
                'nip' => '197507051996071005',
                'email' => 'kabid_perdagangan@disdag.local',
                'role' => 'kabid_perdagangan',
            ],
            [
                'nip' => '197608061997081006',
                'email' => 'kabid_industri@disdag.local',
                'role' => 'kabid_industri',
            ],
            [
                'nip' => '197709071998091007',
                'email' => 'kabid_metrologi@disdag.local',
                'role' => 'kabid_metrologi',
            ],
            [
                'nip' => '197810081999101008',
                'email' => 'kepala_dinas@disdag.local',
                'role' => 'kepala_dinas',
            ],
        ];

        foreach ($users as $user) {
            DB::table('disdag')->insert([
                'nip' => $user['nip'],
                'email' => $user['email'],
                'password' => Hash::make('sobatdagang01!'),
                'telp' => '08123456789',
                'role' => $user['role'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}