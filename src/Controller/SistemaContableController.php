<?php

namespace App\Controller;

use App\Entity\SistemaContable;
use App\Form\SistemaContableType;
use App\Repository\SistemaContableRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/sistemacontable")
 */
class SistemaContableController extends AbstractController
{
    /**
     * @Route("/", name="sistemacontable_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(SistemaContableRepository $sistemaContableRepository): Response
    {
        return $this->render('sistemacontable/index.html.twig', [
            'sistemacontable' => $sistemaContableRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sistemacontable_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entity = new SistemaContable();
        $form = $this->createForm(SistemaContableType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $entity->setUser($user);
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Sistema Contable satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Sistema Contable: %s', $entity->getCodigo()));

            return $this->redirectToRoute('sistemacontable_index');
        }

        return $this->render('sistemacontable/new.html.twig', [
            'sistemacont' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sistemacontable_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, SistemaContable $entity): Response
    {
        $form = $this->createForm(SistemaContableType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $entity->setUser($user);
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Sistema Contable satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Sistema Contable: %s', $entity->getCodigo()));

            return $this->redirectToRoute('sistemacontable_index');
        }

        return $this->render('sistemacontable/edit.html.twig', [
            'sistemcont' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="sistemacontable_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(SistemaContable::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Sistema Contable!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Sistema Contable satisfactoriamente!!!');
        }

        return $this->redirectToRoute('sistemacontable_index');
    }

    /**
     * @Route("/getmunicipioscxprovinciasc", name="municipiosc_x_provinciasc", methods={"GET","POST"})
     */
    public function getMunicipioscxProvinciasc(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $provincia_id = $request->get('provincia_id');
        $municipio = $em->getRepository('App:Municipio')->findByProvinciasc($provincia_id);
        return new JsonResponse($municipio);
    }

    /**
     * @Route("/getinstitucionscxmunicipiosc", name="institucionsc_x_municipiosc", methods={"GET","POST"})
     */
    public function getInstitucionscxMunicipiosc(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $municipio_id = $request->get('municipio_id');
        $institucion = $em->getRepository('App:Institucion')->findByMunicipiosc($municipio_id);
        return new JsonResponse($institucion);
    }

    /**
     * @Route("/getpersonalscxinstitucionsc", name="personalsc_x_institucionsc", methods={"GET","POST"})
     */
    public function getPersonalscxInstitucionsc(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $institucion_id = $request->get('institucion_id');
        $personal = $em->getRepository('App:PersonalMedico')->findByInstitucionsc($institucion_id);
        return new JsonResponse($personal);
    }
}