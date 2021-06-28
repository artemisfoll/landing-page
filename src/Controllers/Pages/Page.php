<?php


namespace Src\Controllers\Pages;


use Src\Utils\View;

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
	 * Método responsável por retornar o conteúdo da nossa página genérica
	 * @param string $title
	 * @param string $content
	 * @return string
	 */
	public static function getPage($title, $content)
	{
		return View::render("pages/page", [
			'title'   => $title,
			'header'  => self::getHeader(),
			'content' => $content,
			'footer'  => self::getFooter(),
		]);
	}
}