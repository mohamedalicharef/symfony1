<?php

namespace App\Controller;
Use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Groupe;
use App\Form\GroupeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class GroupeController extends AbstractController
{
    /**
     * @Route("/groupe", name="groupe_list")
     */
    public function index(): Response
    {
        $groupes = $this->getDoctrine()->getRepository(Groupe::class)->findAll();
        return $this->render('groupe/index.html.twig', ['groupes' => $groupes,
        ]);
    }
    /**
     * @Route("/groupe/new", name="new_groupe")
     * Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $groupe = new Groupe();
        $form = $this->createForm(GroupeType::class, $groupe);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $groupe = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($groupe);
            $entityManager->flush();
            return $this->redirectToRoute('groupe_list');
        }
        return $this->render('groupe/new.html.twig',['f' => $form->createView()]);
    }
    /**
     * @Route("/groupe/{id}", name="show_groupe")
     */
    public function show($id){
        $groupe=$this->getDoctrine()->getRepository(Groupe::class)->find($id);
        return $this->render("groupe/show.html.twig",["groupe"=>$groupe]);
    }
    /**
     *@Route("/groupe/edit/{id}", name="groupe_edit")
     */
    public function edit(Request $request, $id){
        $groupe=$this->getDoctrine()->getRepository(Groupe::class)->find($id);
        $form=$this->createForm(GroupeType::class,$groupe);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $groupe=$form->getData();
            $em=$this->getDoctrine()->getManager();
            $em->persist($groupe);
            $em->flush();
            return $this->redirectToRoute("groupe_list");

        }
        return $this->render("groupe/edit.html.twig", ['form'=>$form->createView()]);
    }
    /**
     * @Route("/article/delete/{id}",name="delete_article")
     * @Method({"DELETE"})
     */

    public function delete($id){
        $groupe=$this->getDoctrine()->getRepository(Groupe::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($groupe);
        $em->flush();
        $response = new Response();
        $response->send();
        return $this->redirectToRoute('groupe_list');
    }

}

