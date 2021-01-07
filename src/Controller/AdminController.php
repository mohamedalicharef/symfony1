<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
    /**
      * @Route("/admin", name="admin_")
      */
class AdminController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function home(UserRepository $user): Response
    {
        return $this->render('admin/home.html.twig');
    }
    /**
     * @Route("/utilisateurs", name="utilisateurs")
     */
    public function userList(UserRepository $user): Response
    {
        return $this->render('admin/users.html.twig', [
            'users' => $user->findAll()
        ]);
    }
    /**
     * @Route("/utilisateurs/modifier/{id}", name="modifier_utilisateurs")
     */
    public function editUser(Request $request, User $user, EntityManagerInterface $em){
       $form=$this->createForm(EditUserType::class,$user);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()){
           $em->persist($user);
           $em->flush();
           $this->redirectToRoute('admin_utilisateurs');
       }

       return $this->render('admin/editUser.html.twig',
                    ['formUser'=>$form->createView()]);

    }

}
