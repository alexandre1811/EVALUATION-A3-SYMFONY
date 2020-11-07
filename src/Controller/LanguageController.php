<?php

namespace App\Controller;

use App\Entity\Language;
use App\Form\LanguageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LanguageController extends AbstractController
{
    /**
     * @Route("/language", name="language")
     */
    public function index(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $languages = $em->getRepository(Language::class)->findAll();

        $language = new Language();
        $form = $this->createForm(LanguageType::class, $language);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($language);
            $em->flush();
            $this->addFlash('sucess', 'Langage Ajouté');
        }

        $languages = $em->getRepository(Language::class)->findAll();
        return $this->render('language/index.html.twig', [
            'languages' => $languages,
            'ajout'=>$form->createView()
        ]);
    }

    /**
     * @Route("language/{id}", name="show-language")
     */

    public function showArticle(Language $language = null, Request $request){
        if ($language == null){
            $this->addFlash('error', 'Langage Introuvable');

            return $this->redirectToRoute('language');
        };
        $form = $this->createForm(LanguageType::class, $language);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em= $this->getDoctrine()->getManager();
            $em->persist($language);
            $em->flush();
            $this->addFlash('sucess', 'Langage Modifié');
        }

        return $this->render('language/show.html.twig', ['langage' =>$language, 'maj' => $form->createView()]);
    }

    /**
     * @Route("language/delete/{id}", name="delete_language")
     */

    public function delete(Language $language = null){
        if ($language ==null){

            $this->addFlash("danger", "Langage intouvable");
            return $this->redirectToRoute('language');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($language);
        $em->flush();
        $this->addFlash("success", "Langage supprimé");
        return $this->redirectToRoute('language');

    }
}
