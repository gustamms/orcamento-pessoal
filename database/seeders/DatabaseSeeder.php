<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "descricao" => "Alimentacao"
            ],
            [
                "descricao" => "Saude"
            ],
            [
                "descricao" => "Moradia"
            ],
            [
                "descricao" => "Transporte"
            ],
            [
                "descricao" => "Educacao"
            ],
            [
                "descricao" => "Lazer"
            ],
            [
                "descricao" => "Imprevistos"
            ],
            [
                "descricao" => "Outras"
            ]
        ];

        foreach ($data as $dataUm) {
            DB::table("categorias_despesas")->insert(
                $dataUm
            );
        }

    }
}
