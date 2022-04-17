<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\GlobalsInterface;

class GlobalExtension extends AbstractExtension implements GlobalsInterface
{
	protected $em;

	public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getGlobals(): array
    {
        $globalVars = [
            'usuarios' => $this->em->getRepository('App:User')->findAll(),
            'paiss' => $this->em->getRepository('App:Pais')->findAll(),
            'provinciass' => $this->em->getRepository('App:Provincia')->findAll(),
            'municipioss' => $this->em->getRepository('App:Municipio')->findAll(),
            'nacionalidadess' => $this->em->getRepository('App:Nacionalidad')->findAll(),
            'categoriasdocentess' => $this->em->getRepository('App:CategoriaDocente')->findAll(),
            'categoriascientificass' => $this->em->getRepository('App:CategoriaCientifica')->findAll(),
            'cargoss' => $this->em->getRepository('App:Cargo')->findAll(),
            'sexoss' => $this->em->getRepository('App:Sexo')->findAll(),
            'especialidadess' => $this->em->getRepository('App:Especialidad')->findAll(),
            'organizacionpoliticass' => $this->em->getRepository('App:OrganizacionPolitica')->findAll(),
            'sistemacontabless' => $this->em->getRepository('App:SistemaContable')->findAll(),
            'sistemamoduloss' => $this->em->getRepository('App:SistemaModulo')->findAll(),
            'marcass' => $this->em->getRepository('App:Marca')->findAll(),
            'medeloss' => $this->em->getRepository('App:Modelo')->findAll(),
            'tipomedioss' => $this->em->getRepository('App:TipoMedio')->findAll(),
            'mediotecnologicoss' => $this->em->getRepository('App:MedioTecnologico')->findAll(),
            'personalmedicoss' => $this->em->getRepository('App:PersonalMedico')->findAll(),
            'contratoscorreo' => $this->em->getRepository('App:ContratoCorreo')->findAll(),
            'instituciones' => $this->em->getRepository('App:Institucion')->findAll(),
            'contratosanclaje' => $this->em->getRepository('App:ContratoAnclaje')->findAll(),
            'contratosinternet' => $this->em->getRepository('App:ContratoInternet')->findAll(),
            'fichastecnica' => $this->em->getRepository('App:FichaTecnica')->findAll(),
        ];

        return $globalVars;
    }

    public function getName() {
        return 'GlobalExtension';
    }

}