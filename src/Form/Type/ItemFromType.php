<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;

class ItemFromType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Podaj nazwę produktu']),
                ],
            ])
            ->add('amount', IntegerType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Podaj ilość produktów znajdujących się na składzie']),
                    new Assert\GreaterThanOrEqual([
                        'value' => 0,
                        'message' => 'Minimalna ilość produktów musi być większa bądź równa zero'
                    ])
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Wyślij'
            ])
        ;
    }
}
