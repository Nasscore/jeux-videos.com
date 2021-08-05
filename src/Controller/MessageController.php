<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\Message1Type;
use App\Repository\ForumRepository;
use App\Repository\MessageRepository;
use App\Repository\TopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/message")
 */
class MessageController extends AbstractController
{
    /**
     * @var TopicRepository
     */
    private $topicRepository;
    /**
     * @var MessageRepository
     */
    private $messageRepository;
    /**
     * @var ForumRepository
     */
    private $forumRepository;


//    /**
//     * @Route("/", name="message_index", methods={"GET"})
//     */
//    public function index(MessageRepository $messageRepository): Response
//    {
//        return $this->render('message/index.html.twig', [
//            'messages' => $messageRepository->findAll(),
//        ]);
//    }
    /**
     * MessageController constructor.
     * @param TopicRepository $topicRepository
     * @param MessageRepository $messageRepository
     * @param ForumRepository $forumRepository
     */
    public function __construct(TopicRepository $topicRepository, MessageRepository $messageRepository, ForumRepository $forumRepository)
    {
        $this->topicRepository = $topicRepository;
        $this->messageRepository = $messageRepository;
        $this->forumRepository = $forumRepository;
    }


    /**
     * @Route("/new/{id}", name="message_new", methods={"GET","POST"})
     */
    public function new(Request $request,int $id): Response
    {

        $message = new Message();

        $forums = $this->forumRepository->findAll();
        $topic = $this->topicRepository->find($id);
        $messages = $topic->getMessages();
        $forum = $this->forumRepository->find($id);
        $form = $this->createForm(Message1Type::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setTopics($topic);
            $message->setUser($this->getUser());
            $message->setCreatedAt(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->renderForm('message/new.html.twig', [
            'message' => $message,
            'form' => $form,
            'topic'=>$topic,
            'forum'=>$forum,
            'forums'=>$forums

        ]);
    }

//    /**
//     * @Route("/{id}", name="message_show", methods={"GET"})
//     */
//    public function show(Message $message): Response
//    {
//        return $this->render('message/show.html.twig', [
//            'message' => $message,
//        ]);
//    }
//
    /**
     * @Route("/{id}/edit", name="message_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Message $message): Response
    {
        $form = $this->createForm(Message1Type::class, $message);
        $form->handleRequest($request);
        $messageEdit = $message->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home');
        }

        return $this->renderForm('message/edit.html.twig', [
            'message' => $message,
            'form' => $form,
            'idMessage'=>$messageEdit
        ]);
    }
//
    /**
     * @Route("/{id}/delete", name="message_delete")
     */
    public function delete(Request $request, Message $message): Response
    {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($message);
            $entityManager->flush();



        return $this->redirectToRoute('detail_topic',['id'=>$message->getTopics()->getId()]);
    }
}
