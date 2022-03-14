<?php

namespace App\Controller;

use App\Entity\TipoMedio;
use App\Form\TipoMedioType;
use App\Repository\TipoMedioRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tipomedio")
 */
class TipoMedioController extends AbstractController
{
    /**
     * @Route("/", name="tipomedio_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(TipoMedioRepository $tipoMedioRepository): Response
    {
        return $this->render('tipomedio/index.html.twig', [
            'tipo' => $tipoMedioRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tipomedio_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entity = new TipoMedio();
        $form = $this->createForm(TipoMedioType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Tipo de Medio satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Tipo de Medio: %s', $entity->getNombre()));

            return $this->redirectToRoute('tipomedio_index');
        }

        return $this->render('tipomedio/new.html.twig', [
            'tipom' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tipomedio_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, TipoMedio $entity): Response
    {
        $form = $this->createForm(TipoMedioType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Tipo de Medio satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Tipo de Medio: %s', $entity->getNombre()));

            return $this->redirectToRoute('tipomedio_index');
        }

        return $this->render('tipomedio/edit.html.twig', [
            'tipom' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tipomedio_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(TipoMedio::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Tipo de Medio!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Tipo de Medio satisfactoriamente!!!');
        }

        return $this->redirectToRoute('tipomedio_index');
    }
}