<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\ForumRepository;
use App\Repository\GameRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var GameRepository
     */
    private $gameRepository;
    /**
     * @var ForumRepository
     */
    private $forumRepository;
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * GameController constructor.
     * @param EntityManagerInterface $em
     * @param GameRepository $gameRepository
     * @param ForumRepository $forumRepository
     * @param PostRepository $postRepository
     */
    public function __construct(EntityManagerInterface $em, GameRepository $gameRepository, ForumRepository $forumRepository, PostRepository $postRepository)
    {
        $this->em = $em;
        $this->gameRepository = $gameRepository;
        $this->forumRepository = $forumRepository;
        $this->postRepository = $postRepository;
    }


    /**
     * @Route("/game", name="game")
     */
    public function index(): Response
    {
        $forums = $this->forumRepository->findAll();
        $games = $this->gameRepository->findAll();
        return $this->render('game/index.html.twig', [
            'controller_name' => 'GameController',
            'games'=>$games,
            'forums'=>$forums
        ]);
    }
    /**
     * @Route("/game", name="game")
     */
    public function countArticleGame(): Response
    {
        $forums = $this->forumRepository->findAll();
        return $this->render('layout/front.html.twig', [
            'controller_name' => 'GameController',
            'forums'=>$forums
        ]);
    }
}
