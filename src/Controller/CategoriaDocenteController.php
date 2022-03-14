<?php

namespace App\Controller;

use App\Entity\CategoriaDocente;
use App\Form\CategoriaDocenteType;
use App\Repository\CategoriaDocenteRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/categoriadocente")
 */
class CategoriaDocenteController extends AbstractController
{
    /**
     * @Route("/", name="categoriadocente_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(CategoriaDocenteRepository $categoriaDocenteRepository): Response
    {
        return $this->render('categoriadocente/index.html.twig', [
            'categoriadocente' => $categoriaDocenteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="categoriadocente_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entity = new CategoriaDocente();
        $form = $this->createForm(CategoriaDocenteType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Categoría Docente satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Categoría Docente: %s', $entity->getNombre()));

            return $this->redirectToRoute('categoriadocente_index');
        }

        return $this->render('categoriadocente/new.html.twig', [
            'entities' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categoriadocente_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, CategoriaDocente $entity): Response
    {
        $form = $this->createForm(CategoriaDocenteType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Categoría Docente satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Categoría Docente: %s', $entity->getNombre()));

            return $this->redirectToRoute('categoriadocente_index');
        }

        return $this->render('categoriadocente/edit.html.twig', [
            'entities' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categoriadocente_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(CategoriaDocente::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra esta Categoría Docente!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado una Categoría Docente satisfactoriamente!!!');
        }

        return $this->redirectToRoute('categoriadocente_index');
    }
}
