<?php

namespace App\DataFixtures;

use App\Doctrine\Entity\Main\Currency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CurrencyFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $date = new \DateTime();
        $currency = new Currency();
        $currency->setCreatedAt($date);
        $currency->setUpdatedAt($date);
        $currency->setCode(Currency::USD_CODE);
        $currency->setSymbol('$');

        $manager->persist($currency);

        $manager->flush();
    }
}
