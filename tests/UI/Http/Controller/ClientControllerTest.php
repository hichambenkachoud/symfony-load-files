<?php


namespace App\Tests\UI\Http\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ClientControllerTest
 * @package App\Tests\UI\Http\Controller
 */
class ClientControllerTest extends WebTestCase
{

    /**
     * URL pour tester les différents routes des territorialirés
     */
    private const CLIENTS_URL_API = 'api/clients/';
    private const HTTP_HEADER_JSON = array('CONTENT_TYPE' => 'application/json');
    private const HTTP_HEADER_XML = array('CONTENT_TYPE' => 'application/xml');

    /**
     * @test
     * @group rest
     */
    public function it_should_return_a_200_status_code_and_json_content()
    {
        // Url pour retrouver tous les territorialités
        $url = self::CLIENTS_URL_API;
        self::ensureKernelShutdown();

        // crée le client http
        $client = static::createClient();

        // executer la requête GET
        $client->request(
            'GET',
            $url,
            array(),
            array(),
            self::HTTP_HEADER_JSON
        );
        // vérifier si le status code est 200
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }

    /**
     * @test
     * @group rest
     */
    public function it_should_return_a_200_status_code_and_xml_content()
    {
        // Url pour retrouver tous les territorialités
        $url = self::CLIENTS_URL_API;
        self::ensureKernelShutdown();

        // crée le client http
        $client = static::createClient();

        // executer la requête GET
        $client->request(
            'GET',
            $url,
            array(),
            array(),
            self::HTTP_HEADER_XML
        );
        // vérifier si le status code est 200
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('<id_unique>', $client->getResponse()->getContent());
        $this->assertStringContainsString('<cin>', $client->getResponse()->getContent());
        $this->assertStringContainsString('<nom>', $client->getResponse()->getContent());
        $this->assertStringContainsString('<decisions>', $client->getResponse()->getContent());
    }
}
