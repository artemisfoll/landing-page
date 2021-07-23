<?php


namespace Src\Controllers\Admin;


use Src\Http\Request;
use Src\Utils\View;
use WilliamCosta\DatabaseManager\Pagination;

class Page
{
    /**
     * Modulos disponiveis no painel
     * @var array
     */
    private static $modules = [
        'home'        => [
            'label' => 'Home',
            'link'  => URL . '/admin'
        ],
        'testimonies' => [
            'label' => 'Depoimentos',
            'link'  => URL . '/admin/testimonies'
        ],
        'users'       => [
            'label' => 'Usuários',
            'link'  => URL . '/admin/user'
        ],
    ];

    /**
     * Método responsavel por retornar o conteúdo (view) da estrutura generica de página do painel
     * @param string $title
     * @param string $content
     * @return string
     */
    public static function getPage(string $title, string $content): string
    {
        return View::render('admin/page', [
            'title'   => $title,
            'content' => $content
        ]);
    }

    /**
     * Método responsável por renderizar a view do menu do painel
     * @param string $currentModule
     * @return string
     */
    private static function getMenuVertical(string $currentModule): string
    {
        //Links do menu
        $links = '';

        //Itera os modulos
        foreach (self::$modules as $hash => $module) {
            $links .= View::render('admin/menu/link', [
                'label'   => $module['label'],
                'link'    => $module['link'],
                'current' => $hash == $currentModule ? 'active' : ''
            ]);
        }

        //Retorna a renderização do menu vertical
        return View::render('admin/menu/vertical', [
            'links' => $links
        ]);
    }

    private static function getMenu()
    {
        //Retorna a renderização do menu vertical
        return View::render('admin/menu/box');
    }

    /**
     * Método responsável por renderizar a view do painel com conteudo dinamico
     * @param string $title
     * @param string $content
     * @param string $currentModule
     * @return string
     */
    public static function getPanel(string $title, string $content, string $currentModule): string
    {
        //Renderiza a view do painel
        $contentPanel = View::render('admin/panel', [
            'vertical' => self::getMenuVertical($currentModule),
            'menu'     => self::getMenu(),
            'content'  => $content
        ]);

        //Retorna a página renderizada
        return self::getPage($title, $contentPanel);
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
                $links .= View::render("admin/pagination/link", [
                    'page' => $page['page'],
                    'link' => $link,
                    'active' => $page['current'] ? 'active' : ''
                ]);
            }
    
            //Renderiza Box de Paginação
            return View::render("admin/pagination/box", [
                'links' => $links
            ]);
    
        }
}