<?php

namespace App\Controller;

use App\Repository\UserRepository;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    public function __construct(private UserRepository $repository)
    {

    }

    /**
     * @Route("/", name="app_main")
     */
    public function index(): Response
    {
        if($this->getUser()) {
            return $this->render('main/index.html.twig', [
                'controller_name' => 'MainController',
                'hashKey' => $this->repository->updateHashKey($this->getUser()),
            ]);
        }
        else {
            return $this->redirectToRoute('app_login');
        }
    }

    /**
     * @Route("/user-list", name="app_user-list")
     */
    public function list(): Response
    {
        if($this->getUser()) {
            return new JsonResponse($this->repository->findOthers($this->getUser()->getId()), 200, ["Content-Type" => "application/json"]);
        }
        $this->createNotFoundException();
        return  Response::create('');
    }


}
