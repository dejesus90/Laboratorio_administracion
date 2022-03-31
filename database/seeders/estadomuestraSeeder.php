<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class estadomuestraSeeder extends Seeder
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
            ["estado"=>"Laboratorio"],
            ["estado"=>"Analisis"],
            ["estado"=>"Publicada"],
        ];
        foreach ($dataRool as  $value) {
            # code...
            DB::table('estado_muestras')->insert( [
                'estado'=> $value['estado'],
            ]);
        }
    }
}
