<?php


namespace App\Domain\Client\Repository;

/**
 * Interface ClientQueryRepositoryInterface
 * @package App\Domain\Client\Repository
 */
interface ClientQueryRepositoryInterface
{
    /**
     * @return array
     */
    public function findAll(): array;
}
