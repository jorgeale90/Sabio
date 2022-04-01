<?php

namespace App\Controller;

use App\Entity\PersonalMedico;
use App\Form\PersonalMedicoType;
use App\Repository\PersonalMedicoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/personalmedico")
 */
class PersonalMedicoController extends AbstractController
{
    /**
     * @Route("/", name="personalmedico_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(PersonalMedicoRepository $personalMedicoRepository): Response
    {
        return $this->render('personalmedico/index.html.twig', [
            'personalmedico' => $personalMedicoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="personalmedico_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entity = new PersonalMedico();
        $form = $this->createForm(PersonalMedicoType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Personal Médico satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Personal Médico: %s', $entity->getNombreCompleto()));

            return $this->redirectToRoute('personalmedico_index');
        }

        return $this->render('personalmedico/new.html.twig', [
            'personalmed' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="personalmedico_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, PersonalMedico $entity): Response
    {
        $form = $this->createForm(PersonalMedicoType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Personal Médico satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Personal Médico: %s', $entity->getNombreCompleto()));

            return $this->redirectToRoute('personalmedico_index');
        }

        return $this->render('personalmedico/edit.html.twig', [
            'personalme' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="personalmedico_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(PersonalMedico::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Personal Médico!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Personal Médico satisfactoriamente!!!');
        }

        return $this->redirectToRoute('personalmedico_index');
    }
}
