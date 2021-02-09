<?php


namespace App\UI\Http\Rest\Controller;

use App\Domain\Client\UseCase\GetClients;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ClientController
 * @package App\UI\Http\Rest\Controller
 * @Route(path="/api/clients/")
 */
class ClientController extends BaseController
{
    /**
     * @Route(path="", methods={"GET"})
     * @param Request $request
     * @param GetClients $clients
     * @return Response
     */
    public function findAll(Request $request, GetClients $clients): Response
    {
        $clients = $clients->execute();
        return $this->createResponse($clients, $this->responseFormat($request), ['ClientList']);
    }
}
