<?php


namespace Src\Controllers\Admin;


use Src\Utils\View;

class Alert
{
    /**
     * Método responsável por retornar uma mensagem de sucesso
     * @param string $message
     * @return string
     */
    public static function getSuccess(string $message): string
    {
        return View::render('admin/alert/status', [
            'tipo' => 'success',
            'mensagem' => $message
        ]);
    }
    /**
     * Método responsável por retornar uma mensagem de erro
     * @param string $message
     * @return string
     */
    public static function getError(string $message): string
    {
        return View::render('admin/alert/status', [
            'tipo' => 'danger',
            'mensagem' => $message
        ]);
    }
}