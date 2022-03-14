<?php

namespace App\Controller;

use App\Entity\SistemaContable;
use App\Form\SistemaContableType;
use App\Repository\SistemaContableRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/sistemacontable")
 */
class SistemaContableController extends AbstractController
{
    /**
     * @Route("/", name="sistemacontable_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(SistemaContableRepository $sistemaContableRepository): Response
    {
        return $this->render('sistemacontable/index.html.twig', [
            'sistemacontable' => $sistemaContableRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sistemacontable_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entity = new SistemaContable();
        $form = $this->createForm(SistemaContableType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Sistema Contable satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Sistema Contable: %s', $entity->getCodigo()));

            return $this->redirectToRoute('sistemacontable_index');
        }

        return $this->render('sistemacontable/new.html.twig', [
            'sistemacont' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sistemacontable_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, SistemaContable $entity): Response
    {
        $form = $this->createForm(SistemaContableType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Sistema Contable satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Sistema Contable: %s', $entity->getCodigo()));

            return $this->redirectToRoute('sistemacontable_index');
        }

        return $this->render('sistemacontable/edit.html.twig', [
            'sistemcont' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sistemacontable_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(SistemaContable::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Sistema Contable!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Sistema Contable satisfactoriamente!!!');
        }

        return $this->redirectToRoute('sistemacontable_index');
    }
}