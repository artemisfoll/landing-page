<?php

namespace Src\Controllers\Api;

use Src\Http\Request;
use WilliamCosta\DatabaseManager\Pagination;

class Api
{
    /**
     * Método responsavel por retornar os detalhes da API
     * @param Request $request
     * @return array
     */
    public static function getDetails(Request $request): array
    {
        return [
            'nome'   => 'API',
            'versão' => 'V1.0.0',
            'autor'  => 'Flavio Ortiz',
            'email'  => 'flaviohenrique_co@hotmail.com'
        ];
    }

    /**
     * Método responsável por retornar os detalhes da paginação
     * @param Request $request
     * @param Pagination $obPagination
     * @return array
     */
    protected static function getPagination(Request $request, Pagination $obPagination): array
    {
        //Query params
        $queryParams = $request->getQueryParams();
        //Paginas
        $pages = $obPagination->getPages();

        //Retorno dos dados
        return [
            'paginaAtual' => isset($queryParams['page']) ? (int)$queryParams['page'] : 1,
            'quantidadePaginas' => !empty($pages) ? count($pages) : 1
        ];
    }
}