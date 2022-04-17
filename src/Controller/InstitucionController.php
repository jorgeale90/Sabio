<?php

namespace App\Controller;

use App\Entity\Institucion;
use App\Form\InstitucionType;
use App\Repository\InstitucionRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/institucion")
 */
class InstitucionController extends AbstractController
{
    /**
     * @Route("/", name="institucion_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(InstitucionRepository $institucionRepository): Response
    {
        return $this->render('institucion/index.html.twig', [
            'institucion' => $institucionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="institucion_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entity = new Institucion();
        $form = $this->createForm(InstitucionType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Institución satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Institución: %s', $entity->getNombre()));

            return $this->redirectToRoute('institucion_index');
        }

        return $this->render('institucion/new.html.twig', [
            'institucion' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="institucion_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, Institucion $entity): Response
    {
        $form = $this->createForm(InstitucionType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Institución satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Institución: %s', $entity->getNombre()));

            return $this->redirectToRoute('institucion_index');
        }

        return $this->render('institucion/edit.html.twig', [
            'institucion' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/institucion/{id}", name="institucion_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Institucion::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra esta Institución!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado una Institución satisfactoriamente!!!');
        }

        return $this->redirectToRoute('institucion_index');
    }

    /**
     * @Route("/getmunicipioxprovincia", name="municipio_x_provincia", methods={"GET","POST"})
     */
    public function getMunicipioxProvincia(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $provincia_id = $request->get('provincia_id');
        $muni = $em->getRepository('App:Municipio')->findByProvincia($provincia_id);
        return new JsonResponse($muni);
    }
}
