<?php

namespace Src\Controllers\Pages;

use Src\Http\Request;
use Src\Utils\View;
use Src\Models\Entity\Testimony;
use WilliamCosta\DatabaseManager\Pagination;


class Depoimentos extends Page
{
    /**
     * Método responsavel por obter a renderização dos itens de depoimentos para a pagina
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getTestimonyItems($request, &$obPagination): string
    {
        //Depoimentos
        $itens = '';

        //Quantidade total de registro
        $quantidadeTotal = Testimony::getTestimonies(null, null,null,'COUNT(*) as qtd')->fetchObject()->qtd;

        //Página Atual
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //Instancia de paginação
        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 2);

        //Resultados da página
        $results = Testimony::getTestimonies(null, 'id DESC', $obPagination->getLimit());

        //renderiza o item
        while ($obTestimony = $results->fetchObject(Testimony::class)){

            $itens .= View::render("pages/testimony/item", [
                'nome' => $obTestimony->nome,
                'mensagem' => $obTestimony->mensagem,
                'data' => date('d/m/Y H:i:s', strtotime($obTestimony->data))
            ]);
        }

        //Retorna os depoimentos
        return $itens;
    }

	/**
     * Método responsável por retornar o conteudo de depoimentos
     * @param Request $request
	 * @return string
	 */
	public static function getDepoimentos(Request $request): string
    {
        //View de Depoimentos
		$content = View::render("pages/depoimentos", [
		    'itens' => self::getTestimonyItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination)
		]);
		//Retorna a View da Página
		return parent::getPage('Depoimentos', $content);
	}

    /**
     * Método responsável por cadastrar um depoimento
     * @param Request $request
     * @return string
     */
	public static function insertTestimony(Request $request): string
    {
        //Dados do post
	    $postVars = $request->getPostVars();

        //Nova Instancia de Depoimento
	    $obTestimony= new Testimony;
	    $obTestimony->nome = $postVars['nome'];
	    $obTestimony->mensagem = $postVars['mensagem'];
	    $obTestimony->cadastrar();

	    //Retorna a página de listagem de depoimentos
        return self::getDepoimentos($request);
    }
}