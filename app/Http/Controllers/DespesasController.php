<?php

namespace App\Http\Controllers;

use App\Exceptions\AlreadyExistsInDatabase;
use App\Exceptions\DatabaseException;
use App\Exceptions\NotFoundException;
use App\Services\Despesas\CreateService;
use App\Services\Despesas\DespesaService;
use App\Services\Despesas\UpdateService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class DespesasController extends Controller
{
    public function __construct(
        private CreateService $createService,
        private DespesaService $despesaService,
        private UpdateService $updateService
    ) {
    }

    public function index()
    {
        return $this->despesaService->getDespesas();
    }

    public function show(int $id)
    {
        try {
            return $this->despesaService->getById($id);
        } catch (NotFoundException $e) {
            return response(
                $e->getMessage(),
                Response::HTTP_NOT_FOUND
            );
        }
    }

    public function store(Request $request): Response
    {
        try {
            $this->validate($request, [
                'descricao' => 'required|max:255',
                'valor' => 'required',
                'data' => 'required|date'
            ]);

            $this->createService->createDespesa($request);

            return response(
                "Despesa criada com sucesso",
                Response::HTTP_CREATED
            );
        } catch (ValidationException $e) {
            return response(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        } catch (DatabaseException $e) {
            return response(
                'Erro ao inserir despesa no banco de dados',
                response::HTTP_INTERNAL_SERVER_ERROR
            );
        } catch (NotFoundException $e) {
            return response(
                $e->getMessage(),
                response::HTTP_NOT_FOUND
            );
        }
    }

    public function update(int $id, Request $request): Response
    {
        try {
            $this->validate($request, [
                'descricao' => 'required|max:255',
                'valor' => 'required',
                'data' => 'required|date'
            ]);

            $this->updateService->updateDespesa($id, $request);

            return response(
                "Despesa alterada com sucesso",
                Response::HTTP_CREATED
            );
        } catch (NotFoundException $e) {
            return response(
                $e->getMessage(),
                Response::HTTP_NOT_FOUND
            );
        } catch (AlreadyExistsInDatabase $e) {
            return response(
                $e->getMessage(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }

    public function destroy(int $id): Response
    {
        try {
            $this->despesaService->destroy($id);

            return response('Despesa excluída com sucesso', Response::HTTP_OK);
        } catch (NotFoundException | DatabaseException $e) {
            return response(
                $e->getMessage(),
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
