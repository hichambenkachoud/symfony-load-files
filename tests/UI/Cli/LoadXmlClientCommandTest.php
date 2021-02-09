<?php


namespace App\Tests\UI\Cli;

use App\Infrastructure\Shared\Exception\ImportFileDoesNotExistException;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class LoadJsonClientCommandTest
 * @package App\Tests\UI\Cli
 */
class LoadXmlClientCommandTest extends KernelTestCase
{
    /**
     * @test
     * @group integration
     */
    public function should_complete_successfully()
    {
        // récupérer le kernal
        $kernel = static::createKernel();
        $application = new Application($kernel);
        // cherche la command à tester
        $command = $application->find('app:load-json');
        // passer notre command au tester
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $output = $commandTester->getStatusCode();
        $this->assertEquals(1, $output);
    }

    /**
     * @test
     * @group integration
     */
    public function should_throw_file_does_not_exist_exception_when_file_not_exist()
    {
        // récupérer le kernal
        $kernel = static::createKernel();
        $application = new Application($kernel);
        // cherche la command à tester
        $command = $application->find('app:load-json');
        // passer notre command au tester
        $commandTester = new CommandTester($command);
        // prévoir exception lorsque le fichier n'existe pas
        $this->expectException(ImportFileDoesNotExistException::class);
        $commandTester->execute([
            '--fileName' => 'fileNotFound.xml'
        ]);
    }
}
