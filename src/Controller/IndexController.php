<?php
namespace App\Controller;
use App\Entity\CategorySearch;
use App\Form\CategorySearchType;
use App\Form\ArticleType;
use App\Form\CategoryType;
use App\Form\PropertySearchType;
use App\Entity\PriceSearch;
use App\Form\PriceSearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\PropertySearch;
Use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class IndexController extends AbstractController
{
    /**
       *@Route("/", name="article_list")
       */

public function home(Request $request)
{
    $propertySearch = new PropertySearch();
    $form = $this->createForm(PropertySearchType::class,$propertySearch);
    $form->handleRequest($request);
//initialement le tableau des articles est vide,
//c.a.d on affiche les articles que lorsque l'utilisateur
//clique sur le bouton rechercher
    $articles=$this->getDoctrine()->getRepository(Article::class)->findAll();
    if($form->isSubmitted() && $form->isValid()) {
//on récupère le nom d'article tapé dans le formulaire
        $nom = $propertySearch->getNom();
       // $nom=$data.getNom();
        if ($nom!="")

            $articles= $this->getDoctrine()->getRepository(Article::class)->findBy(['nom' => $nom] );

//si on a fourni un nom d'article on affiche tous les articles ayant ce n


else
    $articles= $this->getDoctrine()->getRepository(Article::class)->findAll();

//si si aucun nom n'est fourni on affiche tous les articles
      }

    return
        $this->render('articles/index.html.twig',[ 'form' =>$form->createView(), "articles" => $articles]);

}
/**
   * @Route("/article/save")
   */
public function save(){
    $em= $this->getDoctrine()->getManager();
    $article=new Article();
    $article->setNom('moto');
    $article->setPrix(2600);
    $em->persist($article);
    $em->flush();
    return new Response('succès d ajout d article N:'.$article->getId());
}
    /**
      * @Route("/article/new", name="new_article")
      * Method({"GET", "POST"})
      */
    public function new(Request $request) {
        $article = new Article();
        $form = $this->createForm(ArticleType::class,$article);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('article_list');
        }


        return $this->render('articles/new.html.twig',['f' => $form->createView()]);
}
    /**
      * @Route("/article/{id}", name="show_article")
      */
    public function show($id){
        $article=$this->getDoctrine()->getRepository(Article::class)->find($id);
        return $this->render("articles/show.html.twig",["article"=>$article]);
    }
    /**
      *@Route("/article/edit/{id}", name="article_edit")
      */
    public function edit(Request $request, $id){
        $article=$this->getDoctrine()->getRepository(Article::class)->find($id);
        $form=$this->createForm(ArticleType::class,$article);
        $form->handleRequest($request);
         if($form->isSubmitted() && $form->isValid()){
             $article=$form->getData();
             $em=$this->getDoctrine()->getManager();
             $em->persist($article);
             $em->flush();
             return $this->redirectToRoute("article_list");

         }
         return $this->render("articles/edit.html.twig", ['form'=>$form->createView()]);
    }
    /**
      * @Route("/article/delete/{id}",name="delete_article")
      * @Method({"DELETE"})
      */

    public function delete($id){
        $article=$this->getDoctrine()->getRepository(Article::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();
        $response = new Response();
        $response->send();
        return $this->redirectToRoute('article_list');
    }
    /**
       ** @Route("/category/new", name="new_category")
       * Method({"GET", "POST"})
       */
    public function newCategory(Request $request){
        $categorie= new Category();
        $form=$this->createForm(CategoryType::class,$categorie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $categorie=$form->getData();
            $em->persist($categorie);
            $em->flush();
           // return $this->redirectToRoute("category_list");
        }
        return $this->render("categories/newCategory.html.twig",["form"=>$form->createView()]);
    }
    /**
      * @Route("/art_cat/", name="article_par_cat")
      * Method({"GET", "POST"})
      */
    public function articlesParCategorie(Request $request) {
        $categorySearch = new CategorySearch();
        $form = $this->createForm(CategorySearchType::class,$categorySearch);
        $form->handleRequest($request);
        $articles=[];
        if($form->isSubmitted() && $form->isValid()) {
            $category = $categorySearch->getCategory();
            if ($category!="")
                $articles= $category->getArticles();
            else
                $articles= $this->getDoctrine()->getRepository(Article::class)->findAll();
            //return $this->render('articles/articlesParCategorie.html.twig',['articles' => $articles]);
        }
        return $this->render('articles/articlesParCategorie.html.twig',['form' => $form->createView(),'articles' => $articles]);
}
    /**
      * @Route("/art_prix/", name="article_par_prix")
      * Method({"GET"})
      */
    public function articlesParPrix(Request $request)
    {
        $priceSearch = new PriceSearch();
        $form = $this->createForm(PriceSearchType::class,$priceSearch);
        $form->handleRequest($request);
        $articles= [];
        if($form->isSubmitted() && $form->isValid()) {
            $minPrice = $priceSearch->getMinPrice();
            $maxPrice = $priceSearch->getMaxPrice();
            $articles= $this->getDoctrine()->
            getRepository(Article::class)->findByPriceRange($minPrice,$maxPrice);
        }
        return
            $this->render('articles/articlesParPrix.html.twig',
                [ 'form' =>$form->createView(), 'articles' => $articles]);
}
}
