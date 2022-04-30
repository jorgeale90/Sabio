<?php

namespace App\Controller;

use App\Entity\EntradaSalidaEquipo;
use App\Form\EntradaSalidaEquipoType;
use App\Repository\EntradaSalidaEquipoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/entradasalidaequipo")
 */
class EntradaSalidaEquipoController extends AbstractController
{
    /**
     * @Route("/", name="entradasalidaequipo_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(EntradaSalidaEquipoRepository $entradaSalidaEquipoRepository): Response
    {
        return $this->render('entradasalidaequipo/index.html.twig', [
            'entradasalida' => $entradaSalidaEquipoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="entradasalidaequipo_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entity = new EntradaSalidaEquipo();
        $form = $this->createForm(EntradaSalidaEquipoType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Entrada/Salida de Equipo satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Entrada/Salida de Equipo: %s', $entity->getNumero()));

            return $this->redirectToRoute('entradasalidaequipo_index');
        }

        return $this->render('entradasalidaequipo/new.html.twig', [
            'entities' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="entradasalidaequipo_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, EntradaSalidaEquipo $entity): Response
    {
        $form = $this->createForm(EntradaSalidaEquipoType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Entrada/Salida de Equipo satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Entrada/Salida de Equipo: %s', $entity->getNumero()));

            return $this->redirectToRoute('entradasalidaequipo_index');
        }

        return $this->render('entradasalidaequipo/edit.html.twig', [
            'entities' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="entradasalidaequipo_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(EntradaSalidaEquipo::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra esta Entrada/Salida de Equipo!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado una Entrada/Salida de Equipo satisfactoriamente!!!');
        }

        return $this->redirectToRoute('entradasalidaequipo_index');
    }
}
