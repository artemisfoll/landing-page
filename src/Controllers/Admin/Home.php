<?php


namespace Src\Controllers\Admin;


use Src\Http\Request;
use Src\Utils\View;

class Home extends Page
{

    /**
     * Método responsavel por renderizar a view de home do painel
     * @param Request $request
     * @return string
     */
    public static function getHome(Request $request): string
    {
        //Conteudo da Home
        $content = View::render('admin/modules/home/index', []);

        //Retorna a página completa
        return parent::getPanel('Home', $content, 'home');
    }


}