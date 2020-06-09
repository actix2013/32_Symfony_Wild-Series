<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Route("/comment")
 */
class CommentController extends AbstractController
{
    /**
     * @Route("/", name="comment_index", methods={"GET"})
     * @IsGranted("ROLE_SUBSCRIBER")
     */
    public function index(CommentRepository $commentRepository): Response
    {
        return $this->render('comment/index.html.twig', [
            'comments' => $commentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="comment_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('comment_index');
        }

        return $this->render('comment/new.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="comment_show", methods={"GET"})
     * @IsGranted("ROLE_SUBSCRIBER")
     */
    public function show(Comment $comment): Response
    {
        return $this->render('comment/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="comment_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_SUBSCRIBER")
     */
    public function edit(Request $request, Comment $comment): Response
    {
        //todo implement test if comments is admin or is same author as logged user
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comment_index');
        }

        return $this->render('comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="comment_delete", methods={"DELETE"})
     * @IsGranted("ROLE_SUBSCRIBER")
     */
    public function delete(Request $request, Comment $comment): Response
    {
        $user = $this->getUser();
        $email = $comment->getAuthor()->getEmail();

        try {
            $this->denyAccessUnlessGranted(new Expression(
                    '"ROLE_ADMIN" in roles')
            );
        } catch (
        \Symfony\Component\Security\Core\Exception\AccessDeniedException $e) {
            if ($email === $user->getUsername()) {
                if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->remove($comment);
                    $entityManager->flush();
                }
            }
        }

        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('comment_index');
    }
}
