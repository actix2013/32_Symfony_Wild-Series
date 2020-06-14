<?php

namespace App\Controller;

use App\Entity\Program;
use App\Entity\Comment;
use App\Form\ProgramType;
use App\Repository\CommentRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Slugify;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


/**
 * @Route("/program")
 */
class ProgramController extends AbstractController
{
    /**
     * @Route("/", name="program_index", methods={"GET"})
     * @IsGranted("ROLE_SUBSCRIBER")
     */
    public function index(ProgramRepository $programRepository, SessionInterface $session): Response
    {
        //<editor-fold desc="code coller pour la quete sur les session">
        // cour sur les session dans symfony
        if (!$session->has('total')) {
            $session->set('total', 0); // if total doesn’t exist in session, it is initialized.
        }

        $total = $session->get('total');
        //</editor-fold>


        $programs = $programRepository->findAllWithCategoriesAndActors();
        return $this->render('program/index.html.twig', [
            //'programs' => $programRepository->findAllWithCategories(),
            'programs' => $programs,
        ]);
    }

    /**
     * @Route("/new", name="program_new", methods={"GET","POST"})
     */
    public function new(Request $request, MailerInterface $mailer, Slugify $slugify ): Response
    {

        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $slug = $slugify->generate($program->getTitle());
            $program->setSlug($slug);
            $entityManager->persist($program);
            $entityManager->flush();

            //<editor-fold desc="Gestion envoi de l'email">
            $this->addFlash('success', 'The new program has been created');
            $email = (new TemplatedEmail())
                ->from($this->getParameter("mailer_from"))
                ->to($this->getParameter("mailer_to"))
                ->subject('Une nouvelle série vient d\'être publiée !')
                // path of the Twig template to render
                ->htmlTemplate('emails/newprogram.html.twig')
                // pass variables (name => value) to the template
                ->context([
                    'expiration_date' => new \DateTime('+7 days'),
                    'username' => 'foo',
                    'program' => $program,
                ]);

            $mailer->send($email);
            //</editor-fold>

            // Once the form is submitted, valid and the data inserted in database, you can define the success flash message
            $this->addFlash('success', 'Email have been send.');
            return $this->redirectToRoute('program_index');
        }

        return $this->render('program/new.html.twig', [
            'program' => $program,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="program_show", methods={"GET"})
     */
    public function show(Program $program): Response
    {

        //<editor-fold desc="Methode  pour lire les objets via query symfony">
        $commentsRepository = null;
        $commentRepository = $this->getDoctrine()
            ->getRepository(Comment::class);
        $query = $commentRepository->createQueryBuilder('c')
            ->orderBy('c.id', 'ASC')
            ->getQuery();
        $comments = $query->setMaxResults(1000)->getResult();
        //</editor-fold>

        //$seasons = $program->getSeasons();

        return $this->render('program/show.html.twig', [
            'program' => $program,
            'comments' => $comments
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="program_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Program $program, Slugify $slugify): Response
    {        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugify->generate($program->getTitle());
            $program->setSlug($slug);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('program_index');
        }

        return $this->render('program/edit.html.twig', [
            'program' => $program,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="program_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Program $program): Response
    {
        if ($this->isCsrfTokenValid('delete'.$program->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($program);
            $entityManager->flush();
        }

        return $this->redirectToRoute('program_index');
    }
}
