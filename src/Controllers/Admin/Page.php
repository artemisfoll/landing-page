<?php


namespace Src\Controllers\Admin;


use Src\Utils\View;

class Page
{
    /**
     * Método responsavel por retornar o conteúdo (view) da estrutura generica de página do painel
     * @param string $title
     * @param string $content
     * @return string
     */
    public static function getPage(string $title, string $content): string
    {
        return View::render('admin/page', [
            'title' => $title,
            'content' => $content
        ]);
    }
}