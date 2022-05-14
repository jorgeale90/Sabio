<?php

namespace App\Controller;

use App\Entity\ModeloTecnico;
use App\Form\ModeloTecnicoType;
use App\Repository\ModeloTecnicoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/modelotecnico")
 */
class ModeloTecnicoController extends AbstractController
{
    /**
     * @Route("/", name="modelotecnico_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(ModeloTecnicoRepository $modeloTecnicoRepository): Response
    {
        return $this->render('modelotecnico/index.html.twig', [
            'modelo' => $modeloTecnicoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="modelotecnico_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entities = new ModeloTecnico();
        $form = $this->createForm(ModeloTecnicoType::class, $entities);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $entities->setUser($user);
            $entityManager->persist($entities);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Modelo del Expediente Técnico satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Modelo: %s', $entities->getNoinventario()));

            return $this->redirectToRoute('modelotecnico_index');
        }

        return $this->render('modelotecnico/new.html.twig', [
            'modelo' => $entities,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="modelotecnico_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, ModeloTecnico $modeloTecnico): Response
    {
        $form = $this->createForm(ModeloTecnicoType::class, $modeloTecnico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $modeloTecnico->setUser($user);
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Modelo del Expediente Técnico satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Modelo: %s', $modeloTecnico->getNoinventario()));

            return $this->redirectToRoute('modelotecnico_index');
        }

        return $this->render('modelotecnico/edit.html.twig', [
            'modelo' => $modeloTecnico,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="modelotecnico_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(ModeloTecnico::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Modelo del Expediente Técnico!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Modelo del Expediente Técnico satisfactoriamente!!!');
        }

        return $this->redirectToRoute('modelotecnico_index');
    }

    /**
     * @Route("/getmunicipiomxprovinciam", name="municipiom_x_provinciam", methods={"GET","POST"})
     */
    public function getMunicipiomxProvinciam(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $provincia_id = $request->get('provincia_id');
        $municipio = $em->getRepository('App:Municipio')->findByProvinciam($provincia_id);
        return new JsonResponse($municipio);
    }

    /**
     * @Route("/getinstitucionmxmunicipiom", name="institucionm_x_municipiom", methods={"GET","POST"})
     */
    public function getInstitucionmtxMunicipiomt(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $municipio_id = $request->get('municipio_id');
        $institucion = $em->getRepository('App:Institucion')->findByMunicipiom($municipio_id);
        return new JsonResponse($institucion);
    }

    /**
     * @Route("/getfichamxinstitucionm", name="ficham_x_institucionm", methods={"GET","POST"})
     */
    public function getFichamtxInstitucionmt(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $institucion_id = $request->get('institucion_id');
        $ficha= $em->getRepository('App:FichaTecnica')->findByInstitucionm($institucion_id);
        return new JsonResponse($ficha);
    }

    /**
     * @Route("/getpersonalmxinstitucionm", name="personalm_x_institucionm", methods={"GET","POST"})
     */
    public function getPersonalmtxInstitucionmt(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $institucion_id = $request->get('institucion_id');
        $personal = $em->getRepository('App:PersonalMedico')->findByInstitucionPm($institucion_id);
        return new JsonResponse($personal);
    }

    /**
     * @Route("/getpersonalm2xinstitucionm2", name="personalm2_x_institucionm2", methods={"GET","POST"})
     */
    public function getPersonalm2xInstitucionm2(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $institucion_id = $request->get('institucion_id');
        $personal = $em->getRepository('App:PersonalMedico')->findByInstitucionPm2($institucion_id);
        return new JsonResponse($personal);
    }

    /**
     * @Route("/getmodelomxmarcam", name="modelom_x_marcam", methods={"GET","POST"})
     */
    public function getMarcaxModelo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $marca_id = $request->get('marca_id');
        $modelo = $em->getRepository('App:Modelo')->findByMarcam($marca_id);
        return new JsonResponse($modelo);
    }
}
