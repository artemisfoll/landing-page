<?php


namespace Src\Controllers\Pages;

use Src\Http\Request;
use Src\Models\Entity\QrCodeModel;
use Src\Utils\View;

class Qrcode extends Page
{
    /**
     * Método responsável por retornar o Form de QrCode
     */
    public static function getQrCode(Request $request): string
    {
        $qrInfo = $request->getQueryParams();

        $obQrcode          = new QrCodeModel();
        $obQrcode->content = $qrInfo['texto'];
        $obQrcode->height  = $qrInfo['tamanho'];
        $obQrcode->size    = $qrInfo['qualidade'];

        $content = View::render('pages/qrcode', [
            'urlqr' => $obQrcode->getUrl()
        ]);

        return self::getPage("QrCode", $content);
    }


}