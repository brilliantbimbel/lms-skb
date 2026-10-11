<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [
            [
                'code' => 'paket-a',
                'name' => 'Paket A (Setara SD)',
                'description' => 'Program pendidikan kesetaraan tingkat dasar setara Sekolah Dasar.',
            ],
            [
                'code' => 'paket-b',
                'name' => 'Paket B (Setara SMP)',
                'description' => 'Program pendidikan kesetaraan tingkat menengah pertama setara SMP.',
            ],
            [
                'code' => 'paket-c',
                'name' => 'Paket C (Setara SMA)',
                'description' => 'Program pendidikan kesetaraan tingkat menengah atas setara SMA.',
            ],
        ];

        foreach ($programs as $prog) {
            Program::firstOrCreate(['code' => $prog['code']], $prog);
        }
    }
}
