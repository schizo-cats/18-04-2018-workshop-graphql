<?php
namespace App\DataFixtures;

use App\Entity\Planet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PlanetFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $planet = new Planet();
        $planet->setName('Tok\'ras');
        $planet->setAttack(100);
        $planet->setDefense(120);
        $planet->setUuid(hash('sha256', uniqid(', true')));
        $manager->persist($planet);

        $planet = new Planet();
        $planet->setName('Goa\'ulds');
        $planet->setAttack(120);
        $planet->setDefense(100);
        $planet->setUuid(hash('sha256', uniqid(', true')));
        $manager->persist($planet);
        $manager->flush();
    }
}
