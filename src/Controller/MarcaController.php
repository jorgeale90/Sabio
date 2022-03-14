<?php

namespace App\Controller;

use App\Entity\Marca;
use App\Form\MarcaType;
use App\Repository\MarcaRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/marca")
 */
class MarcaController extends AbstractController
{
    /**
     * @Route("/", name="marca_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(MarcaRepository $marcaRepository): Response
    {
        return $this->render('marca/index.html.twig', [
            'marca' => $marcaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="marca_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entity = new Marca();
        $form = $this->createForm(MarcaType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Marca satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Marca: %s', $entity->getNombre()));

            return $this->redirectToRoute('marca_index');
        }

        return $this->render('marca/new.html.twig', [
            'entities' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="marca_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, Marca $entity): Response
    {
        $form = $this->createForm(MarcaType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Marca satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Marca: %s', $entity->getNombre()));

            return $this->redirectToRoute('marca_index');
        }

        return $this->render('marca/edit.html.twig', [
            'entities' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="marca_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Marca::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra esta Marca!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado una Marca satisfactoriamente!!!');
        }

        return $this->redirectToRoute('marca_index');
    }
}