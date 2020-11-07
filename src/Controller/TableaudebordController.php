<?php

namespace App\Controller;

use App\Entity\Language;
use App\Entity\User;
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
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll();
        $languages = $em->getRepository(Language::class)->findAll();
        $listvue = $em->getRepository(Language::class)->findBy(['nom' => 'Vue.js']);
        $listp = $em->getRepository(Language::class)->findBy(['nom' => 'PHP']);


        return $this->render('tableaudebord/index.html.twig', [
            'users' => $users,
            'languages' => $languages,
            'listp' => $listp,
            'listvue' => $listvue,
        ]);
    }
}
