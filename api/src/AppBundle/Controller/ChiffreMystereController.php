<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ChiffreMystereController extends Controller
{
    /**
     * @Route("/essai", name="try")
     * @Method({"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function trouverChiffreMystere(Request $request)
    {
        // TODO: Wrapper tout ça dans un service si possible
        $session = $request->getSession();
        if(!$session->has("chiffre_mystere")) {
            $chiffreMystere = rand(0,100);
            $session->set("chiffre_mystere", $chiffreMystere);
        } else {
            $chiffreMystere = $session->get("chiffre_mystere");
        }

        if($request->get("chiffre_mystere") == $chiffreMystere) {
            // TODO: chiffre mystère trouvé !
        } else {
            // TODO: chiffre mystère toujours inconnu, indiquer si c'est + ou -
        }

        // TODO: Gérer la response avec un serializer (on est pas là pour déconner)
        return new JsonResponse($chiffreMystere);
    }
}
