<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SerializationService
{
    private $encoders;
    private $normalizers;
    private $serializer;

    /**
     * JsonResponseService constructor.
     */
    public function __construct()
    {
        $this->encoders = array(new XmlEncoder(), new JsonEncoder());
        $this->normalizers = array(new ObjectNormalizer());
        $this->serializer = new Serializer($this->normalizers, $this->encoders);
    }

    /**
     * Serialisation d'une entité en JSON
     * @param $entity
     * @return \Symfony\Component\Serializer\Encoder\scalar
     */
    public function serializeToJson($entity)
    {
        return $this->serializer->serialize($entity, 'json');
    }

    /**
     * Wrappe la sérialisation de l'entité dans une réponse HTTP
     * permet de sérialiser une entité dont les propriétés sont privées (comparé à JsonResponse par exemple)
     * @param $entity
     * @return Response
     */
    public function toJson($entity)
    {
        $response = new Response($this->serializeToJson($entity));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}