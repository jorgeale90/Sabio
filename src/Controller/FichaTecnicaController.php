<?php

namespace App\Controller;

use App\Entity\FichaTecnica;
use App\Form\FichaTecnicaType;
use App\Repository\FichaTecnicaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/fichatecnica")
 */
class FichaTecnicaController extends AbstractController
{
    /**
     * @Route("/", name="fichatecnica_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(FichaTecnicaRepository $fichaTecnicaRepository): Response
    {
        return $this->render('fichatecnica/index.html.twig', [
            'ficha' => $fichaTecnicaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="fichatecnica_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $entities = new FichaTecnica();
        $form = $this->createForm(FichaTecnicaType::class, $entities);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entities);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Ficha Técnica satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Ficha Técnica: %s', $entities->getNombreCompleto()));

            return $this->redirectToRoute('fichatecnica_index');
        }

        return $this->render('fichatecnica/new.html.twig', [
            'ficha' => $entities,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="fichatecnica_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, FichaTecnica $fichaTecnica, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FichaTecnicaType::class, $fichaTecnica);
        $form->handleRequest($request);

        $original = new ArrayCollection();
        foreach ($fichaTecnica->getHardware() as $hardware) {
            $original->add($hardware);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            // Eliminar la relacion
            foreach ($original as $hardware) {
                if (false === $fichaTecnica->getHardware()->contains($hardware)) {
                    // Eliminar Hardware para la Ficha Tecnica
                    $entityManager->persist($hardware);
                    // Elimino la Hardware por completo
                    $entityManager->remove($hardware);
                }
            }

            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Ficha Técnica satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Ficha Técnica: %s', $fichaTecnica->getNombreCompleto()));

            return $this->redirectToRoute('fichatecnica_index');
        }

        return $this->render('fichatecnica/edit.html.twig', [
            'ficha' => $fichaTecnica,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="fichatecnica_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(FichaTecnica::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra esta Ficha Técnica!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado una Ficha Técnica satisfactoriamente!!!');
        }

        return $this->redirectToRoute('fichatecnica_index');
    }

    /**
     * @Route("/getmunicipioftxprovinciaft", name="municipioft_x_provinciaft", methods={"GET","POST"})
     */
    public function getMunicipioftxProvinciaft(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $provincia_id = $request->get('provincia_id');
        $municipio = $em->getRepository('App:Municipio')->findByProvinciaft($provincia_id);
        return new JsonResponse($municipio);
    }

    /**
     * @Route("/getinstitucionftxmunicipioft", name="institucionft_x_municipioft", methods={"GET","POST"})
     */
    public function getInstitucionftxMunicipioft(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $municipio_id = $request->get('municipio_id');
        $institucion = $em->getRepository('App:Institucion')->findByMunicipioft($municipio_id);
        return new JsonResponse($institucion);
    }
}
