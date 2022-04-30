<?php

namespace App\Controller;

use App\Entity\TablaIP;
use App\Form\TablaIPType;
use App\Repository\TablaIPRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tablaip")
 */
class TablaIPController extends AbstractController
{
    /**
     * @Route("/", name="tablaip_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(TablaIPRepository $tablaIPRepository): Response
    {
        return $this->render('tablaip/index.html.twig', [
            'tabla' => $tablaIPRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tablaip_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, TablaIP $tablaIP): Response
    {
        $form = $this->createForm(TablaIPType::class, $tablaIP);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un IP satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('IP: %s', $tablaIP->getIp()));

            return $this->redirectToRoute('tablaip_index');
        }

        return $this->render('tablaip/edit.html.twig', [
            'tabla' => $tablaIP,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="tablaip_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(TablaIP::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este IP!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un IP satisfactoriamente!!!');
        }

        return $this->redirectToRoute('tablaip_index');
    }
}
