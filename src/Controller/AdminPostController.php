<?php

namespace App\Controller;


use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AdminPostController extends AbstractController
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var Security
     */
    private $security;




    /**
     * AdminPostController constructor.
     * @param PostRepository $postRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(PostRepository $postRepository, EntityManagerInterface $em, Security $security)
    {
        $this->postRepository = $postRepository;
        $this->em = $em;
        $this->security = $security;


    }

    /**
     * @Route("/admin", name="home_post")
     */
    public function index(): Response
    {
        return $this->render('home/indexAdmin.html.twig', [
            'controller_name' => 'AdminPostController',
        ]);
    }

    /**
     * @Route("/admin/post_list", name="post_list")
     */
    public function PostList(): Response
    {
        $postEntities = $this->postRepository->findAll();
        return $this->render('post/postList.html.twig', [
            'controller_name' => 'AdminPostController',
            'posts'=>$postEntities
        ]);
    }

    /**
     * @Route("/admin/create_post", name="create_post")
     * @param Request $request
     * @return Response
     */

    public function createPost(Request $request): Response
    {
        $postEntity = new Post();

        $form = $this->createForm(PostType::class,$postEntity);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            $postEntity->setCreatedAt(new \DateTime());
            $postEntity->setStatus(0);
            $postEntity->setNumberView(0);

           $currentUser =  $this->security->getUser();
            $postEntity->setUser($currentUser);
            $this->em->persist($postEntity);
            $this->em->flush();
            return $this->redirectToRoute('post_list');

        }
        return $this->render('post/createPost.html.twig', [
            'controller_name' => 'AdminPostController',
            'formPost'=>$form->createView(),

        ]);
    }


    /**
     * @Route("/admin/edit_post/{id}", name="edit_post")
     * @param Request $request
     * @return Response
     */

    public function editPost(Request $request, $id): Response
    {
        $postEntity = $this->postRepository->find($id);
        $form = $this->createForm(PostType::class,$postEntity);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($postEntity);
            $this->em->flush();
            return $this->redirectToRoute('post_list');

        }
        return $this->render('post/editPost.html.twig', [
            'controller_name' => 'AdminPostController',
            'formPost'=>$form->createView()
        ]);
    }
    /**
     * @Route("/admin/delete_post/{id}", name="delete_post")
     */
    public function deletePost($id): Response
    {
        $postEntity = $this->postRepository->find($id);
        $this->em->remove($postEntity);
        $this->em->flush();

        return $this->redirectToRoute('post_list');



    }
}
