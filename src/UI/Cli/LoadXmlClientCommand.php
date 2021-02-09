<?php


namespace App\UI\Cli;


use App\Domain\Client\Repository\ClientCommandRepositoryInterface;
use App\Domain\Client\UseCase\LoadClients;
use App\Domain\Entities\Client;
use App\Domain\Entities\Decision;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class LoadXmlClientCommand extends Command
{
    use CommandTrait;

    /**
     * Le nome de la commande: bin/console app:load-xml
     * @var string
     */
    protected static $defaultName = 'app:load-xml';

    /**
     * le nom de fichier
     * @var string
     */
    protected $fileName = 'client.xml';

    /**
     * le chemin vers le fichier dans le répertoire resources
     * @var string
     */
    protected $path = __DIR__. '/../../../resources/';

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
        parent::__construct();
        $this->clientCommandRepository = $clientCommandRepository;
    }

    /**
     * configurer la commande avec les options
     */
    protected function configure()
    {
        $this
            ->setDescription('Load les clients')
            ->addOption('fileName', null, InputOption::VALUE_OPTIONAL, 'Le nom de fichier')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $output->writeln([
            'Importer les données',
            '========================',
        ]);

        // lire le fichier
        $data = $this->readXmlFile($input, $output);

        // créer le client
        $client = $this->createClient($data, $data[Client::COL_DECISION]['type_et_decision']);

        // LoadClients
        $loadClient = new LoadClients($this->clientCommandRepository);
        $loadClient->execute($client);


        $output->writeln([
            "L'import est terminé",
            '========================',
        ]);

        return 1;
    }
}
