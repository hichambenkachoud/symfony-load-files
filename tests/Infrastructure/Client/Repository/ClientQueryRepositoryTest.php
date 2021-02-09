<?php


namespace App\Tests\Infrastructure\Client\Repository;


use App\Domain\Entities\Client;
use App\Domain\Entities\Decision;
use App\Infrastructure\Client\Repository\ClientCommandRepository;
use App\Infrastructure\Client\Repository\ClientQueryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class JournalCommandRepositoryTest
 * @package App\Tests\Infrastructure\Journal\Journal\Repository\Sql
 */
class ClientQueryRepositoryTest extends WebTestCase
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
    public function test_get_clients()
    {
        // Créer le répository
        $queryRepository = new ClientQueryRepository($this->entityManager);

        // Executer la méthode findAll
        $results = $queryRepository->findAll();

        // vérification
        self::assertNotEmpty($results);
    }

    /**
     * Rollback
     */
    protected function tearDown(): void
    {
        $this->entityManager->rollback();
    }
}
