<?php


namespace Src\Controllers\Pages;

use \Src\Utils\View;
use \Src\Models\Entity\Organization;

class Sobre extends Page
{
    /**
     * Método responsável por retornar o conteudo de Sobre
     * @return string
     */
    public static function getSobre()
    {
        $obOrganization = new Organization();

        $content = View::render("pages/sobre", [ //View do Sobre
            'name'        => $obOrganization->name,
            'description' => $obOrganization->description,
            'site'        => $obOrganization->site,
        ]);

        return self::getPage('Sobre', $content); //Retorna a view da página
    }
}