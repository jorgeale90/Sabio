<?php

namespace App\Controller;

use App\Entity\DireccionamientoIP;
use App\Form\DireccionamientoIPType;
use App\Repository\DireccionamientoIPRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/direccionamientoip")
 */
class DireccionamientoIPController extends AbstractController
{
    /**
     * @Route("/", name="direccionamientoip_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(DireccionamientoIPRepository $direccionamientoIPRepository): Response
    {
        return $this->render('direccionamientoip/index.html.twig', [
            'direccion' => $direccionamientoIPRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="direccionamientoip_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entities = new DireccionamientoIP();
        $form = $this->createForm(DireccionamientoIPType::class, $entities);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entities);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Direccionamiento IP satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Direccionamiento IP: %s', $entities->getNombreCompleto()));

            return $this->redirectToRoute('direccionamientoip_index');
        }

        return $this->render('direccionamientoip/new.html.twig', [
            'direccion' => $entities,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="direccionamientoip_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, DireccionamientoIP $direccionamientoIP, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DireccionamientoIPType::class, $direccionamientoIP);
        $form->handleRequest($request);

        $original = new ArrayCollection();
        foreach ($direccionamientoIP->getTablaip() as $tabla) {
            $original->add($tabla);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            // Eliminar la relacion
            foreach ($original as $tabla) {
                if (false === $direccionamientoIP->getTablaip()->contains($tabla)) {
                    // Eliminar TablaIP para el Direccionamiento
                    $entityManager->persist($tabla);
                    // Elimino la TablaIP por completo
                    $entityManager->remove($tabla);
                }
            }

            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Direccionamiento IP satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Direccionamiento IP: %s', $direccionamientoIP->getNombreCompleto()));

            return $this->redirectToRoute('direccionamientoip_index');
        }

        return $this->render('direccionamientoip/edit.html.twig', [
            'direccion' => $direccionamientoIP,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="direccionamientoip_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(DireccionamientoIP::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Direccionamiento IP!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Direccionamiento IP satisfactoriamente!!!');
        }

        return $this->redirectToRoute('direccionamientoip_index');
    }

    /**
     * @Route("/getmunicipioipxprovinciaip", name="municipioip_x_provinciaip", methods={"GET","POST"})
     */
    public function getMunicipioipxProvinciaip(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $provincia_id = $request->get('provincia_id');
        $municipio = $em->getRepository('App:Municipio')->findByProvinciaip($provincia_id);
        return new JsonResponse($municipio);
    }

    /**
     * @Route("/getinstitucionipxmunicipioip", name="institucionip_x_municipioip", methods={"GET","POST"})
     */
    public function getInstitucionipxMunicipioip(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $municipio_id = $request->get('municipio_id');
        $institucion = $em->getRepository('App:Institucion')->findByMunicipioip($municipio_id);
        return new JsonResponse($institucion);
    }
}
