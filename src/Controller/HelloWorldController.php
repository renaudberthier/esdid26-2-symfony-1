<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


use App\Repository\UserRepository;
use App\Service\ArticleService;
use App\Service\BonjourService;

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

    #[Route('/coucou')]
    public function b(Request $request): Response
    {
        // Récupérer un paramètre en GET
        var_dump($request->query->get('prenom'));
        exit();
    } 
    
    #[Route('/coucou/{prenom}')]
    public function c(string $prenom): Response
    {
        // Récupérer un paramètre dans l'URL
        var_dump($prenom);
        exit();
    } 

    #[Route('/formulaire', methods: ['POST'])]
    public function d(Request $request): Response
    {
        // Récupérer un paramètre dans l'URL
        var_dump($request->request->get('prenom'));
        exit();
    } 

    #[Route('/formulaire', methods: ['GET'])]
    public function e(): Response
    {
        return $this->render('hello_world/formulaire.html.twig');
    } 

    #[Route('/demo-services', methods: ['GET'])]
    public function f(BonjourService $bs, ArticleService $as): Response
    {
        return $this->render('hello_world/demo-twig.html.twig', [
            'bonjour' => $bs->direBonjour('toto'),
            'articles' => $as->recupererArticles()
        ]);
    } 

    #[Route('/utilisateurs', methods: ['GET'])]
    public function g(UserRepository $ur): Response
    {
        foreach($ur->findAll() as $user) {
            var_dump($user->getPrenom() . ' ' . $user->getNom());
        }
        exit();
    } 
}
