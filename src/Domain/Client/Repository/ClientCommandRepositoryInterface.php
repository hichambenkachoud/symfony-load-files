<?php


namespace App\Domain\Client\Repository;

use App\Domain\Entities\Client;

/**
 * Interface ClientCommandRepositoryInterface
 * @package App\Domain\Client\Repository
 */
interface ClientCommandRepositoryInterface
{
    /**
     * @param Client $client
     */
    public function save(Client $client): void;
}
