<?php
namespace App\Controller\Planet;

use App\Entity\Planet;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class Get
{
    /**
     * @var RegistryInterface
     */
    private $registry;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(RegistryInterface $registry, SerializerInterface $serializer)
    {
        $this->registry = $registry;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/planets", methods={"GET"})
     */
    public function __invoke()
    {
        $planets = $this->registry->getRepository(Planet::class)->findAll();

        return new JsonResponse($this->serializer->serialize($planets, 'json', ['groups' => ['get-planet']]), Response::HTTP_OK, [], true);
    }
}
