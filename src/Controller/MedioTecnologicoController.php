<?php

namespace App\Controller;

use App\Entity\MedioTecnologico;
use App\Form\MedioTecnologicoType;
use App\Repository\MedioTecnologicoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/mediotecnologico")
 */
class MedioTecnologicoController extends AbstractController
{
    /**
     * @Route("/", name="mediotecnologico_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(MedioTecnologicoRepository $mediotecnologicoRepository): Response
    {
        return $this->render('mediotecnologico/index.html.twig', [
            'mediotecn' => $mediotecnologicoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="mediotecnologico_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entity = new MedioTecnologico();
        $form = $this->createForm(MedioTecnologicoType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Medio Tecnológico satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Medio Tecnológico: %s', $entity->getNombreCompleto()));

            return $this->redirectToRoute('mediotecnologico_index');
        }

        return $this->render('mediotecnologico/new.html.twig', [
            'mediot' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="mediotecnologico_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, MedioTecnologico $entity): Response
    {
        $form = $this->createForm(MedioTecnologicoType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Medio Tecnológico satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Medio Tecnológico: %s', $entity->getNombreCompleto()));

            return $this->redirectToRoute('mediotecnologico_index');
        }

        return $this->render('mediotecnologico/edit.html.twig', [
            'mediotec' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/mediotecnologico/{id}", name="mediotecnologico_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(MedioTecnologico::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Medio Tecnológico!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Medio Tecnológico satisfactoriamente!!!');
        }

        return $this->redirectToRoute('mediotecnologico_index');
    }

    /**
     * @Route("/getmodeloxmarca", name="modelo_x_marca", methods={"GET","POST"})
     */
    public function getMarcaxModelo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $marca_id = $request->get('marca_id');
        $modelo = $em->getRepository('App:Modelo')->findByMarca($marca_id);
        return new JsonResponse($modelo);
    }
}