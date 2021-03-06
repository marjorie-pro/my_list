<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Form\TacheType;
use App\Repository\TacheRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/")
 */
class TacheController extends AbstractController
{
    /**
     * @Route("/", name="tache_index", methods={"GET"})
     */
    public function index(Request $request,TacheRepository $tacheRepository,  PaginatorInterface $paginator): Response
    {

        $donnees = $this->getDoctrine()->getRepository(Tache::class)->findBy([],['createdAt' => 'desc']);

        $taches = $paginator->paginate($donnees, $request->query->getInt('page', 1), 5
        );


        return $this->render('tache/index.html.twig', [
            'taches' => $taches,
        ]);
    }

    /**
     * @Route("/new", name="tache_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tache = new Tache();
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tache);
            $entityManager->flush();

            return $this->redirectToRoute('tache_index');
        }

        return $this->render('tache/new.html.twig', [
            'tache' => $tache,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tache_show", methods={"GET"})
     */
    public function show(Tache $tache): Response
    {
        return $this->render('tache/show.html.twig', [
            'tache' => $tache,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tache_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tache $tache): Response
    {
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tache_index');
        }

        return $this->render('tache/edit.html.twig', [
            'tache' => $tache,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tache_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tache $tache): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tache->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tache);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tache_index');
    }
}
