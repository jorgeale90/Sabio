<?php

namespace App\Controller;

use App\Entity\AuditoriaInterna;
use App\Form\AuditoriaInternaType;
use App\Repository\AuditoriaInternaRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/auditoriainterna")
 */
class AuditoriaInternaController extends AbstractController
{
    /**
     * @Route("/", name="auditoriainterna_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(AuditoriaInternaRepository $auditoriaInternaRepository): Response
    {
        return $this->render('auditoriainterna/index.html.twig', [
            'auditoria' => $auditoriaInternaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="auditoriainterna_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entity = new AuditoriaInterna();
        $form = $this->createForm(AuditoriaInternaType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Auditoría Interna satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Auditoría Interna: %s', $entity->getNoidentificacion()));

            return $this->redirectToRoute('auditoriainterna_index');
        }

        return $this->render('auditoriainterna/new.html.twig', [
            'entities' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="auditoriainterna_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, AuditoriaInterna $entity): Response
    {
        $form = $this->createForm(AuditoriaInternaType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Auditoría Interna satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Auditoría Interna: %s', $entity->getNoidentificacion()));

            return $this->redirectToRoute('auditoriainterna_index');
        }

        return $this->render('auditoriainterna/edit.html.twig', [
            'entities' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="auditoriainterna_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(AuditoriaInterna::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra esta Auditoría Interna!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado una Auditoría Interna satisfactoriamente!!!');
        }

        return $this->redirectToRoute('auditoriainterna_index');
    }
}
