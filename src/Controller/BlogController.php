<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Blog;
use App\Form\BlogType;
use App\Repository\BlogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/blog')]
class BlogController extends AbstractController
{
    /*
    #[Route('/', name: 'blog')]
    public function index(): Response
    {
        return $this->redirectToRoute('Blog_index');
    }
    */


    #[Route('/', name: 'Blog_index')]
    public function index(BlogRepository $BlogRepository): Response
    {
        return $this->render('blog/index.html.twig', [
            'Blogs' => $BlogRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'Blog_delete', methods: ['POST'])]
    public function delete(Request $request, Blog $Blog, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$Blog->getId(), $request->request->get('_token'))) {
            $entityManager->remove($Blog);
            $entityManager->flush();
        }

        return $this->redirectToRoute('Blog_index', [], Response::HTTP_SEE_OTHER);
    }
}
