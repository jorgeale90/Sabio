<?php

namespace App\Controller;

use App\Entity\MantenimientoReparacion;
use App\Form\MantenimientoReparacionType;
use App\Repository\MantenimientoReparacionRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/mantenimientoreparacion")
 */
class MantenimientoReparacionController extends AbstractController
{
    /**
     * @Route("/", name="mantenimiento_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(MantenimientoReparacionRepository $mantenimientoReparacionRepository): Response
    {
        return $this->render('mantenimiento/index.html.twig', [
            'mantenimiento' => $mantenimientoReparacionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="mantenimiento_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entities = new MantenimientoReparacion();
        $form = $this->createForm(MantenimientoReparacionType::class, $entities);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entities);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Mantenimiento Reparación satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Mantenimiento Reparación: %s', $entities->getNumero()));

            return $this->redirectToRoute('mantenimiento_index');
        }

        return $this->render('mantenimiento/new.html.twig', [
            'mantenimiento' => $entities,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="mantenimiento_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, MantenimientoReparacion $mantenimientoReparacion): Response
    {
        $form = $this->createForm(MantenimientoReparacionType::class, $mantenimientoReparacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Mantenimiento Reparación satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Mantenimiento Reparación: %s', $mantenimientoReparacion->getNumero()));

            return $this->redirectToRoute('mantenimiento_index');
        }

        return $this->render('mantenimiento/edit.html.twig', [
            'mantenimiento' => $mantenimientoReparacion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="mantenimiento_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(MantenimientoReparacion::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Mantenimiento Reparación!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Mantenimiento Reparación satisfactoriamente!!!');
        }

        return $this->redirectToRoute('mantenimiento_index');
    }

    /**
     * @Route("/getmunicipiomrxprovinciamr", name="municipiomr_x_provinciamr", methods={"GET","POST"})
     */
    public function getMunicipiomrxProvinciamr(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $provincia_id = $request->get('provincia_id');
        $municipio = $em->getRepository('App:Municipio')->findByProvinciamr($provincia_id);
        return new JsonResponse($municipio);
    }

    /**
     * @Route("/getinstitucionmrxmunicipiomr", name="institucionmr_x_municipiomr", methods={"GET","POST"})
     */
    public function getInstitucionmrxMunicipiomr(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $municipio_id = $request->get('municipio_id');
        $institucion = $em->getRepository('App:Institucion')->findByMunicipiomr($municipio_id);
        return new JsonResponse($institucion);
    }
}
