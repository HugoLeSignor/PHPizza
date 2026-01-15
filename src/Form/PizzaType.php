<?php

namespace App\Form;

use App\Entity\Pizza;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PizzaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                    'label' => 'Nom de la pizza',
                    'attr' => [
                        'placeholder' => 'Ex: Pizza au beurre de cacahuette',
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Le nom de la pizza est obligatoire.',
                        ]),
                        new Length([
                            'min' => 3,
                            'max' => 255,
                            'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères.',
                            'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères.',
                        ]),
                    ],
                ])
            ->add('specialIngredient', TextType::class, [
                    'label' => 'Ingrédient secret',
                    'attr' => [
                        'placeholder' => 'Ex: Pastèque',
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'L\'ingrédient secret est obligatoire.',
                        ]),
                        new Length([
                            'min' => 2,
                            'max' => 255,
                            'minMessage' => 'L\'ingrédient doit contenir au moins {{ limit }} caractères.',
                            'maxMessage' => 'L\'ingrédient ne peut pas dépasser {{ limit }} caractères.',
                        ]),
                    ],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pizza::class,
        ]);
    }
}
