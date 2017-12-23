<?php

namespace AppBundle\Entity;


class ChiffreMystereResponse
{
    private $proximite;
    private $supposition;
    private $nb_tentatives;

    /**
     * ChiffreMystereResponse constructor.
     * @param $proximite
     * @param $supposition
     * @param $nb_tentatives
     */
    public function __construct($proximite, $supposition, $nb_tentatives)
    {
        $this->proximite = $proximite;
        $this->supposition = $supposition;
        $this->nb_tentatives = $nb_tentatives;
    }


    /**
     * @return mixed
     */
    public function getProximite()
    {
        return $this->proximite;
    }

    /**
     * @param mixed $proximite
     */
    public function setProximite($proximite)
    {
        $this->proximite = $proximite;
    }

    /**
     * @return mixed
     */
    public function getSupposition()
    {
        return $this->supposition;
    }

    /**
     * @param mixed $supposition
     */
    public function setSupposition($supposition)
    {
        $this->supposition = $supposition;
    }

    /**
     * @return mixed
     */
    public function getNbTentatives()
    {
        return $this->nb_tentatives;
    }

    /**
     * @param mixed $nb_tentatives
     */
    public function setNbTentatives($nb_tentatives)
    {
        $this->nb_tentatives = $nb_tentatives;
    }


}