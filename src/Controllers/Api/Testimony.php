<?php

namespace Src\Controllers\Api;

use Exception;
use Src\Http\Request;
use Src\Models\Entity\Testimony as EntityTestimony;
use WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Api
{
    /**
     * @param Request $request
     * @param $obPagination
     */
    private static function getTestimonyItems(Request $request, &$obPagination)
    {
        //Depoimentos
        $itens = [];

        //Quantidade total de registros
        $quantidadeTotal = EntityTestimony::getTestimonies(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //Pagina atual
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //Instancia de paginação
        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 2);

        //Resultados da página
        $result = EntityTestimony::getTestimonies(null, 'id DESC', $obPagination->getLimit());

        //Renderiza o item
        while ($obTestimony = $result->fetchObject(EntityTestimony::class)) {
            $itens[] = [
                'id'       => (int)$obTestimony->id,
                'nome'     => $obTestimony->nome,
                'mensagem' => $obTestimony->mensagem,
                'data'     => $obTestimony->data,
            ];
        }

        //Retorna os depoimentos
        return $itens;
    }


    /**
     * Método responsavel por retornar os depoimentos cadastrados
     * @param Request $request
     * @return array
     */
    public static function getTestimonies(Request $request): array
    {
        return [
            'depoimentos' => self::getTestimonyItems($request, $obPagination),
            'pagination'  => parent::getPagination($request, $obPagination)
        ];
    }

    /**
     * Método responsável por retornar os detalhes de um depoimento
     * @param Request $request
     * @param int $id
     * @return array
     * @throws Exception
     */
    public static function getTestimony(Request $request, $id) : array
    {
        //Valida o Id do depoimento
        if (!is_numeric($id)){
            throw new Exception("O id: '$id' não é válido", 400);
        }

        //Busca depoimento
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //Valida se existe
        if (!$obTestimony instanceof EntityTestimony) {
            throw new Exception("O depoimento $id não foi encontrado", 404);
        }

        //Retorna os detalhes do depoimento
        return [
            'id'       => (int)$obTestimony->id,
            'nome'     => $obTestimony->nome,
            'mensagem' => $obTestimony->mensagem,
            'data'     => $obTestimony->data,
        ];
    }
}