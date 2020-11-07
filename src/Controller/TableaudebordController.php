<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TableaudebordController extends AbstractController
{
    /**
     * @Route("/tableaudebord", name="tableaudebord")
     */
    public function index(): Response
    {
        return $this->render('tableaudebord/index.html.twig', [
            'controller_name' => 'TableaudebordController',
        ]);
    }
}
