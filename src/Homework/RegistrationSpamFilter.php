<?php

namespace App\Homework;


class RegistrationSpamFilter
{


    public function filter(string $email): bool
    {
        $domens = ['.ru', '.com', '.org'];
        $isBot = true;
        foreach ($domens as $domen) {
            if (substr($email, -4) == '.com' || substr($email, -4) == '.org' ||
                substr($email, -3) == '.ru') {
                return $isBot = false;
            }
        }
        return $isBot;
    }

}
