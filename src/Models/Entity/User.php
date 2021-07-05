<?php


namespace Src\Models\Entity;

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
        return (new Database('usuarios'))->select('email = "'.$email.'"')->fetchObject(self::class);
    }
}