<?php


namespace App\Tests\Domain\Client;

use App\Domain\Client\Repository\ClientCommandRepositoryInterface;
use App\Domain\Client\Repository\ClientQueryRepositoryInterface;
use App\Domain\Client\UseCase\GetClients;
use App\Domain\Client\UseCase\LoadClients;
use App\Domain\Entities\Client;
use App\Domain\Entities\Decision;
use Doctrine\Common\Collections\ArrayCollection;
use phpDocumentor\Reflection\Types\Void_;
use PHPUnit\Framework\TestCase;

/**
 * Class GetClientsTest
 * @package App\Tests\Domain\Client
 */
class SaveClientsTest extends TestCase
{

    /**
     * @test
     * @group unit
     */
    public function should_save_a_client()
    {
        // le résultat à retourner
        $expectedResult = Client::fromArray('test', 'test12', 123, new \DateTime(),
            new ArrayCollection([
                    Decision::fromArray('test_type', 'test_decision')]
            )
        );
        // mock le répositorie
        $clientCommandRepository = $this->getMockBuilder(ClientCommandRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $clientCommandRepository->method('save');

        // UseCase
        $useCase = new LoadClients($clientCommandRepository);
        $result = $useCase->execute($expectedResult);

        // vérification
        $this->assertInstanceOf(Client::class, $expectedResult);
        $this->assertEquals($expectedResult->getCin(), $result->getCin());
        $this->assertEquals($expectedResult->getCodeCompta(), $result->getCodeCompta());
    }
}
