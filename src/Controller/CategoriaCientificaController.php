<?php

namespace App\Controller;

use App\Entity\CategoriaCientifica;
use App\Form\CategoriaCientificaType;
use App\Repository\CategoriaCientificaRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/categoriacientifica")
 */
class CategoriaCientificaController extends AbstractController
{
    /**
     * @Route("/", name="categoriacientifica_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(CategoriaCientificaRepository $categoriaCientificaRepository): Response
    {
        return $this->render('categoriacientifica/index.html.twig', [
            'categoriacientifica' => $categoriaCientificaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="categoriacientifica_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entity = new CategoriaCientifica();
        $form = $this->createForm(CategoriaCientificaType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Categoría Científica satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Categoría Científica: %s', $entity->getNombre()));

            return $this->redirectToRoute('categoriacientifica_index');
        }

        return $this->render('categoriacientifica/new.html.twig', [
            'entities' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categoriacientifica_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, CategoriaCientifica $entity): Response
    {
        $form = $this->createForm(CategoriaCientificaType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Categoría Científica satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Categoría Científica: %s', $entity->getNombre()));

            return $this->redirectToRoute('categoriacientifica_index');
        }

        return $this->render('categoriacientifica/edit.html.twig', [
            'entities' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categoriacientifica_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(CategoriaCientifica::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra esta Categoría Científica!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado una Categoría Científica satisfactoriamente!!!');
        }

        return $this->redirectToRoute('categoriacientifica_index');
    }
}
