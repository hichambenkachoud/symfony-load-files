<?php


namespace App\Infrastructure\Client\Repository;

use App\Domain\Client\Repository\ClientCommandRepositoryInterface;
use App\Domain\Entities\Client;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class ClientCommandRepository
 * @package App\Infrastructure\Client\Repository
 */
class ClientCommandRepository extends EntityRepository implements ClientCommandRepositoryInterface
{

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * ClientCommandRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Client $client
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Client $client): void
    {
        $this->entityManager->persist($client);
        $this->entityManager->flush();
    }
}
