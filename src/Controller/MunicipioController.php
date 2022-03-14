<?php

namespace App\Controller;

use App\Entity\Municipio;
use App\Form\MunicipioType;
use App\Repository\MunicipioRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/municipio")
 */
class MunicipioController extends AbstractController
{
    /**
     * @Route("/", name="municipio_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(MunicipioRepository $municipioRepository): Response
    {
        return $this->render('municipio/index.html.twig', [
            'municipios' => $municipioRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="municipio_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $muni = new Municipio();
        $form = $this->createForm(MunicipioType::class, $muni);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($muni);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Municipio satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Municipio: %s', $muni->getNombre()));

            return $this->redirectToRoute('municipio_index');
        }

        return $this->render('municipio/new.html.twig', [
            'muni' => $muni,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="municipio_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, Municipio $municipio): Response
    {
        $form = $this->createForm(MunicipioType::class, $municipio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Municipio satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Municipio: %s', $municipio->getNombre()));

            return $this->redirectToRoute('municipio_index');
        }

        return $this->render('municipio/edit.html.twig', [
            'municipio' => $municipio,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="municipio_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Municipio::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Municipio!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Municipio satisfactoriamente!!!');
        }

        return $this->redirectToRoute('municipio_index');
    }
}
