<?php

namespace App\Homework;


class ArticleWordsFilter
{
// Очеловеченный жук и Человек-медведь съели другого человека
    public $words = ['стакан', 'молоко', 'колб', 'мясо', 'утка', 'жук', 'челов',];

    public function filter($string, $words = [])
    {
        $newMass = [];
        $mass = explode(' ', $string);
        for ($i = 0; $i < count($mass); $i++) {
            for ($j = 0; $j < count($words); $j++) {
                if (mb_strpos(mb_strtolower($mass[$i]), mb_strtolower($words[$j])) !== false) {
                    $newMass[]=$mass[$i];
                }
            }
        }
        return implode(' ', array_diff($mass, $newMass));
    }

}
