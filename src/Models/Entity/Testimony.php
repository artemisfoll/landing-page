<?php


namespace Src\Models\Entity;

use WilliamCosta\DatabaseManager\Database;


class Testimony
{
    /**
     * ID do depoimento
     * @var int
     */
    public $id;

    /**
     * Nome do usuario que fez o deppoimento
     * @var string
     */
    public $nome;

    /**
     * Mensagem do depoimento
     * @var string
     */
    public $mensagem;

    /**
     * Data de publicação do depoimento
     * @var string
     */
    public $data;

    /**
     * Método responsavel por cadastrar a instancia atual no banco de dados
     * @return boolean
     */
    public function cadastrar()
    {
        //Definir a data
        $this->data = date('Y-m-d H:i:s');

        //Insere o depoimento no banco de dados
        $this->id   = (new Database('depoimentos'))->insert([
            'nome'     => $this->nome,
            'mensagem' => $this->mensagem,
            'data'     => $this->data
        ]);

        //Sucesso
        return true;
    }

    /**
     * Método responsável por retornar Depoimentos
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param PDOStatement $fields
     */
    public static function getTestimonies($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('depoimentos'))->select($where, $order, $limit, $fields);
    }
}