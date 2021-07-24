<?php


namespace Src\Models\Entity;


class QrCodeModel
{
    /**
     * chl=hello
     * @var string
     */
    public $content;

    /**
     * chld=H
     * @var string
     */
    public $size;

    /**
     * cht=qr
     * @var string
     */
    public $type;

    /**
     * chs=200x200
     * @var int
     */
    public $height;

    /**
     * choe=UTF-8
     * @var string
     */
    public $encode;

    /**
     * @var string
     */
    public $url;

    /**
     * @var bool
     */
    public $clean;

    public function getUrl(): string
    {

        $content = $this->content;
        $height  = $this->height;
        $size    = $this->size;
        $type    = "qr";
        $encode  = "UTF-8";
        $clean = $this->clean;

        if (!isset($content) || $clean == "true"){
            return "Aguardando";
        } elseif (empty($content)){
            return "Adicione Texto";
        }

        $url = $this->url = "https://chart.googleapis.com/chart?chs=".$height."x".$height."&cht=".$type."&chl=".$content."&choe=".$encode."&chld=".$size;
        $frame = "<iframe src='$url' frameborder='0' width='100%' height='400px'></iframe>";
        return $frame;
    }



}