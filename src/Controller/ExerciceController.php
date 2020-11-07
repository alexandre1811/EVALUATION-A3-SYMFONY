<?php

namespace App\Controller;

use App\Entity\Exercice;
use App\Form\ExerciceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExerciceController extends AbstractController
{
    /**
     * @Route("/exercice", name="exercice")
     */
    public function index(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $exercices = $em->getRepository(Exercice::class)->findAll();

        $exercice = new Exercice();
        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($exercice);
            $em->flush();
            $this->addFlash('sucess', 'Exercice Ajouté');
        }

        $exercices = $em->getRepository(Exercice::class)->findAll();
        return $this->render('exercice/index.html.twig', [
            'exercices' => $exercices,
            'ajout'=>$form->createView()
        ]);
    }

    /**
     * @Route("exercice/{id}", name="show-exercice")
     */

    public function showArticle(Exercice $exercice = null, Request $request){
        if ($exercice == null){
            $this->addFlash('error', 'Exercice Introuvable');

            return $this->redirectToRoute('exercice');
        };
        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em= $this->getDoctrine()->getManager();
            $em->persist($exercice);
            $em->flush();
            $this->addFlash('sucess', 'Exercice Modifié');
        }

        return $this->render('exercice/show.html.twig', ['exercice' =>$exercice, 'maj' => $form->createView()]);
    }

    /**
     * @Route("exercice/delete/{id}", name="delete_exercice")
     */

    public function delete(Exercice $exercice = null){
        if ($exercice ==null){

            $this->addFlash("danger", "Exercice intouvable");
            return $this->redirectToRoute('exercice');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($exercice);
        $em->flush();
        $this->addFlash("success", "Exercice supprimé");
        return $this->redirectToRoute('exercice');

    }
}
