<?php


namespace App\Infrastructure\Client\Repository;

use App\Domain\Client\Repository\ClientQueryRepositoryInterface;
use App\Domain\Entities\Client;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class ClientCommandRepository
 * @package App\Infrastructure\Client\Repository
 */
class ClientQueryRepository extends EntityRepository implements ClientQueryRepositoryInterface
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
     * @return array
     */
    public function findAll(): array
    {
        return  $this->entityManager->getRepository(Client::class)->findAll();
    }
}
