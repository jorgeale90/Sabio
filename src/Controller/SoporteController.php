<?php

namespace App\Controller;

use App\Entity\Soporte;
use App\Form\SoporteType;
use App\Repository\SoporteRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/soporte")
 */
class SoporteController extends AbstractController
{
    /**
     * @Route("/", name="soporte_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(SoporteRepository $soporteRepository): Response
    {
        return $this->render('soporte/index.html.twig', [
            'soporte' => $soporteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="soporte_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entity = new Soporte();
        $form = $this->createForm(SoporteType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Registro de Conrol de Soporte satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Soporte: %s', $entity->getNumero()));

            return $this->redirectToRoute('soporte_index');
        }

        return $this->render('soporte/new.html.twig', [
            'soporte' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="soporte_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, Soporte $entity): Response
    {
        $form = $this->createForm(SoporteType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Registro de Control de Soporte satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Soporte: %s', $entity->getNumero()));

            return $this->redirectToRoute('soporte_index');
        }

        return $this->render('soporte/edit.html.twig', [
            'soporte' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="soporte_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Soporte::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Soporte!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Soporte satisfactoriamente!!!');
        }

        return $this->redirectToRoute('soporte_index');
    }
}
