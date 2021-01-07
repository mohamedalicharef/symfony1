<?php

namespace App\Controller;
Use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Apprenant;
use App\Form\ApprenantType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class ApprenantController extends AbstractController
{
    /**
      * @Route("/apprenant", name="apprenant_list")
      */
    public function index(): Response
    {
        $apprenants = $this->getDoctrine()->getRepository(Apprenant::class)->findAll();
        return $this->render('apprenant/index.html.twig', [
            'apprenants' => $apprenants,
        ]);
    }

    /**
     * @Route("/apprenant/new", name="new_apprenant")
     * Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $apprenant = new Apprenant();
        $form = $this->createForm(ApprenantType::class, $apprenant);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $apprenant = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($apprenant);
            $entityManager->flush();
            return $this->redirectToRoute('apprenant_list');
        }
        return $this->render('apprenant/new.html.twig',['f' => $form->createView()]);
    }
    /**
     * @Route("/apprenant/{id}", name="show_apprenant")
     */
    public function show($id){
        $apprenant=$this->getDoctrine()->getRepository(Apprenant::class)->find($id);
        return $this->render("apprenant/show.html.twig",["apprenant"=>$apprenant]);
    }
    /**
     *@Route("/apprenant/edit/{id}", name="apprenant_edit")
     */
    public function edit(Request $request, $id){
        $apprenant=$this->getDoctrine()->getRepository(Apprenant::class)->find($id);
        $form=$this->createForm(ApprenantType::class,$apprenant);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $apprenant=$form->getData();
            $em=$this->getDoctrine()->getManager();
            $em->persist($apprenant);
            $em->flush();
            return $this->redirectToRoute("apprenant_list");

        }
        return $this->render("apprenant/edit.html.twig", ['form'=>$form->createView()]);
    }
    /**
     * @Route("/article/delete/{id}",name="delete_article")
     * @Method({"DELETE"})
     */

    public function delete($id){
        $apprenant=$this->getDoctrine()->getRepository(Apprenant::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($apprenant);
        $em->flush();
        $response = new Response();
        $response->send();
        return $this->redirectToRoute('apprenant_list');
    }

}
