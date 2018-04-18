<?php
namespace App\Controller\Astronaut;

use App\Entity\Astronaut;
use App\Entity\Planet;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class Register
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
     * @Route("/register/{planetUuid}", methods={"POST"})
     */
    public function __invoke(Request $request, string $planetUuid)
    {
        $planet = $this->registry->getRepository(Planet::class)->findOneByUuid($planetUuid);
        if ($planet === null) {
            return new JsonResponse(['error' => sprintf('Undefined planet with uuid "%s"', $planetUuid)], Response::HTTP_NOT_FOUND);
        }

        /** @var Astronaut $astronaut */
        $astronaut = $this->serializer->deserialize($request->getContent(), Astronaut::class, 'json');
        $astronaut->setUuid(hash('sha256', uniqid('', true)));

        return new JsonResponse($this->serializer->serialize($astronaut, 'json', ['groups' => 'register']), Response::HTTP_OK, [], true);
    }
}
