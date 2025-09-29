<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PostController extends AbstractController
{
    #[Route('/post', name: 'app_post')]
    public function index(PostRepository $postRepo)
    {
 
        return $this->render('post/index.html.twig', [
            'posts' => $postRepo -> findBy([])
        ]);
    }
     #[Route('/post/{id}/detail', name: 'app_post_detail')]
    public function detail(int $id, PostRepository $postRepo)
    {
      $post = $postRepo ->findOneBy(['id'=>$id]);
      return $this->render('post/detail.html.twig', [
        'post'=>$post
      ]);
        
    }





    #[Route('post/create', name: 'app_post_create')]
    public function create(Request $request, EntityManagerInterface $em) 
    {
        // dd('je suis dans ma function create'); // j'ai testé le fonctionnement de mon lien
        $post = new Post(); // création d'une nouvelle instance

        $form = $this ->createForm(PostType::class, $post);  // création du formulaire

        $form -> handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $em->persist($post); 
            $em->flush();

            return $this->redirectToRoute('app_post'); 
        }

        // dd($post, $form); 
        return $this->render('post/create.html.twig', [
            'formPost' => $form
        ]);
    }




}
