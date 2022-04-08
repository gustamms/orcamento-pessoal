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
        DB::table('categorias_despesas')->insert(
            [
                "descricao" => "alimentacao"
            ]
        );

        DB::table('categorias_despesas')->insert(
            [
                "descricao" => "saude"
            ]
        );

        DB::table('categorias_despesas')->insert(
            [
                "descricao" => "moradia"
            ]
        );

        DB::table('categorias_despesas')->insert(
            [
                "descricao" => "transporte"
            ]
        );

        DB::table('categorias_despesas')->insert(
            [
                "descricao" => "educacao"
            ]
        );

        DB::table('categorias_despesas')->insert(
            [
                "descricao" => "lazer"
            ]
        );

        DB::table('categorias_despesas')->insert(
            [
                "descricao" => "imprevistos"
            ]
        );

        DB::table('categorias_despesas')->insert(
            [
                "descricao" => "outras"
            ]
        );
    }
}
