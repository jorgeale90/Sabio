<?php

namespace App\Form;

use App\Entity\EntradaSalidaEquipo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntradaSalidaEquipoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero')

            ->add('fechaentrada', DateType::class, array(
                'html5' => true,
                'widget' => 'single_text',
                'required' => false
            ))

            ->add('fechasalida', DateType::class, array(
                'html5' => true,
                'widget' => 'single_text',
                'required' => true
            ))

            ->add('datoequipo')

            ->add('procedencia')

            ->add('destino')

            ->add('motivo')

            ->add('personal', EntityType::class, array(
                'label' => 'Autoriza :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\PersonalMedico',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EntradaSalidaEquipo::class,
        ]);
    }
}
