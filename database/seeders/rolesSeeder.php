<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class rolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $dataRool = [
            ["rol"=>"root"],
            ["rol"=>"admin"],
            ["rol"=>"user"],
            ["rol"=>"paciente"]
        ];
        foreach ($dataRool as  $value) {
            # code...
            DB::table('roles')->insert( [
                'rol'=> $value['rol'],
                'activo'=>1,
            ]);
        }
        



    }
}
