<?php

namespace Database\Seeders;

use App\Models\Biodata;
use Illuminate\Database\Seeder;

class BiodataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Biodata::query()->exists()) {
            return;
        }

        Biodata::insert([
            [
                'nama' => 'rizki eka prasodjo',
                'deskripsi' => '12.11.5866 merupakan master dari uts ini dengan tugas membuat front-end dan mengirimkannya ke grup',
                'foto' => 'images/avatar-1.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'andi agus salim',
                'deskripsi' => 'dengan NIM 12.11.6018 merupakan pegawai dan mempunyai tugas mengerjakan back-end pada UTS ini',
                'foto' => 'images/avatar-2.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
