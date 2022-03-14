<?php

namespace App\Controller;

use App\Entity\OrganizacionPolitica;
use App\Form\OrganizacionPoliticaType;
use App\Repository\OrganizacionPoliticaRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/organizacionpolitica")
 */
class OrganizacionPoliticaController extends AbstractController
{
    /**
     * @Route("/", name="organizacionpolitica_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(OrganizacionPoliticaRepository $organizacionPoliticaRepository): Response
    {
        return $this->render('organizacionpolitica/index.html.twig', [
            'organizacionpol' => $organizacionPoliticaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="organizacionpolitica_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entity = new OrganizacionPolitica();
        $form = $this->createForm(OrganizacionPoliticaType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Organización Política satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Organización Política: %s', $entity->getNombre()));

            return $this->redirectToRoute('organizacionpolitica_index');
        }

        return $this->render('organizacionpolitica/new.html.twig', [
            'entities' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="organizacionpolitica_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, OrganizacionPolitica $entity): Response
    {
        $form = $this->createForm(OrganizacionPoliticaType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Organización Política satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Organización Política: %s', $entity->getNombre()));

            return $this->redirectToRoute('organizacionpolitica_index');
        }

        return $this->render('organizacionpolitica/edit.html.twig', [
            'entities' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="organizacionpolitica_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(OrganizacionPolitica::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra esta Organización Política!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado una Organización Política satisfactoriamente!!!');
        }

        return $this->redirectToRoute('organizacionpolitica_index');
    }
}