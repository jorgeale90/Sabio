<?php

namespace App\Controller;

use App\Entity\Nacionalidad;
use App\Form\NacionalidadType;
use App\Repository\NacionalidadRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/nacionalidad")
 */
class NacionalidadController extends AbstractController
{
    /**
     * @Route("/", name="nacionalidad_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(NacionalidadRepository $nacionalidadRepository): Response
    {
        return $this->render('nacionalidad/index.html.twig', [
            'nacionalidad' => $nacionalidadRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="nacionalidad_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entity = new Nacionalidad();
        $form = $this->createForm(NacionalidadType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Nacionalidad satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Nacionalidad: %s', $entity->getNombre()));

            return $this->redirectToRoute('nacionalidad_index');
        }

        return $this->render('nacionalidad/new.html.twig', [
            'entities' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="nacionalidad_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, Nacionalidad $entity): Response
    {
        $form = $this->createForm(NacionalidadType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Nacionalidad satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Nacionalidad: %s', $entity->getNombre()));

            return $this->redirectToRoute('nacionalidad_index');
        }

        return $this->render('nacionalidad/edit.html.twig', [
            'entities' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="nacionalidad_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Nacionalidad::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra esta Nacionalidad!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado una Nacionalidad satisfactoriamente!!!');
        }

        return $this->redirectToRoute('nacionalidad_index');
    }
}
