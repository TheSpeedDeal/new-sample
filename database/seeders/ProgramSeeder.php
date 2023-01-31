<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $programs = [
            [
                'prog_id' => '1',
                'prog_coll' => '1',
                'prog_fname' => 'BSIT',
                'prog_sname' => 'Bacheloor of Science in Information Technology'
            ],
            [
                'prog_id' => '2',
                'prog_coll' => '1',
                'prog_fname' => 'BSCS',
                'prog_sname' => 'Bachelor of Science in Computer Science'
            ],            
            [
                'prog_id' => '3',
                'prog_coll' => '1',
                'prog_fname' => 'BSIS',
                'prog_sname' => 'Bachelor of Science in Information Systems'
            ],            
            [
                'prog_id' => '4',
                'prog_coll' => '1',
                'prog_fname' => 'BSEMC',
                'prog_sname' => 'Bachelor of Science in Entertainment and Multimedia Computing'
            ]            
        ];

        DB::table('programs')->insert($programs);
    }
}
