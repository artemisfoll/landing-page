<?php


namespace Src\Controllers\Pages;

use \Src\Utils\View;
use \Src\Models\Entity\Organization;

class Home extends Page
{


	/**
	 * @return string
	 */
	public static function getHome()
	{
		$obOrganization = new Organization();

		$content = View::render("pages/home", [ //View da home
			'name' => $obOrganization->name,
		]);

		return self::getPage('Home', $content); //Retorna a view da página
	}
}