<?php

namespace App\Controller;

use App\Entity\PostCategory;
use App\Form\PostCategoryType;
use App\Repository\PostCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPostCategoryController extends AbstractController
{
    /**
     * @var PostCategoryRepository
     */
    private $postCategoryRepository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * AdminPostCategoryController constructor.
     * @param PostCategoryRepository $postCategoryRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(PostCategoryRepository $postCategoryRepository, EntityManagerInterface $em)
    {
        $this->postCategoryRepository = $postCategoryRepository;
        $this->em = $em;
    }

    /**
     * @Route("/admin", name="home_admin")
     */
    public function indexAdmin(): Response
    {
        return $this->render('home/indexAdmin.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/admin/list_category", name="list_category")
     */
    public function allCategory(): Response
    {
        $postCategories = $this->postCategoryRepository->findAll();

        return $this->render('postCategory/listPostCategory.html.twig', [
            'controller_name' => 'HomeController',
            'postCategories'=>$postCategories
        ]);
    }


    /**
     * @Route("/admin/create_category", name="create_category")
     * @param Request $request
     * @return Response
     */
    public function createPostCategory(Request $request): Response
    {
        $categoryEntity = new PostCategory();
        $form = $this->createForm(PostCategoryType::class,$categoryEntity);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($categoryEntity);
            $this->em->flush();
            return $this->redirectToRoute('list_category');
        }


        return $this->render('postCategory/createPostCategory.html.twig', [
            'controller_name' => 'HomeController',
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/admin/edit_category/{id}", name="edit_category")
     */
    public function editAnimal(Request $request,$id): Response
    {
        $postEntity = $this->postCategoryRepository->find($id);
        $form = $this->createForm(PostCategoryType::class,$postEntity);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($postEntity);
            $this->em->flush();
            return $this->redirectToRoute('list_category');
        }


        // $hasAccess = $this->isGranted("ROLE_ADMIN");
        return $this->render('postCategory/editPostCategory.html.twig', [
            'controller_name' => 'AdminAnimalController',
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/admin/delete_category/{id}", name="delete_category")
     */
    public function deleteCategory($id): Response
    {
        $postEntity = $this->postCategoryRepository->find($id);
            $this->em->remove($postEntity);
            $this->em->flush();



        // $hasAccess = $this->isGranted("ROLE_ADMIN");
        return $this->redirectToRoute('list_category');



    }
}
