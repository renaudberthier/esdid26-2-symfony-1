<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Form\CreerFormationType;
use App\Entity\Formation;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use DateTimeImmutable;

final class FormationController extends AbstractController
{
    #[Route('/formation', name: 'app_formation')]
    public function index(FormationRepository $fr): Response
    {
        return $this->render('formation/index.html.twig', [
            'formations' => $fr->findAll(),
        ]);
    }

    #[Route('/formation/nouvelle', name: 'app_formation_nouvelle', methods:['GET'])]
    public function new(): Response
    {
        return $this->render('formation/nouvelle.html.twig');
    }

    #[Route(
        '/formation/nouvelle-avec-formulaire', 
        name: 'app_formation_nouvelle_avec_formulaire', 
        methods:['GET', 'POST']
    )]
    public function new2(Request $request, EntityManagerInterface $em): Response
    {
        // Dans tous les cas, je crée un objet formation
        $formation = new Formation();

        // Je crée l'objet Formulaire sur la base de mon FormType
        $form = $this->createForm(CreerFormationType::class, $formation);
        // Si jamais on est en POST, j'en profite pour traiter le formulaire.
        // - Au premier chargement (GET), rien ne se passe
        // - A l'envoi du formulaire (POST), les données seront traitées
        $form->handleRequest($request);

        // Note: on n'appelle pas isValid si le formulaire n'a pas été soumis
        if($form->isSubmitted() && $form->isValid()) {
            // Ici :
            // - Les données ont été envoyées
            // - Les données sont valides
            // Donc on réécrit la variable $formation avec les données du formulaire.
            $formation = $form->getData();

            $em->persist($formation);
            $em->flush();
            return $this->redirectToRoute('app_formation');
        }
        return $this->render('formation/nouvelle-avec-formulaire.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/formation/nouvelle', name: 'app_formation_creation', methods:['POST'])]
    public function create(EntityManagerInterface $em, Request $request): Response
    {
        $titre = trim($request->request->get('titre'));
        $description = trim($request->request->get('description'));
        $date = trim($request->request->get('date'));
        $duree = trim($request->request->get('duree'));

        $formation = new Formation();
        $formation->setTitre($titre);
        $formation->setDescription($description);
        $formation->setDate(DateTimeImmutable::createFromFormat('Y-m-d', $date));
        $formation->setDuree(floatval($duree));

        // Notons qu'on n'utilise pas de validation ici, on devrait avec ValidatorInterface.
        // On verra dans la suite de la formation comment utiliser les FormType.

        // Par défaut, persist ne sauvegarde pas réellement maintenant.
        // Cet appel stocke dans une sorte de "rampe de lancement", pour qu'on puisse
        // l'utiliser dans un foreach sans couler la base.
        // Si on veut sauvegarder directement, il faut appeler flush.
        $em->persist($formation);
        $em->flush();

        // Redirige l'usager vers la page 'app_formation', qui est l'index listant les
        // formations.
        return $this->redirectToRoute('app_formation');
    }
}
