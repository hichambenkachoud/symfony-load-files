<?php


namespace App\UI\Http\Rest\Controller;


use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
/**
 * Class BaseController
 * @package App\Ui\Http\Rest\Controller
 */
abstract class BaseController extends AbstractController
{
    /** @var SerializerInterface */
    protected $serializer;

    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(
        serializerInterface $serializer
    )
    {
        $this->serializer = $serializer;
    }

    /**
     * Serialiser les données
     * @param mixed $data
     * @param string $format
     * @param array $groups
     * @return string|null
     */
    protected function serialize($data, $format = 'json', array $groups=array()): ?string
    {
        $context = !empty($groups) ? SerializationContext::create()->setGroups($groups) : null;
        return $this->serializer->serialize($data, $format, $context);
    }

    /**
     * Retourne le Response paginé et sérialisé
     * @param mixed $data
     * @param string $format
     * @param array $groups
     * @return Response
     */
    public function createResponse(
        $data,
        $format = 'json',
        array $groups=array()
    ): Response
    {
        $result = $this->serialize($data, $format, $groups);
        return new Response($result, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     */
    public function responseFormat(Request $request): string
    {
        $contentType = $request->headers->get('Content-Type');
        $format = 'json';

        if (strpos($contentType, 'xml') !== FALSE){
            $format = 'xml';
        }

        return $format;
    }
}
