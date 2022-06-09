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
                'Despesa criada com sucesso',
                Response::HTTP_CREATED
            );
        } catch (ValidationException | DatabaseException | NotFoundException $e) {
            $defaultMessageText = 'Erro ao inserir despesa no banco de dados';
            if ($e instanceof ValidationException) {
                $defaultMessageText = $e->errors();
            }
            if ($e instanceof NotFoundException) {
                $defaultMessageText = $e->getMessage();
            }
            return response(
                $defaultMessageText,
                $e->status
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
        } catch (ValidationException | AlreadyExistsInDatabase | NotFoundException $e) {
            $defaultMessageText = 'Erro ao inserir despesa no banco de dados';
            if ($e instanceof ValidationException) {
                $defaultMessageText = $e->errors();
            }
            if ($e instanceof NotFoundException || $e instanceof AlreadyExistsInDatabase) {
                $defaultMessageText = $e->getMessage();
            }
            return response(
                $defaultMessageText,
                $e->status
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
