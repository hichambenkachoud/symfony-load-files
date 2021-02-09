<?php


namespace App\Domain\Client\UseCase;

use App\Domain\Client\Repository\ClientCommandRepositoryInterface;
use App\Domain\Entities\Client;

/**
 * Class LoadClients
 * @package App\Domain\Client\UseCase
 */
class LoadClients
{
    /**
     * @var ClientCommandRepositoryInterface
     */
    private $clientCommandRepository;

    /**
     * LoadClients constructor.
     * @param ClientCommandRepositoryInterface $clientCommandRepository
     */
    public function __construct(ClientCommandRepositoryInterface $clientCommandRepository)
    {
        $this->clientCommandRepository = $clientCommandRepository;
    }

    /**
     * @param Client $client
     */
    public function execute(Client $client): Client
    {
        $this->clientCommandRepository->save($client);
        return $client;
    }
}
