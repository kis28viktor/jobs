<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 17.07.15
 * Time: 1:57
 */

namespace WorkBundle\Entity;


class ExchangeRate {
    public $url     = "";
    public $bank    = "";
    public $html    = "";
    public $usd     = "";
    public $eur     = "";
    public $datenow = "";

    function __construct($bank, $host)
    {
        $this->url  = $host;
        $this->bank = $bank;

        // интерпретируем
        try {
            // Создаем поток
            $opts = array(
                'http'=>array(
                    'method'=>"GET",
                    'header'=>"Accept-language: en\r\n" .
                        "Cookie: foo=bar\r\n"
                )
            );
            $context = stream_context_create($opts);

            // Открываем файл с помощью установленных выше HTTP-заголовков
            $content = file_get_contents($this->url, false, $context);
            if($content)
            {
                $this->html = iconv('utf-8','windows-1251',$content);
                $this->parseCurs();
            }else{
                // Дефолтовое значение
                $this->datenow = date("d.m.Y");
                // Здесь при желании можно проинициализировать
                // и остальные дефолтные значения
            }

        }catch(Exception $e){}

    }

    private function parseCurs()
    {
        preg_match_all("|<[^>]+>(.*)</[^>]+>|U",$this->html,$out, PREG_PATTERN_ORDER);
        //var_dump($out);
        // Нацбанк Украины
        if($this->bank == "NBU")
        {
            for($i=0;$i<count($out[1]);$i++)
            {
                if($this->usd != "" and $this->eur != "" and $this->datenow != ""){ break; }
                if($out[1][$i] == "840"){ $this->usd = number_format(intval($out[1][$i+4])/100, 2, '.', '');continue; }
                if($out[1][$i] == "978"){ $this->eur = number_format(intval($out[1][$i+4])/100, 2, '.', '');continue; }
                if($out[1][$i] == "036"){ $this->datenow = $out[1][$i-6];continue; }
            }
        }
    }
}