<?php


namespace Src\Controllers\Pages;


use Src\Http\Request;
use Src\Utils\View;
use WilliamCosta\DatabaseManager\Pagination;

class Page
{
    /**
     * Método responsável por renderizar o header da página
     * @return string
     */
    private static function getHeader()
    {
        return View::render('pages/header');
    }

    /**
     * Método responsável por renderizar o footer da página
     * @return string
     */
    private static function getFooter()
    {
        return View::render('pages/footer');
    }

    /**
     * Método responsável por renderizar o layout de paginação
     * @param Request $request
     * @param Pagination $obOagination
     * @return string
     */
    public static function getPagination(Request $request, Pagination $obOagination): string
    {
        //Páginas
        $pages = $obOagination->getPages();

        //Verifica a Quantidade de páginas
        if (count($pages) <= 1) return '';

        //Links
        $links = '';

        //URL atual sem GETs
        $url = $request->getRouter()->getCurrentUrl();

        //GET
        $queryParams = $request->getQueryParams();

        //Renderiza os Links
        foreach ($pages as $page) {
            //Altera a Página
            $queryParams['page'] = $page['page'];

            //Link
            $link = $url . '?' . http_build_query($queryParams);

            //View
            $links .= View::render("pages/pagination/link", [
                'page' => $page['page'],
                'link' => $link,
                'active' => $page['current'] ? 'active' : ''
            ]);
        }

        //Renderiza Box de Paginação
        return View::render("pages/pagination/box", [
            'links' => $links
        ]);

    }

    /**
     * Método responsável por retornar o conteúdo da nossa página genérica
     * @param string $title
     * @param string $content
     * @return string
     */
    public static function getPage(string $title, string $content): string
    {
        return View::render("pages/page", [
            'title'   => $title,
            'header'  => self::getHeader(),
            'content' => $content,
            'footer'  => self::getFooter(),
        ]);
    }
}