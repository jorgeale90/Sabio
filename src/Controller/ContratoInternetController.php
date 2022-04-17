<?php

namespace App\Controller;

use App\Entity\ContratoAnclaje;
use App\Form\ContratoAnclajeType;
use App\Repository\ContratoAnclajeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/contratoanclaje")
 */
class ContratoAnclajeController extends AbstractController
{
    /**
     * @Route("/", name="contratoanclaje_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(ContratoAnclajeRepository $contratoAnclajeRepository): Response
    {
        return $this->render('contratoanclaje/index.html.twig', [
            'contrato' => $contratoAnclajeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="contratoanclaje_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entity = new ContratoAnclaje();
        $form = $this->createForm(ContratoAnclajeType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Contrato de Anclaje satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Contrato de Anclaje: %s', $entity->getNombreCompleto()));

            return $this->redirectToRoute('contratoanclaje_index');
        }

        return $this->render('contratoanclaje/new.html.twig', [
            'contrato' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contratoanclaje_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, ContratoAnclaje $entity): Response
    {
        $form = $this->createForm(ContratoAnclajeType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Contrato de Anclaje satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Contrato de Anclaje: %s', $entity->getNombreCompleto()));

            return $this->redirectToRoute('contratoanclaje_index');
        }

        return $this->render('contratoanclaje/edit.html.twig', [
            'contrato' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contratoanclaje_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(ContratoAnclaje::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Contrato de Anclaje!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Contrato de Aclaje satisfactoriamente!!!');
        }

        return $this->redirectToRoute('contratoanclaje_index');
    }
}
