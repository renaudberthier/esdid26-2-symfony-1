<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HelloWorldController extends AbstractController
{
    // Ici, l'URL à laquelle la ressource (page ou autre) est disponible
    #[Route('/toto', name: 'app_hello_world')]
    // Ici, on met le nom de méthode qu'on veut, il n'est vraiment pas important
    // Par contre, une méthode de contrôleur doit renvoyer une réponse
    public function index(): Response
    {
        // Là, on dit quel fichier on va charger pour le rendu visuel au client.
        // Ici, ça va charger le fichier templates/hello_world/index.html.twig
        return $this->render('hello_world/index.html.twig');
    }

    #[Route('/json')]
    public function a(): Response
    {
        return $this->json([
            'formation' => 'LiveCampus',
            'module' => 'Symfony'
        ]);
    } 
}
