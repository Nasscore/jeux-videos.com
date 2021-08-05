<?php

namespace App\Controller;

use App\Repository\ForumRepository;
use App\Repository\MessageRepository;
use App\Repository\TopicRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumFrontController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ForumRepository
     */
    private $forumRepository;
    /**
     * @var TopicRepository
     */
    private $topicRepository;
    /**
     * @var MessageRepository
     */
    private $messageRepository;

    /**
     * ForumFrontController constructor.
     * @param EntityManagerInterface $em
     * @param ForumRepository $forumRepository
     * @param TopicRepository $topicRepository
     * @param MessageRepository $messageRepository
     */
    public function __construct(EntityManagerInterface $em, ForumRepository $forumRepository, TopicRepository $topicRepository, MessageRepository $messageRepository)
    {
        $this->em = $em;
        $this->forumRepository = $forumRepository;
        $this->topicRepository = $topicRepository;
        $this->messageRepository = $messageRepository;
    }


    /**
     * @Route("/forum/{id}", name="forum")
     */
    public function detailForum(int $id): Response
    {
       $forum = $this->forumRepository->find($id);
        $forums = $this->forumRepository->findAll();
        $topics = $forum->getTopics();
        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumFrontController',
            'forum'=>$forum,
            'forums'=>$forums,
            'topics'=>$topics
        ]);
    }
    /**
     * @Route("/forum-topic/{id}", name="detail_topic")
     */
    public function detailTopic(int $id): Response
    {

        $topic = $this->topicRepository->find($id);
        $messages = $topic->getMessages();

        $forum = $this->forumRepository->find($id);
        $forums = $this->forumRepository->findAll();


        return $this->render('forum/detailTopic.html.twig', [
            'controller_name' => 'ForumFrontController',
            'forum'=>$forum,
            'topic'=>$topic,
            'messages'=>$messages,
            'forums'=>$forums,

        ]);
    }

}
