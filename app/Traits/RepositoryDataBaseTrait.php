<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Exception;

/**
 * Trait de comunicação com o banco de dados
 * Final nos métodos para não serem sobrescritos
 */
trait RepositoryDataBaseTrait
{
    /**
     * Insere dados no banco de dados
     * @throws Exception
     */
    final public function insert(Object $object, array $data): bool
    {
        try {
            DB::beginTransaction();

            $object::create($data);

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }

    /**
     * Realiza o update
     * @param Object $object
     * @param int $valueId
     * @param array $data
     * @return bool
     * @throws Exception
     */
    final public function update(Object $object, int $valueId, array $data): bool
    {
        try {
            DB::beginTransaction();

            $object::where("id", $valueId)->update($data);

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception("Erro ao atualizar dado no banco de dados");
        }
    }

    /**
     * Captura informações no banco de dados a partir de uma coluna e um valor
     * @param Object $object
     * @param string $column
     * @param string $value
     * @return mixed
     */
    final public function getDataBySimpleQuery(Object $object, string $column, string $value): array
    {
        return $object::where($column, $value)->get()->toArray();
    }

    /**
     * Captura todos os dados do banco de dados
     * @param Object $object
     * @return mixed
     */
    final public function getAllData(Object $object): array
    {
        return $object::all()->toArray();
    }

    /**
     * Deleta um dado a partir de um id no banco de dados
     * @param Object $object
     * @param int $valueId
     * @return bool
     * @throws Exception
     */
    final public function delete(Object $object, int $valueId): bool
    {
        try {
            DB::beginTransaction();

            $object::where("id", $valueId)->delete();

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception("Erro ao excluir dado no banco de dados");
        }
    }
}
