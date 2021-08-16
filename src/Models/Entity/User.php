<?php


namespace Src\Models\Entity;

use PDOStatement;
use WilliamCosta\DatabaseManager\Database;

class User
{
    /**
     * Id do usuário
     * @var int
     */
    public $id;

    /**
     * Nome do usuário
     * @var string
     */
    public $nome;

    /**
     * E-mail do usuário
     * @var string
     */
    public $email;

    /**
     * Senha do usuário
     * @var string
     */
    public $senha;

    /**
     * Método responsavel por retornar um usuaio com base em seu e-mail
     * @param string $email
     * @return User|bool
     */
    public static function getUserByEmail(string $email)
    {
        return (new Database('usuarios'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }

    /**
     * Método responsavel por retornar um usuario com base no seu ID
     * @param int $id
     * @return User
     */
    public static function getUserById(int $id): User
    {
        return self::getUsers('id =' . $id)->fetchObject(self::class);
    }

    /**
     * Método responsável por retornar Usuários
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param PDOStatement $fields
     */
    public static function getUsers($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('usuarios'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método responsavel por cadastrar a instancia atual no banco de dados
     * @return bool
     */
    public function cadastrar(): bool
    {
        //Insere a instancia no banco
        $this->id = (new Database('usuarios'))->insert([
            'nome'  => $this->nome,
            'email' => $this->email,
            'senha' => $this->senha
        ]);

        //Sucesso
        return true;
    }

    /**
     * Método responsavel por atualizar os dados do banco com a instancia atual
     * @return boolean
     */
    public function atualizar(): bool
    {
        //Atualiza o usuário no banco de dados
        return (new Database('usuarios'))->update('id = ' . $this->id, [
            'nome'  => $this->nome,
            'email' => $this->email,
            'senha' => $this->senha
        ]);
    }

    /**
     * Método responsavel por um usuario do banco de dados
     * @return boolean
     */
    public function excluir(): bool
    {
        //Excluir o usuário no banco de dados
        return (new Database('usuarios'))->delete('id = ' . $this->id);
    }


}