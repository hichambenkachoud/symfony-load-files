<?php


namespace App\Tests\Infrastructure\Client\Repository;


use App\Domain\Entities\Client;
use App\Domain\Entities\Decision;
use App\Infrastructure\Client\Repository\ClientCommandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class JournalCommandRepositoryTest
 * @package App\Tests\Infrastructure\Journal\Journal\Repository\Sql
 */
class ClientCommandRepositoryTest extends WebTestCase
{
    /** @var ObjectManager $entityManager */
    private $entityManager;

    /**
     * Begin transaction
     */
    protected function setUp(): void
    {
        self::ensureKernelShutdown();
        $client = static::createClient();
        $container = $client->getKernel()->getContainer();
        $this->entityManager = $container->get('doctrine')->getManager();
        $this->entityManager->beginTransaction();
    }

    /**
     * Tester la méthode save du journal sans exception
     * @test
     * @group unit
     */
    public function test_save_client()
    {
        // Créer le répository
        $commandRepository = new ClientCommandRepository($this->entityManager);
        // Créer le client
        $client = Client::fromArray('test', 'test12', 123, new \DateTime(),
            new ArrayCollection([
                    Decision::fromArray('test_type', 'test_decision')]
            )
        );
        // Executer la méthode save
        $commandRepository->save($client);

        // vérification
        self::assertNotNull($client->getIdUnique());
    }

    /**
     * Rollback
     */
    protected function tearDown(): void
    {
        $this->entityManager->rollback();
    }
}
