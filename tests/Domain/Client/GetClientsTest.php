<?php


namespace App\Tests\Domain\Client;

use App\Domain\Client\Repository\ClientQueryRepositoryInterface;
use App\Domain\Client\UseCase\GetClients;
use App\Domain\Entities\Client;
use App\Domain\Entities\Decision;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * Class GetClientsTest
 * @package App\Tests\Domain\Client
 */
class GetClientsTest extends TestCase
{
    /**
     * @test
     * @group unit
     */
    public function should_return_an_empty_result()
    {
        // mock le répositorie
        $clientQueryRepository = $this->getMockBuilder(ClientQueryRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $clientQueryRepository->method('findAll')->willReturn([]);

        // UseCase
        $useCase = new GetClients($clientQueryRepository);
        $result = $useCase->execute();

        $this->assertEmpty($result);
    }


    /**
     * @test
     * @group unit
     */
    public function should_return_an_array_as_result()
    {
        // le résultat à retourner
        $expectedResult = [
            Client::fromArray('test', 'test12', 123, new \DateTime(),
                new ArrayCollection([
                    Decision::fromArray('test_type', 'test_decision')]
                )
            )
        ];
        // mock le répositorie
        $clientQueryRepository = $this->getMockBuilder(ClientQueryRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $clientQueryRepository->method('findAll')->willReturn($expectedResult);

        // UseCase
        $useCase = new GetClients($clientQueryRepository);
        $result = $useCase->execute();

        // vérification
        $this->assertNotEmpty($result);
        $this->assertInstanceOf(Client::class, $result[0]);
    }
}
