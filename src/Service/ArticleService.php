<?php

namespace App\Service;

class ArticleService {
    public function recupererArticles(): array
    {
        return [
            [
                'titre' => 'Un article',
                'contenu' => '<p>Ceci est un article</p>',
                'auteur' => 'LiveCampus',
                'date' => (new \DateTime())
            ],
            [
                'titre' => 'Un autre article',
                'contenu' => '<p>Ceci est un <strong>deuxième</strong>article</p>',
                'auteur' => 'LiveCampus2',
                'date' => (new \DateTime())
            ],
        ];
    }
}