<?php


namespace Src\Controllers\Admin;


use Src\Http\Request;
use Src\Utils\View;
use WilliamCosta\DatabaseManager\Pagination;
use Src\Models\Entity\Testimony as EntityTestimony;

class Testimony extends Page
{
    /**
     * Método responsavel por renderizar a view de listagem de depoimentos
     * @param Request $request
     * @return string
     */
    public static function getTestimonies(Request $request): string
    {
        //Conteudo da Home
        $content = View::render('admin/modules/testimonies/index', [
            'itens' => self::getTestimonyItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination)
        ]);

        //Retorna a página completa
        return parent::getPanel('Depoimentos', $content, 'testimonies');
    }

    private static function getTestimonyItems($request, &$obPagination): string
    {
        //Depoimentos
        $itens = '';

        //Quantidade total de registro
        $quantidadeTotal = EntityTestimony::getTestimonies(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //Página Atual
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //Instancia de paginação
        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 2);

        //Resultados da página
        $results = EntityTestimony::getTestimonies(null, 'id DESC', $obPagination->getLimit());

        //renderiza o item
        while ($obTestimony = $results->fetchObject(Testimony::class)) {

            $itens .= View::render("admin/modules/testimonies/item", [
                'id'    => $obTestimony->id,
                'nome'  => $obTestimony->nome,
                'texto' => $obTestimony->mensagem,
                'data'  => date('d/m/Y H:i:s', strtotime($obTestimony->data))
            ]);
        }

        //Retorna os depoimentos
        return $itens;
    }
}