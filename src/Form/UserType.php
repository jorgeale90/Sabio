<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\CallbackTransformer;

class UserType extends AbstractType
{
    public $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullname')

            ->add('email')

            ->add('institucion', EntityType::class, array(
                'label' => 'Institución :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Institucion',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))

            ->add('password', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Por favor introduce la contraseña',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Tu contraseña debe tener al menos {{ limit }} caracteres',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                    'invalid_message' => 'Debe de coincidir las contraseña',
                    'first_options' => array('attr' => array('class' => 'input100', 'placeholder' => 'Contraseña')),
                    'second_options' => array('attr' => array('class' => 'input100', 'placeholder' => 'Repita la contraseña')),
                    'required' => false)
            )

            ->add('imageFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_uri' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/gif',
                            'image/png',
                        ]
                    ])
                ]
            ]);

        if ($this->security->isGranted('IS_AUTHENTICATED_FULLY') ) {
            $builder               
                ->add('roles',ChoiceType::class,[
                    'required'=>true,
                    'multiple'=>false,
                    'expanded'=>false,
                    'attr' => array('class' => 'form-control select2'),
                    'choices'=>[
                        'Usuario'=>'ROLE_CLIENT',
                        'Moderador'=>'ROLE_MODERATOR',
                        'Administrador'=>'ROLE_ADMIN',
                    ],
                ]);

            $builder->get('roles')
                ->addModelTransformer(new CallbackTransformer(
                    function ($rolesArray) {
                        return count($rolesArray) ? $rolesArray[0] : null;
                    },
                    function ($roleString){
                        return [$roleString];
                    }
                ));
        }

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}