<?php

namespace App\Controller;

use App\Entity\Especialidad;
use App\Form\EspecialidadType;
use App\Repository\EspecialidadRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/especialidad")
 */
class EspecialidadController extends AbstractController
{
    /**
     * @Route("/", name="especialidad_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(EspecialidadRepository $especialidadRepository): Response
    {
        return $this->render('especialidad/index.html.twig', [
            'especialidad' => $especialidadRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="especialidad_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entity = new Especialidad();
        $form = $this->createForm(EspecialidadType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Especialidad satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Especialidad: %s', $entity->getNombre()));

            return $this->redirectToRoute('especialidad_index');
        }

        return $this->render('especialidad/new.html.twig', [
            'entities' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="especialidad_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, Especialidad $entity): Response
    {
        $form = $this->createForm(EspecialidadType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Especialidad satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Especialidad: %s', $entity->getNombre()));

            return $this->redirectToRoute('especialidad_index');
        }

        return $this->render('especialidad/edit.html.twig', [
            'entities' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="especialidad_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Especialidad::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra esta Especialidad!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado una Especialidad satisfactoriamente!!!');
        }

        return $this->redirectToRoute('especialidad_index');
    }
}
