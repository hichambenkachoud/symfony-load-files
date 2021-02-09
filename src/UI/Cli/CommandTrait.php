<?php


namespace App\UI\Cli;


use App\Domain\Entities\Client;
use App\Domain\Entities\Decision;
use App\Infrastructure\Shared\Exception\ImportFileDoesNotExistException;
use App\Infrastructure\Shared\Exception\ImportFileIsEmptyException;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class CommandTrait
 * @package App\Ui\Cli
 */
trait CommandTrait
{

    /**
     * @param $output
     * @return array
     * @throws \Exception
     */
    public function readJsonFile($input, $output): array
    {
        // vérifier le nom de fichier s'il est fournit
        $this->checkFileName($input);

        // vérifier si le fichier existe
        $this->checkFileExist($output);

        $contentJson = file_get_contents($this->path . $this->fileName);

        if ($contentJson === false) {
            throw new ImportFileIsEmptyException("Fichier est vide");
        }

        return json_decode($contentJson, true);
    }


    public function readXmlFile($input, $output)
    {
        // vérifier le nom de fichier s'il est fournit
        $this->checkFileName($input);

        // vérifier si le fichier existe
        $this->checkFileExist($output);

        $contentJson = file_get_contents($this->path . $this->fileName);

        if ($contentJson === false) {
            throw new ImportFileIsEmptyException("Fichier est vide");
        }

        $xml = simplexml_load_string($contentJson);

        return self::simplexmlToArray($xml);
    }

    /**
     * @param array $data
     * @param array $decisions
     * @return Client
     */
    public function createClient(array $data, array $decisions): Client
    {
        $decisions = array_map(function ($object){
            return Decision::fromArray($object['type_acte'], $object['decision']);
        }, $decisions);

        // créer l'object client
        $client = Client::fromArray(
            $data[Client::COL_NAME],
            $data[Client::COL_CIN],
            $data[Client::COL_CODE],
            new \DateTime($data[Client::COL_DEPOSIT_DATE]),
            new ArrayCollection($decisions)//
        );

        return  $client;
    }

    /**
     * Vérifier si le fichier existe
     * @param $output
     */
    private function checkFileExist($output)
    {
        // vérifier si le fichier existe, sinon jeter une exception
        if (!file_exists($this->path . $this->fileName)) {
            $output->writeln([
                "Le fichier n'existe pas"
            ]);
            throw new ImportFileDoesNotExistException("Le fichier n'existe pas");
        }
    }

    /**
     * Vérifier si le nom de fichier est passé en argument
     * @param $input
     */
    private function checkFileName($input)
    {
        // récupérer le nom de fichier s'il est fournit
        if (!empty($input->getOption('fileName')))
        {
            $this->fileName = $input->getOption('fileName');
        }
    }

    /**
     * @param $xml
     * @return array
     * https://hotexamples.com/examples/-/-/simplexml_to_array/php-simplexml_to_array-function-examples.html
     */
    private static function simplexmlToArray($xml): array
    {
        $ar = array();
        foreach ($xml->children() as $k => $v) {
            $child = self::simplexmlToArray($v);
            if (count($child) == 0) {
                $child = (string) $v;
            }
            foreach ($v->attributes() as $ak => $av) {
                if (!is_array($child)) {
                    $child = array("value" => $child);
                }
                $child[$ak] = (string) $av;
            }
            if (!array_key_exists($k, $ar)) {
                $ar[$k] = $child;
            } else {
                if (!is_string($ar[$k]) && isset($ar[$k][0])) {
                    $ar[$k][] = $child;
                } else {
                    $ar[$k] = array($ar[$k]);
                    $ar[$k][] = $child;
                }
            }
        }
        return $ar;
    }
}
