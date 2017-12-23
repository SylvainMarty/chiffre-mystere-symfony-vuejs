<?php

namespace AppBundle\Service;

use AppBundle\Entity\ChiffreMystereResponse;
use AppBundle\Entity\ProximiteEnum;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ChiffreMystereService
{
    const CHIFFRE_MYSTERE_CLE = 'chiffre_mystere';
    const NB_TENTATIVES_CLE = 'nb_tentatives';

    private $session;
    private $chiffreMystere;
    private $nbTentatives;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
        $this->chiffreMystere = $this->fetchChiffreMystere();
        $this->nbTentatives = $this->fetchNbTentatives();
    }

    /**
     * Vérifie si la supposition est supérieure, inférieure ou égale au chiffre mystère
     * @param int $supposition
     *
     * @return ChiffreMystereResponse
     */
    public function analyze(int $supposition): ChiffreMystereResponse
    {
        // Vérification de la proximité de la supposition avec le chiffre mystère
        if($supposition == $this->chiffreMystere) {
            // Chiffre mystère trouvé !
            $proximite = ProximiteEnum::EGAL;
            // On vide les variables de session pour pouvoir recommencer le jeu
            $this->clearChiffreMystere();
            $this->clearNbTentatives();
        } else if($supposition < $this->chiffreMystere) {
            // Chiffre mystère toujours inconnu et proposition inférieure à celui-ci
            $proximite = ProximiteEnum::PLUS;
        } else {
            // Chiffre mystère toujours inconnu et proposition supérieure à celui-ci
            $proximite = ProximiteEnum::MOINS;
        }

        return new ChiffreMystereResponse($proximite, $supposition, $this->nbTentatives);
    }

    /**
     * Génère ou récupère le chiffre mystère dans la session courante
     * @return int  Le chiffre mystère
     */
    private function fetchChiffreMystere(): int
    {
        if(!$this->hasChiffreMystere()) {
            $chiffreMystere = rand(0,100);
            $this->setChiffreMystere($chiffreMystere);
        } else {
            $chiffreMystere = $this->getChiffreMystere();
        }
        return $chiffreMystere;
    }

    /**
     * Initialise ou récupère le nombre de tentatives stocké dans la session courante
     * @return int  Le nombre de tentatives
     */
    private function fetchNbTentatives(): int
    {
        if(!$this->hasNbTentatives()) {
            $nbTentatives = 1;
            $this->setNbTentatives($nbTentatives);
        } else {
            $nbTentatives = $this->getNbTentatives() + 1;
            $this->setNbTentatives($nbTentatives);
        }
        return $nbTentatives;
    }

    /**
     * Tente de récupérer le chiffre mystère dans la session courante
     * @return int
     */
    private function getChiffreMystere(): int
    {
        return $this->session->get(ChiffreMystereService::CHIFFRE_MYSTERE_CLE);
    }

    /**
     * Tente de récupérer le nombre de tentatives stocké dans la session courante
     * @return int
     */
    private function getNbTentatives(): int
    {
        return $this->session->get(ChiffreMystereService::NB_TENTATIVES_CLE);
    }

    /**
     * Stocke la valeur du chiffre mystère dans la session courante
     * @param $chiffreMystere
     */
    private function setChiffreMystere($chiffreMystere)
    {
        $this->session->set(ChiffreMystereService::CHIFFRE_MYSTERE_CLE, $chiffreMystere);
    }

    /**
     * Stocke le nombre de tentatives dans la session courante
     * @param $nbTentatives
     */
    private function setNbTentatives($nbTentatives)
    {
        $this->session->set(ChiffreMystereService::NB_TENTATIVES_CLE, $nbTentatives);
    }

    /**
     * Vérifie si la session courante contient la valeur du chiffre mystère
     * @return bool
     */
    private function hasChiffreMystere(): bool
    {
        return $this->session->has(ChiffreMystereService::CHIFFRE_MYSTERE_CLE);
    }

    /**
     * Vérifie si la session courante contient la valeur du nombre de tentatives
     * @return bool
     */
    private function hasNbTentatives(): bool
    {
        return $this->session->has(ChiffreMystereService::NB_TENTATIVES_CLE);
    }

    /**
     * Supprime la variable contenant le chiffre mystère dans la session courante
     */
    private function clearChiffreMystere()
    {
        $this->session->remove(ChiffreMystereService::CHIFFRE_MYSTERE_CLE);
    }

    /**
     * Supprime la variable contenant le nombre de tentatives dans la session courante
     */
    private function clearNbTentatives()
    {
        $this->session->remove(ChiffreMystereService::NB_TENTATIVES_CLE);
    }

}