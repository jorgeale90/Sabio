<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }

    /**
     * @Route("/datosgeneral", name="datos_general")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function datosGeneral(): Response
    {
        return $this->render('dashboard/datosgenerales.html.twig', [
            'controller_name' => 'Widgets Datos Generales',
        ]);
    }
}
