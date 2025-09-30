<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PostController extends AbstractController
{
    #[Route('/post', name: 'app_post')]
    public function index(PostRepository $postRepo )
    {
         
        return $this->render('post/index.html.twig', [
            'posts' => $postRepo -> findBy([])
            
        ]);
    }
     #[Route('/post/{id}/detail', name: 'app_post_detail')]
    public function detail(int $id, PostRepository $postRepo, CommentRepository $commentRepository)
    {
      $post = $postRepo ->findOneBy(['id'=>$id]);
      $comments = $commentRepository->findBy(['id_post' => $id], ['createdAt' => 'DESC']);
      return $this->render('post/detail.html.twig', [
        'post'=>$post, 
        'comments' => $comments
      ]);
        
    }


    // Page de création de post
    #[Route('post/create', name: 'app_post_create')]
    public function create(Request $request, EntityManagerInterface $em) 
    {
        // dd('je suis dans ma function create'); // j'ai testé le fonctionnement de mon lien
        $post = new Post(); // création d'une nouvelle instance

        $form = $this ->createForm(PostType::class, $post);  // création du formulaire

        $form -> handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid()) // vérification de la soumission et de la validité du formulaire
        {
            $file = $form->get('image')->getData(); 
            if($file) {
                // dd('super, jai une image je vais pouvoir la traiter');
                $newFileName = time() . '-' . $file->getClientOriginalName(); // cette ligne permet de changer le nom du fichier de manière unique 
                // time() c'est comme unique id 
                // dd($newName, $post, $fileName); 

                $file->move($this->getParameter('post_dir'), $newFileName); 

                $post->setImage($newFileName);
                // dd($file, $post, $newFileName); 
            }
            // dd($form->get('image')->getData()); // vérification des données de l'image
            $em->persist($post); 
            $em->flush();

            return $this->redirectToRoute('app_post'); // redirection à la page de tous les posts 
        }

        // dd($post, $form); 
        return $this->render('post/create.html.twig', [
            'formPost' => $form
        ]);
    }


    // Formulaire de modification d'un post existant 
    #[Route('post/{id}/update', name:'app_post_update')]
    public function update(Post $post, Request $request, EntityManagerInterface $em) {
        // dd('je suis dans ma page update');

        $form = $this->createForm(PostType::class, $post);
        // dd($form);

        $form->handleRequest($request); // je récupère le formulaire
        

        // Je vérifie si le formulaire a bien été soumis et si il est bien valide 
        if($form->isSubmitted() && $form->isValid()) {
            $em-> flush(); // je l'envoie 
            return $this->redirectToRoute('app_post');
        }

        return $this->render('post/update.html.twig', [
            'form' => $form
        ]);
    }


    // #[Route('post/{id}/detail/comment', name:'app_post_comment')]
    // public function comment(Post $post, CommentRepository $commentRepository, $id) {
    //     $comments = $commentRepository->findBy(['id_post' => $id], ['createdAt' => 'DESC']);
    //     // dd($post, $comments);
    //     return $this->render('post/detail.html.twig', [
    //         'comments' => $comments,
    //         'post' => $post
    //     ]);
    // }
}
