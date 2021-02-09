<?php


namespace App\Infrastructure\Shared\Fixtures;


use App\Domain\Client\Repository\ClientCommandRepositoryInterface;
use App\Domain\Entities\Client;
use App\Domain\Entities\Decision;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;

class ClientFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $client = Client::fromArray(
                "Client $i",
                "Cin $i",
                10 * $i + 1,
                new \DateTime(),
                new ArrayCollection([
                    Decision::fromArray("Type_Acte ".($i+1), "Decision ".($i+1)),
                    Decision::fromArray("Type_Acte ".($i+2), "Decision ".($i+2)),
                ])
            );

            $manager->persist($client);
        }

        $manager->flush();
    }
}
