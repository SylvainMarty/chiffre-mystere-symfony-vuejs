<?php

namespace AppBundle\Controller;

use AppBundle\Service\ChiffreMystereService;
use AppBundle\Service\SerializationService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ChiffreMystereController extends Controller
{

    private $serializer;
    private $chiffreMystereService;

    public function __construct(SerializationService $serializer, ChiffreMystereService $chiffreMystereService)
    {
        $this->serializer = $serializer;
        $this->chiffreMystereService = $chiffreMystereService;
    }

    /**
     * @Route("/essai", name="try")
     * @Method({"POST"})
     *
     * @return JsonResponse
     */
    public function trouverChiffreMystere(Request $request, SessionInterface $session)
    {
        // On récupère le contenu du body
        $body = json_decode($request->getContent(), true);
        $supposition = $body['supposition'];
        // On vérifie le format de la supposition
        if(!is_int($supposition)) {
            throw new HttpException(417, 'La supposition n\'est pas un entier.');
        }
        if($supposition < 0) {
            throw new HttpException(417, 'La supposition ne peut pas être inférieure à 0. Le chiffre mystère est compris entre 0 et 100.');
        }
        if($supposition > 100) {
            throw new HttpException(417, 'La supposition ne peut pas être supérieure à 100. Le chiffre mystère est compris entre 0 et 100.');
        }

        // Analyse et récupération du chiffre mystère
        $chiffreMystereResponse = $this->chiffreMystereService->analyze($supposition);

        return $this->serializer->toJson($chiffreMystereResponse);
    }
}
