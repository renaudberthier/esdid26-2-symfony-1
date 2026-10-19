<?php

namespace App\Service;

// Cette classe est un service, elle a pour but de stocker le code "métier", un peu plus
// complexe et réutilisable que du code que l'on pourrait trouver dans un Contrôleur.
// Un Service, c'est une liste de méthodes qui, si elles se trouvaient dans le contrôleur,
// rendrait la lecture du contrôleur compliquée.
class BonjourService {
    // Notez que la méthode n'est pas en "static" : on va créer un objet BonjourService
    // pour interagir avec.
    public function direBonjour(string $prenom): string
    {
        return 'Bonjour ' . $prenom;
    }
}