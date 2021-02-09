<?php


namespace App\Domain\Client\UseCase;

use App\Domain\Client\Repository\ClientQueryRepositoryInterface;

/**
 * Class LoadClients
 * @package App\Domain\Client\UseCase
 */
class GetClients
{
    /**
     * @var ClientQueryRepositoryInterface
     */
    private $clientQueryRepository;

    /**
     * LoadClients constructor.
     * @param ClientQueryRepositoryInterface $clientQueryRepository
     */
    public function __construct(ClientQueryRepositoryInterface $clientQueryRepository)
    {
        $this->clientQueryRepository = $clientQueryRepository;
    }

    /**
     * @return array
     */
    public function execute(): array
    {
       return  $this->clientQueryRepository->findAll();
    }
}
