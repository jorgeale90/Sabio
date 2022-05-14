<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
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
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/dashboard", name="dashboard")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(): Response
    {
        $personm = $this->em->getRepository('App:PersonalMedico')->findBy([], ['id' => 'DESC'], 10);
        $contratc = $this->em->getRepository('App:ContratoCorreo')->findBy([], ['id' => 'DESC'], 10);
        $contrata = $this->em->getRepository('App:ContratoAnclaje')->findBy([], ['id' => 'DESC'], 10);
        $sistemac = $this->em->getRepository('App:SistemaContable')->findAll();
        $mediot = $this->em->getRepository('App:MedioTecnologico')->findAll();
        $persona = $this->em->getRepository('App:PersonalMedico')->findAll();
        $direccion = $this->em->getRepository('App:DireccionamientoIP')->findAll();
        $modelot = $this->em->getRepository('App:ModeloTecnico')->findAll();
        $contratoco = $this->em->getRepository('App:ContratoCorreo')->findAll();

        return $this->render('dashboard/index.html.twig', [
            'personalm' => $personm,
            'contratoc' => $contratc,
            'contratoa' => $contrata,
            'sistemac' => $sistemac,
            'mediot' => $mediot,
            'persona' => $persona,
            'direccion' => $direccion,
            'modelot' => $modelot,
            'contratoco' => $contratoco,
            'controller_name' => 'Dashboard',
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
