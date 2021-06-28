<?php

namespace Src\Http;

class Request
{
	/**
	 * Método HTTP da requisição
	 * @var string
	 */
	private $httpMethod;

	/**
	 * URI da página
	 * @var string
	 */
	private $uri;

	/**
	 * Parâmetros da URL ($_GET)
	 * @var array
	 */
	private $queryParams = [];

	/**
	 * Variáveis recebidos no POST da página ($_POST)
	 * @var array
	 */
	private $postVars = [];

	/**
	 * Cabeçalho da requisição
	 * @var array
	 */
	private $headers = [];

	public function __construct()
	{
		$this->queryParams = $_GET ?? [];
		$this->postVars    = $_POST ?? [];
		$this->headers  = getallheaders();
		$this->httpMethod  = $_SERVER['REQUEST_METHOD'];
		$this->uri         = $_SERVER['REQUEST_URI'];
	}

    /**
     * Método responsavel por retornar o método http da requisição
     * @return string
     */
	public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * Método responsavel por retornar a URI da requisição
     * @return string
     */
	public function getUri()
    {
        return $this->uri;
    }

    /**
     * Método responsavel por retornar os Headers da requisição
     * @return array
     */
	public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Método responsavel por retornar os parametros da URL da requisição
     * @return array
     */
	public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     * Método responsavel por retornar as variaveis POST da requisição
     * @return array
     */
	public function getPostVars()
    {
        return $this->postVars;
    }
}
