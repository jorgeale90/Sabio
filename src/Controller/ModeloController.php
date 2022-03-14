<?php

namespace App\Controller;

use App\Entity\Modelo;
use App\Form\ModeloType;
use App\Repository\ModeloRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/modelo")
 */
class ModeloController extends AbstractController
{
    /**
     * @Route("/", name="modelo_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(ModeloRepository $modeloRepository): Response
    {
        return $this->render('modelo/index.html.twig', [
            'modelo' => $modeloRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="modelo_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entity = new Modelo();
        $form = $this->createForm(ModeloType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Modelo satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Modelo: %s', $entity->getNombre()));

            return $this->redirectToRoute('modelo_index');
        }

        return $this->render('modelo/new.html.twig', [
            'entities' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="modelo_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, Modelo $entity): Response
    {
        $form = $this->createForm(ModeloType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Modelo satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Modelo: %s', $entity->getNombre()));

            return $this->redirectToRoute('modelo_index');
        }

        return $this->render('modelo/edit.html.twig', [
            'entities' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="modelo_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Modelo::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Modelo!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Modelo satisfactoriamente!!!');
        }

        return $this->redirectToRoute('modelo_index');
    }
}