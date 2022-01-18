<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Receitas\CreateService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReceitasController extends Controller
{
    public function __construct(
        private CreateService $createService
    ) {
        
    }
    /**
     * Store a new flight in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'descricao' => 'required|max:255',
            'valor' => 'required',
            'data' => 'required|date'
        ]);

        $response = $this->createService->createInDatabase($request);

        if($response){
            return response(
                "Receita criada com sucesso",
                Response::HTTP_CREATED
            );
        }

        return response(
            "Não foi possível criar receita no banco de dados",
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}