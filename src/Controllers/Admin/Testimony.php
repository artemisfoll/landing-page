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
            'itens'      => self::getTestimonyItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination),
            'status' => self::getStatus($request)
        ]);

        //Retorna a página completa
        return parent::getPanel('Depoimentos', $content, 'testimonies');
    }

    /**
     * Método responsável por retornar o formulário de cadastro de um novo depoimento
     * @param Request $request
     * @return string
     */
    public static function getNewTestimonies(Request $request): string
    {
        //Conteudo do formulário
        $content = View::render('admin/modules/testimonies/form', [
            'title'    => 'Cadastrar Depoimento',
            'nome'     => '',
            'mensagem' => '',
            'status' => ''
        ]);

        return parent::getPanel('Cadastrar Depoimento', $content, 'testimonies');
    }

    /**
     * Método responsável por cadastrar um novo depoimento no banco
     * @param Request $request
     * @return string
     */
    public static function setNewTestimonies(Request $request)
    {
        $postVars = $request->getPostVars();

        // Nova instancia de depoimento
        $obTestimony           = new EntityTestimony;
        $obTestimony->nome     = $postVars['nome'] ?? '';
        $obTestimony->mensagem = $postVars['mensagem'] ?? '';
        $obTestimony->cadastrar();

        //Redireciona o usuario
        $request->getRouter()->redirect('/admin/testimonies/' . $obTestimony->id . '/edit?status=created');
    }

    /**
     * Método responsavel por retornar a mensagem de status
     * @param Request $request
     * @return string
     */
    private static function getStatus(Request $request): string
    {
        $queryParams = $request->getQueryParams();

        if (!isset($queryParams['status'])) return '';

        switch ($queryParams['status']){
            case 'created':
                return Alert::getSuccess('Depoimento criado com sucesso');
                break;
            case 'updated':
                return Alert::getSuccess('Depoimento alterado com sucesso');
                break;
            case 'deleted':
                return Alert::getSuccess('Depoimento excluido com sucesso');
                break;
        }
    }

    /**
     * Método responsavel por retornar o formulário de edição de um depoimento
     * @param Request $request
     * @param int $id
     * @return string
     */
    public static function getEditTestimonies(Request $request, int $id): string
    {
        //Obtem o depoimento do banco de dados
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //Valida a instancia
        if (!$obTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        //Conteudo do formulário
        $content = View::render('admin/modules/testimonies/form', [
            'title'    => 'Editar Depoimento',
            'nome'     => $obTestimony->nome,
            'mensagem' => $obTestimony->mensagem,
            'status'  => self::getStatus($request)
        ]);

        return parent::getPanel('Editar Depoimento', $content, 'testimonies');
    }

    /**
     * Método responsavel por gravar a atualização de um depoimento
     * @param Request $request
     * @param int $id
     * @return string
     */
    public static function setEditTestimonies(Request $request, int $id): string
    {
        //Obtem o depoimento do banco de dados
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //Valida a instancia
        if (!$obTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        //Post Vars
        $postVars = $request->getPostVars();

        //Atualiza a Instancia
        $obTestimony->nome = $postVars['nome'] ??  $obTestimony->nome;
        $obTestimony->mensagem = $postVars['mensagem'] ??  $obTestimony->mensagem;
        $obTestimony->atualizar();

        //Redireciona o usuario
        $request->getRouter()->redirect('/admin/testimonies/' . $obTestimony->id . '/edit?status=updated');
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

    /**
     * Método responsavel por retornar o formulário de exclusão de um depoimento
     * @param Request $request
     * @param int $id
     * @return string
     */
    public static function getDeleteTestimonies(Request $request, int $id): string
    {
        //Obtem o depoimento do banco de dados
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //Valida a instancia
        if (!$obTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        //Conteudo do formulário
        $content = View::render('admin/modules/testimonies/delete', [
            'nome'     => $obTestimony->nome,
            'mensagem' => $obTestimony->mensagem
        ]);

        return parent::getPanel('Excluir Depoimento', $content, 'testimonies');
    }

    /**
         * Método responsavel por deletar um depoimento
         * @param Request $request
         * @param int $id
         * @return string
         */
        public static function setDeleteTestimonies(Request $request, int $id): string
        {
            //Obtem o depoimento do banco de dados
            $obTestimony = EntityTestimony::getTestimonyById($id);

            //Valida a instancia
            if (!$obTestimony instanceof EntityTestimony) {
                $request->getRouter()->redirect('/admin/testimonies');
            }

            //Excluir
            $obTestimony->excluir();

            //Redireciona o usuario
            $request->getRouter()->redirect('/admin/testimonies?status=deleted');
        }
}