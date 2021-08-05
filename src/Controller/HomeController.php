<?php

namespace App\Controller;

use App\Repository\ForumRepository;
use App\Repository\GameRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var PostRepository
     */
    private $postRepository;
    /**
     * @var ForumRepository
     */
    private $forumRepository;
    /**
     * @var GameRepository
     */
    private $gameRepository;

    /**
     * HomeController constructor.
     * @param EntityManagerInterface $em
     * @param PostRepository $postRepository
     * @param ForumRepository $forumRepository
     * @param GameRepository $gameRepository
     */
    public function __construct(EntityManagerInterface $em, PostRepository $postRepository, ForumRepository $forumRepository, GameRepository $gameRepository)
    {
        $this->em = $em;
        $this->postRepository = $postRepository;
        $this->forumRepository = $forumRepository;
        $this->gameRepository = $gameRepository;
    }


    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $posts = $this->postRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'posts'=>$posts
        ]);
    }
    /**
     * @Route("/post/{id}", name="detail_post")
     */
    public function detailPost(Request $request, $id): Response
    {
        $post = $this->postRepository->find($id);
        $post->setNumberView($post->getNumberView()+1);
        $this->em->persist($post);
        $this->em->flush();

        return $this->render('post/detailPost.html.twig', [
            'controller_name' => 'HomeController',
            'post'=>$post

        ]);
    }


}
