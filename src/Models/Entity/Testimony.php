<?php


namespace Src\Models\Entity;

use Exception;
use PDOStatement;
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
        $this->id = (new Database('depoimentos'))->insert([
            'nome'     => $this->nome,
            'mensagem' => $this->mensagem,
            'data'     => $this->data
        ]);

        //Sucesso
        return true;
    }

    /**
     * Método responsavel por atualizar os dados do banco com a instancia atual
     * @return boolean
     */
    public function atualizar()
    {
        //Atualiza o depoimento no banco de dados

        return (new Database('depoimentos'))->update('id = ' . $this->id, [
            'nome'     => $this->nome,
            'mensagem' => $this->mensagem,
        ]);
    }

    /**
     * Método responsavel por um depoimento do banco de dados
     * @return boolean
     */
    public function excluir()
    {
        //Excluir o depoimento no banco de dados

        return (new Database('depoimentos'))->delete('id = ' . $this->id);
    }

    /**
     * Método responsavel por retornar um depoimento com base no seu ID
     * @param int $id
     * @return Testimony
     * @throws Exception
     */
    public static function getTestimonyById(int $id)
    {
        return self::getTestimonies('id =' . $id)->fetchObject(self::class);
    }

    /**
     * Método responsável por retornar Depoimentos
     * @param string|null $where
     * @param string|null $order
     * @param string|null $limit
     * @param PDOStatement $fields
     */
    public static function getTestimonies(string $where = null, string $order = null, string $limit = null, $fields = '*')
    {
        return (new Database('depoimentos'))->select($where, $order, $limit, $fields);
    }
}