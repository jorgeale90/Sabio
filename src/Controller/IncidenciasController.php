<?php

namespace App\Controller;

use App\Entity\Incidencias;
use App\Form\IncidenciasType;
use App\Repository\IncidenciasRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/incidencias")
 */
class IncidenciasController extends AbstractController
{
    /**
     * @Route("/", name="incidencias_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(IncidenciasRepository $incidenciasRepository): Response
    {
        return $this->render('incidencias/index.html.twig', [
            'incidencias' => $incidenciasRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="incidencias_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entity = new Incidencias();
        $form = $this->createForm(IncidenciasType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Incidencias satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Incidencias: %s', $entity->getNumero()));

            return $this->redirectToRoute('incidencias_index');
        }

        return $this->render('incidencias/new.html.twig', [
            'entities' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="incidencias_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, Incidencias $entity): Response
    {
        $form = $this->createForm(IncidenciasType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Incidencias satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Incidencias: %s', $entity->getNumero()));

            return $this->redirectToRoute('incidencias_index');
        }

        return $this->render('incidencias/edit.html.twig', [
            'entities' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="incidencias_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Incidencias::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra esta Incidencias!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado una Incidencias satisfactoriamente!!!');
        }

        return $this->redirectToRoute('incidencias_index');
    }
}
