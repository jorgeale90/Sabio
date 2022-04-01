<?php

namespace App\Controller;

use App\Entity\Sexo;
use App\Form\SexoType;
use App\Repository\SexoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/sexo")
 */
class SexoController extends AbstractController
{
    /**
     * @Route("/", name="sexo_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(SexoRepository $sexoRepository): Response
    {
        return $this->render('sexo/index.html.twig', [
            'sex' => $sexoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sexo_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entity = new Sexo();
        $form = $this->createForm(SexoType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Sexo satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Sexo: %s', $entity->getNombre()));

            return $this->redirectToRoute('sexo_index');
        }

        return $this->render('sexo/new.html.twig', [
            'sex' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sexo_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, Sexo $entity): Response
    {
        $form = $this->createForm(SexoType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Sexo satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Sexo: %s', $entity->getNombre()));

            return $this->redirectToRoute('sexo_index');
        }

        return $this->render('sexo/edit.html.twig', [
            'sex' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sexo_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Sexo::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Sexo!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Sexo satisfactoriamente!!!');
        }

        return $this->redirectToRoute('sexo_index');
    }
}
