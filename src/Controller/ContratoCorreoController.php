<?php

namespace App\Controller;

use App\Entity\Cargo;
use App\Form\CargoType;
use App\Repository\CargoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/cargo")
 */
class CargoController extends AbstractController
{
    /**
     * @Route("/", name="cargo_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(CargoRepository $cargoRepository): Response
    {
        return $this->render('cargo/index.html.twig', [
            'cargo' => $cargoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="cargo_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entity = new Cargo();
        $form = $this->createForm(CargoType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Cargo satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Cargo: %s', $entity->getNombre()));

            return $this->redirectToRoute('cargo_index');
        }

        return $this->render('cargo/new.html.twig', [
            'carg' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cargo_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, Cargo $entity): Response
    {
        $form = $this->createForm(CargoType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Cargo satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Cargo: %s', $entity->getNombre()));

            return $this->redirectToRoute('cargo_index');
        }

        return $this->render('cargo/edit.html.twig', [
            'carg' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cargo_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Cargo::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Cargo!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Cargo satisfactoriamente!!!');
        }

        return $this->redirectToRoute('cargo_index');
    }
}
