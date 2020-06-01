<?php


namespace App\Service;


class Slugify
{
    public function generate(string $input): string
    {

        //trim
        $res = trim($input);
        // traitement de suppression de pontuations
        $res = preg_replace("/\p{P}/um", "", $res);

        // traitement de remplacement de lettres et monaie
        $pattern[] = ["a","à","á","â","ä","æ","ã","å","ā"];
        $pattern[] = explode(" ", "c ç ć č");
        $pattern[] = explode(" ", "e é è ê ë ę ė ē");
        $pattern[] = explode(" ", "i ī į í ì ï î");
        $pattern[] = explode(" ", "n ñ ń");
        $pattern[] = explode(" ", "o ō ø œ õ ó ò ö ô");
        $pattern[] = explode(" ", "s ß ś š");
        $pattern[] = explode(" ","u ū ú ù ü û");
        $pattern[] = explode(" ", "w ŵ");
        $pattern[] = explode( " ", "y ŷ ÿ");
        $pattern[] = explode(" ", "z ź ž ż");
        $pattern[] = explode(" ","l ł");
        $pattern[] = explode(" ", " $ € £");
        foreach ($pattern as $charPattern) {
            foreach ($charPattern as $aChar){
                $res = str_replace($aChar, $charPattern[0], $res);
            }

        }

        $res = str_replace(" ", "-", $res);
        $res = mb_strtolower($res);
        return $res;
    }

}
