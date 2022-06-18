<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_main")
     */
    public function index(): Response
    {
        if($this->getUser()) {
            return $this->render('main/index.html.twig', [
                'controller_name' => 'MainController',
            ]);
        }
        else {
            return $this->redirectToRoute('app_login');
        }
    }
}
