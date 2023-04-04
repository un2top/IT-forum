<?php

namespace App\Homework;

use Faker\Factory;
use App\Homework\PasteWords;

class CommentContentProvider implements CommentContentProviderInterface
{
    /**
     * @var PasteWords
     */
    private $past;

    public function __construct(PasteWords $past)
    {
        $this->past = $past;
    }

    public function get(string $word = null, int $wordsCount = 0): string
    {
        $faker = Factory::create();
        $text = $faker->paragraph;

        if ($word && $wordsCount > 0) {
            $text = $this->past->paste($text, $word, $wordsCount);
        }
        return $text;
    }

}
