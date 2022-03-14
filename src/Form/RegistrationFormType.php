<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Debe aceptar nuestros términos.',
                    ]),
                ],
            ])

            ->add('plainPassword', RepeatedType::class, array(
                    'type'        => PasswordType::class,
                    'mapped'      => false,
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
                    'first_options' => array('attr' => array('class' => 'form-control')),
                    'second_options' => array('attr' => array('class' => 'form-control')))
            )

            ->add('imageFile', VichImageType::class, [
                        'required' => false,
                        'allow_delete' => true,
                        'download_uri' => true,
                        'image_uri' => true,
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
                    ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
