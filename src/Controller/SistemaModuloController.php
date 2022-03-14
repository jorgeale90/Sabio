<?php

namespace App\Controller;

use App\Entity\SistemaModulo;
use App\Form\SistemaModuloType;
use App\Repository\SistemaModuloRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/sistemamodulo")
 */
class SistemaModuloController extends AbstractController
{
    /**
     * @Route("/", name="sistemamodulo_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(SistemaModuloRepository $sistemaModuloRepository): Response
    {
        return $this->render('sistemamodulo/index.html.twig', [
            'sistemamodulo' => $sistemaModuloRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sistemamodulo_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entity = new SistemaModulo();
        $form = $this->createForm(SistemaModuloType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Sistema de Módulo satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Sistema de Módulo: %s', $entity->getNombre()));

            return $this->redirectToRoute('sistemamodulo_index');
        }

        return $this->render('sistemamodulo/new.html.twig', [
            'sistemamod' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sistemamodulo_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, SistemaModulo $entity): Response
    {
        $form = $this->createForm(SistemaModuloType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Sistema de Módulo satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Sistema de Módulo: %s', $entity->getNombre()));

            return $this->redirectToRoute('sistemamodulo_index');
        }

        return $this->render('sistemamodulo/edit.html.twig', [
            'sistemmod' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sistemamodulo_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(SistemaModulo::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Sistema de Módulo!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Sistema de Módulo satisfactoriamente!!!');
        }

        return $this->redirectToRoute('sistemamodulo_index');
    }
}