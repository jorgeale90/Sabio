<?php

namespace App\Controller;

use App\Entity\ContratoCorreo;
use App\Form\ContratoCorreoType;
use App\Repository\ContratoCorreoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/contratocorreo")
 */
class ContratoCorreoController extends AbstractController
{
    /**
     * @Route("/", name="contratocorreo_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(ContratoCorreoRepository $contratoCorreoRepository): Response
    {
        return $this->render('contratocorreo/index.html.twig', [
            'contrato' => $contratoCorreoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="contratocorreo_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entity = new ContratoCorreo();
        $form = $this->createForm(ContratoCorreoType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $entity->setUser($user);
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Contrato de Correo satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Contrato de Correo: %s', $entity->getNombreCompleto()));

            return $this->redirectToRoute('contratocorreo_index');
        }

        return $this->render('contratocorreo/new.html.twig', [
            'contrato' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contratocorreo_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, ContratoCorreo $entity): Response
    {
        $form = $this->createForm(ContratoCorreoType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $entity->setUser($user);
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Contrato de Correo satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Contrato de Correo: %s', $entity->getNombreCompleto()));

            return $this->redirectToRoute('contratocorreo_index');
        }

        return $this->render('contratocorreo/edit.html.twig', [
            'contrato' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="contratocorreo_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(ContratoCorreo::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Contrato de Correo!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Contrato de Correo satisfactoriamente!!!');
        }

        return $this->redirectToRoute('contratocorreo_index');
    }

    /**
     * @Route("/getmunicipioccxprovinciacc", name="municipiocc_x_provinciacc", methods={"GET","POST"})
     */
    public function getMunicipioccxProvinciacc(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $provincia_id = $request->get('provincia_id');
        $muni = $em->getRepository('App:Municipio')->findByProvinciacc($provincia_id);
        return new JsonResponse($muni);
    }

    /**
     * @Route("/getinstitucionccxmunicipiocc", name="institucioncc_x_municipiocc", methods={"GET","POST"})
     */
    public function getInstitucionxMunicipiocc(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $municipio_id = $request->get('municipio_id');
        $institucion = $em->getRepository('App:Institucion')->findByMunicipiocc($municipio_id);
        return new JsonResponse($institucion);
    }

    /**
     * @Route("/getpersonalmxinstitucionm", name="personalcc_x_institucioncc", methods={"GET","POST"})
     */
    public function getPersonalccxInstitucioncc(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $institucion_id = $request->get('institucion_id');
        $personal = $em->getRepository('App:PersonalMedico')->findByInstitucioncc($institucion_id);
        return new JsonResponse($personal);
    }

    /**
     * @Route("/getpersonalcc2xinstitucioncc2", name="personalcc2_x_institucioncc2", methods={"GET","POST"})
     */
    public function getPersonalcc2xInstitucioncc2(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $institucion_id = $request->get('institucion_id');
        $personal = $em->getRepository('App:PersonalMedico')->findByInstitucioncc2($institucion_id);
        return new JsonResponse($personal);
    }
}
