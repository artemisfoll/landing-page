<?php


namespace Src\Http;


class Response
{
    /**
     * Código do Status Http
     * @var int
     */
    private $httpCode = 200;

    /**
     * Cabeçalho do Response
     * @var array
     */
    private $headers = [];

    /**
     * Tipo de conteúdo que está sendo retornado
     * @var string
     */
    private $contentType = 'text/html';

    /**
     * Conteúdo do Response
     * @var mixed
     */
    private $content;

    /**
     * Método responsavel por iniciar a classe e definir os valores
     * Response constructor.
     * @param int $httpCode
     * @param mixed $content
     * @param string $contentType
     */
    public function __construct($httpCode, $content, $contentType = 'text/html')
    {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType) ;
    }

    /**
     * Método responsavel por alterar o content type do response
     * @param  string
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /**
     * Método responsavel por adicionar um registro no cabeçalho de response
     * @param string $key
     * @param string $value
     */
    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * Método responsavel por enviar os headers para o navegador
     */
    private function sendHeaders()
    {
        //Status
        http_response_code($this->httpCode);

        //Envia Headers
        foreach ($this->headers as $key=>$value){
            header($key.': '.$value);
        }
    }

    /**
     * Método responsavel por enviar a resposta para o usuário
     */
    public function sendResponse()
    {
        $this->sendHeaders(); //Envia os Headers

        switch ($this->contentType){ //Imprime o conteúdo
            case 'text/html':
                echo $this->content;
                exit;
        }
    }
}