<?php

namespace App\DataFixtures;

use App\Doctrine\Entity\Main\Currency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //$manager->flush();
    }
}
