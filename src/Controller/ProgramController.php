<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use App\Entity\Comment;
use App\Form\ProgramType;
use App\Entity\User;
use App\Repository\CommentRepository;
use App\Repository\ProgramRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     * @IsGranted("ROLE_USER")
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
    public function new(Request $request, MailerInterface $mailer, Slugify $slugify): Response
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
     * @Route("/cat/{id}<[0-9]{1,6}>", name="program_bycat", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_ANONYMOUSLY")
     */
    public function categoryProgram(Category $category, ProgramRepository $programRepository): Response
    {

        $programs = $programRepository->findAllByCategoryWithActors($category);
        return $this->render('program/index.html.twig', [
            //'programs' => $programRepository->findAllWithCategories(),
            'programs' => $programs,
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
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Program $program, Slugify $slugify): Response
    {
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugify->generate($program->getTitle());
            $program->setSlug($slug);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'The program has been updated');
            return $this->redirectToRoute('program_index');
        }

        return $this->render('program/edit.html.twig', [
            'program' => $program,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="program_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Program $program): Response
    {
        if ($this->isCsrfTokenValid('delete' . $program->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($program);
            $entityManager->flush();
            $this->addFlash('danger', 'The program has been delated');
        }

        return $this->redirectToRoute('program_index');
    }

    /**
     * @Route("/{id}/wtachlist", name="program_watchlist", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function addWatchList(Request $request, Program $program, EntityManagerInterface $manager)
    {
        $user = $this->getUser();
        if($user->getWatchlist()->contains($program)) {
            $user->removeWatchlist($program);//remove
        }else {
            $user->addWatchlist($program);
        }
        $manager->flush();
        return $this->json([
            'isInWatchlist' => $this->getUser()->isInWatchlist($program)
        ]);
    }


}
