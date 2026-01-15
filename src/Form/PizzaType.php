<?php

namespace App\Form;

use App\Entity\DoughType;
use App\Entity\Ingredient;
use App\Entity\Pizza;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('doughType', EntityType::class, [
                'class' => DoughType::class,
                'choice_label' => 'name',
                'label' => 'Type de pâte',
                'placeholder' => 'Choisissez un type de pâte',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le type de pâte est obligatoire.',
                    ]),
                ],
            ])
            ->add('ingredients', EntityType::class, [
                'class' => Ingredient::class,
                'choice_label' => 'name',
                'label' => 'Ingrédients classiques',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
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
