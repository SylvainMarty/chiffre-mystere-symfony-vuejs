<?php

namespace AppBundle\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ChiffreMystereController extends Controller
{

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("/essai", name="try")
     * @Method({"POST"})
     *
     * @return JsonResponse
     */
    public function trouverChiffreMystere(Request $request, SessionInterface $session)
    {
        // On récupère et on vérifie le contenu du body
        $body = json_decode($request->getContent(), true);
        $this->logger->debug('body', $body);
        $supposition = $body['supposition'];
        // TODO: créer un objet ExpectationFailedException héritant de HttpException
        if(!is_int($supposition)) {
            throw new HttpException(417, 'La supposition n\'est pas un entier.');
        }
        if($supposition < 0) {
            throw new HttpException(417, 'La supposition ne peut pas être inférieure à 0. Le chiffre mystère est compris entre 0 et 100.');
        }
        if($supposition > 100) {
            throw new HttpException(417, 'La supposition ne peut pas être supérieure à 100. Le chiffre mystère est compris entre 0 et 100.');
        }

        // TODO: Wrapper tout ça dans un service si possible
        // On fetch les variables de session
        if(!$session->has('chiffre_mystere')) {
            $chiffreMystere = rand(0,100);
            $session->set('chiffre_mystere', $chiffreMystere);
        } else {
            $chiffreMystere = $session->get('chiffre_mystere');
        }
        if(!$session->has('nb_tentatives')) {
            $nb_tentatives = 1;
            $session->set('nb_tentatives', $nb_tentatives);
        } else {
            $nb_tentatives = $session->get('nb_tentatives') + 1;
            $session->set('nb_tentatives', $nb_tentatives);
        }

        // Vérification de la proximité de la supposition avec le chiffre mystère
        if($supposition == $chiffreMystere) {
            // Chiffre mystère trouvé !
            $proximite = '=';
            // On vide les variables de session pour pouvoir recommencer le jeu
            $session->remove('chiffre_mystere');
            $session->remove('nb_tentatives');
        } else if($supposition < $chiffreMystere) {
            // Chiffre mystère toujours inconnu et proposition inférieure à celui-ci
            $proximite = '+';
        } else {
            // Chiffre mystère toujours inconnu et proposition supérieure à celui-ci
            $proximite = '-';
        }

        // Préparation de la réponse au client
        $response = [
            'proximite' => $proximite,
            'supposition' => $supposition,
            'nb_tentatives' => $nb_tentatives
        ];

        // TODO: Gérer la response avec un serializer (on est pas là pour déconner)
        return new JsonResponse($response);
    }
}
