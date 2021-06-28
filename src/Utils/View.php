<?php

namespace Src\Utils;

class View
{
    /**
     * Variaveis padrões da View
     * @var array
     */
    private static $vars = [];

    /**
     * Método responsável por definir os dados iniciais da classe
     * @param array $vars
     */
    public static function init($vars = [])
    {
        self::$vars = $vars;
    }

	/**
	 * Método responsável por retornar o conteúdo de uma view
	 * @param string $view
	 * @return string
	 */
	private static function getContentView($view)
	{
		$file = __DIR__ . "/../views/" . $view . ".html";
		return file_exists($file) ? file_get_contents($file) : '';
	}

	/**
	 * Método responsável por retornar o conteúdo renderizado de uma view
	 * @param string $view
	 * @param array $vars (string/numeric)
	 * @return string
	 */
	public static function render($view, $vars = [])
	{
		$contentView = self::getContentView($view); //conteúdo da view

        $vars = array_merge(self::$vars, $vars);//Merge de variaveis da view

		$keys = array_keys($vars); //chaves da array de variaveis
		$keys = array_map(function ($itens) {
			return '{{' . $itens . '}}';
		}, $keys);

		return str_replace($keys, array_values($vars), $contentView); //retorno o conteúdo renderizado
	}
}