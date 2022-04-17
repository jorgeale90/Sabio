<?php

namespace App\Controller;

use App\Entity\ContratoInternet;
use App\Form\ContratoInternetType;
use App\Repository\ContratoInternetRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/contratointernet")
 */
class ContratoInternetController extends AbstractController
{
    /**
     * @Route("/", name="contratointernet_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(ContratoInternetRepository $contratoInternetRepository): Response
    {
        return $this->render('contratointernet/index.html.twig', [
            'contrato' => $contratoInternetRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="contratointernet_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entity = new ContratoInternet();
        $form = $this->createForm(ContratoInternetType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Contrato de Internet satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Contrato de Internet: %s', $entity->getNombreCompleto()));

            return $this->redirectToRoute('contratointernet_index');
        }

        return $this->render('contratointernet/new.html.twig', [
            'contrato' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contratointernet_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, ContratoInternet $entity): Response
    {
        $form = $this->createForm(ContratoInternetType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Contrato de Internet satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Contrato de Internet: %s', $entity->getNombreCompleto()));

            return $this->redirectToRoute('contratointernet_index');
        }

        return $this->render('contratointernet/edit.html.twig', [
            'contrato' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="contratointernet_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(ContratoInternet::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Contrato de Internet!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Contrato de Internet satisfactoriamente!!!');
        }

        return $this->redirectToRoute('contratointernet_index');
    }

    /**
     * @Route("/getmunicipiocixprovinciaci", name="municipioci_x_provinciaci", methods={"GET","POST"})
     */
    public function getMunicipiocixProvinciaci(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $provincia_id = $request->get('provincia_id');
        $muni = $em->getRepository('App:Municipio')->findByProvinciaci($provincia_id);
        return new JsonResponse($muni);
    }

    /**
     * @Route("/getinstitucioncixmunicipioci", name="institucionci_x_municipioci", methods={"GET","POST"})
     */
    public function getInstitucionxMunicipioci(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $municipio_id = $request->get('municipio_id');
        $institucion = $em->getRepository('App:Institucion')->findByMunicipioci($municipio_id);
        return new JsonResponse($institucion);
    }
}
