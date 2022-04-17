<?php

namespace App\Controller;

use App\Entity\ContratoCorreo;
use App\Form\ContratoCorreoType;
use App\Repository\ContratoCorreoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/contratocorreo")
 */
class ContratoCorreoController extends AbstractController
{
    /**
     * @Route("/", name="contratocorreo_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(ContratoCorreoRepository $contratoCorreoRepository): Response
    {
        return $this->render('contratocorreo/index.html.twig', [
            'contrato' => $contratoCorreoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="contratocorreo_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entity = new ContratoCorreo();
        $form = $this->createForm(ContratoCorreoType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Contrato de Correo satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Contrato de Correo: %s', $entity->getNombreCompleto()));

            return $this->redirectToRoute('contratocorreo_index');
        }

        return $this->render('contratocorreo/new.html.twig', [
            'contrato' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contratocorreo_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, ContratoCorreo $entity): Response
    {
        $form = $this->createForm(ContratoCorreoType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Contrato de Correo satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Contrato de Correo: %s', $entity->getNombreCompleto()));

            return $this->redirectToRoute('contratocorreo_index');
        }

        return $this->render('contratocorreo/edit.html.twig', [
            'contrato' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contratocorreo_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(ContratoCorreo::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Contrato de Correo!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Contrato de Correo satisfactoriamente!!!');
        }

        return $this->redirectToRoute('contratocorreo_index');
    }
}
