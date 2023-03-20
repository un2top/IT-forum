<?php

namespace App\Homework;

class ArticleProvider
{
    public function article(){
        $articles = $this->articles();
        return $articles[array_rand($articles,1)];


    }

    public function articles(){
        return [
            [
                'title' => 'Что делать, если надо верстать?',
                'image' => 'images/article-2.jpeg',
                'slug'  => 'what-to-do-if-need-fronted',
            ],
            [
                'title' => 'Facebook ест твои данные',
                'image' => 'images/article-1.jpeg',
                'slug'  => 'facebook-eat-your-data',
            ],
            [
                'title' => 'Когда пролил кофе на клавиатуру',
                'image' => 'images/article-3.jpg',
                'slug'  => 'when-i-spilled-coffee-on-the-keyboard',
            ],
            [
                'title' => 'Что делать, если хочется спать?',
                'image' => 'images/article-4.jpg',
                'slug'  => 'what-to-do-if-want-sleep',
            ],
            [
                'title' => 'Когда перепутал соусы',
                'image' => 'images/article-5.jpg',
                'slug'  => 'when-mixed-sauces',
            ],


        ];
    }

}