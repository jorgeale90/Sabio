<?php

namespace App\Controller;

use App\Entity\Provincia;
use App\Form\ProvinciaType;
use App\Repository\ProvinciaRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/provincia")
 */
class ProvinciaController extends AbstractController
{
    /**
     * @Route("/", name="provincia_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(ProvinciaRepository $provinciaRepository): Response
    {
        return $this->render('provincia/index.html.twig', [
            'provincia' => $provinciaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="provincia_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $prov = new Provincia();
        $form = $this->createForm(ProvinciaType::class, $prov);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($prov);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Provincia satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Provincia: %s', $prov->getNombre()));

            return $this->redirectToRoute('provincia_index');
        }

        return $this->render('provincia/new.html.twig', [
            'prov' => $prov,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="provincia_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, Provincia $provincia): Response
    {
        $form = $this->createForm(ProvinciaType::class, $provincia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Provincia satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Provincia: %s', $provincia->getNombre()));

            return $this->redirectToRoute('provincia_index');
        }

        return $this->render('provincia/edit.html.twig', [
            'provi' => $provincia,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="provincia_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Provincia::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra esta Provincia!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado una Provincia satisfactoriamente!!!');
        }

        return $this->redirectToRoute('provincia_index');
    }
}
