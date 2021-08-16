<?php


namespace Src\Controllers\Admin;


use Src\Http\Request;
use Src\Utils\View;
use WilliamCosta\DatabaseManager\Pagination;
use Src\Models\Entity\User as EntityUser;

class User extends Page
{
    /**
     * Método responsavel por renderizar a view de listagem de usuários
     * @param Request $request
     * @return string
     */
    public static function getUsers(Request $request): string
    {
        //Conteudo da Home
        $content = View::render('admin/modules/users/index', [
            'itens'      => self::getUserItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination),
            'status'     => self::getStatus($request)
        ]);

        //Retorna a página completa
        return parent::getPanel('Usuários', $content, 'users');
    }

    /**
     * Método responsável por retornar o formulário de cadastro de um novo usuário
     * @param Request $request
     * @return string
     */
    public static function getNewUser(Request $request): string
    {
        //Conteudo do formulário
        $content = View::render('admin/modules/users/form', [
            'title'  => 'Cadastrar Usuário',
            'nome'   => '',
            'email'  => '',
            'status' => self::getStatus($request)
        ]);

        return parent::getPanel('Cadastrar Usuário', $content, 'users');
    }

    /**
     * Método responsável por cadastrar um novo usuário no banco
     * @param Request $request
     * @return string
     */
    public static function setNewUser(Request $request)
    {
        $postVars = $request->getPostVars();

        $nome  = $postVars['nome'] ?? '';
        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';

        //Valida o email do usuário
        $obUser = EntityUser::getUserByEmail($email);
        if ($obUser instanceof EntityUser) {
            //Redireciona o Usuário
            $request->getRouter()->redirect('/admin/user/new?status=duplicated');
        }

        // Nova instancia de depoimento
        $obUser        = new EntityUser;
        $obUser->nome  = $nome;
        $obUser->email = $email;
        $obUser->senha = password_hash($senha, PASSWORD_DEFAULT);
        $obUser->cadastrar();

        //Redireciona o usuario
        $request->getRouter()->redirect('/admin/user/' . $obUser->id . '/edit?status=created');
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

        switch ($queryParams['status']) {
            case 'created':
                return Alert::getSuccess('Usuário criado com sucesso');
                break;
            case 'updated':
                return Alert::getSuccess('Usuário atualizado com sucesso');
                break;
            case 'deleted':
                return Alert::getSuccess('Usuário excluido com sucesso');
                break;
            case 'duplicated':
                return Alert::getError('O e-mail digitado já está sendo utilizado');
                break;
        }
    }

    /**
     * Método responsavel por retornar o formulário de edição de um usuário
     * @param Request $request
     * @param int $id
     * @return string
     */
    public static function getEditUser(Request $request, int $id): string
    {
        //Obtem o usuario do banco de dados
        $obUser = EntityUser::getUserById($id);

        //Valida a instancia
        if (!$obUser instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/user');
        }

        //Conteudo do formulário
        $content = View::render('admin/modules/users/form', [
            'title'  => 'Editar Usuário',
            'nome'   => $obUser->nome,
            'email'  => $obUser->email,
            'status' => self::getStatus($request)
        ]);

        return parent::getPanel('Editar Usuário', $content, 'users');
    }

    /**
     * Método responsavel por gravar a atualização de um usuário
     * @param Request $request
     * @param int $id
     * @return string
     */
    public static function setEditUser(Request $request, int $id): string
    {
        //Obtem o depoimento do banco de dados
        $obUser = EntityUser::getUserById($id);

        //Valida a instancia
        if (!$obUser instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/user');
        }

        //Post Vars
        $postVars = $request->getPostVars();

        $nome  = $postVars['nome'] ?? '';
        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';

        //Valida o email do usuário
        $obUserEmail = EntityUser::getUserByEmail($email);
        if ($obUserEmail instanceof EntityUser && $obUserEmail->id != $id) {
            //Redireciona o Usuário
            $request->getRouter()->redirect('/admin/user'.$id.'/edit?status=duplicated');
        }

        //Atualiza a Instancia
        $obUser->nome  = $nome ?? $obUser->nome;
        $obUser->email = $email ?? $obUser->email;
        $obUser->senha = password_hash($senha, PASSWORD_DEFAULT) ?? $obUser->senha;
        $obUser->atualizar();

        //Redireciona o usuario
        $request->getRouter()->redirect('/admin/user/' . $obUser->id . '/edit?status=updated');
    }

    /**
     * Método responsável por obter a renderização dos itens de usuários para a página
     * @param Request $request
     * @param $obPagination
     * @return string
     */
    private static function getUserItems(Request $request, &$obPagination): string
    {
        //Usuários
        $itens = '';

        //Quantidade total de registro
        $quantidadeTotal = EntityUser::getUsers(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //Página Atual
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //Instancia de paginação
        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 10);

        //Resultados da página
        $results = EntityUser::getUsers(null, 'id ASC', $obPagination->getLimit());

        //renderiza o item
        while ($obUser = $results->fetchObject(EntityUser::class)) {

            $itens .= View::render("admin/modules/users/item", [
                'id'    => $obUser->id,
                'nome'  => $obUser->nome,
                'email' => $obUser->email,
            ]);
        }

        //Retorna os depoimentos
        return $itens;
    }

    /**
     * Método responsavel por retornar o formulário de exclusão de um usuário
     * @param Request $request
     * @param int $id
     * @return string
     */
    public static function getDeleteUser(Request $request, int $id): string
    {
        //Obtem o depoimento do banco de dados
        $obUser = EntityUser::getUserById($id);

        //Valida a instancia
        if (!$obUser instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/user');
        }

        //Conteudo do formulário
        $content = View::render('admin/modules/users/delete', [
            'nome'  => $obUser->nome,
            'email' => $obUser->email
        ]);

        return parent::getPanel('Excluir Usuário', $content, 'users');
    }

    /**
     * Método responsavel por deletar um usuário
     * @param Request $request
     * @param int $id
     * @return string
     */
    public static function setDeleteUser(Request $request, int $id): string
    {
        //Obtem o usuário do banco de dados
        $obUser = EntityUser::getUserById($id);

        //Valida a instancia
        if (!$obUser instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/user');
        }

        //Excluir
        $obUser->excluir();

        //Redireciona o usuario
        $request->getRouter()->redirect('/admin/user?status=deleted');
    }
}