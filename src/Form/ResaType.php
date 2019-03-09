<?php

namespace App\Form;

use App\Entity\Resa;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\DBAL\Types\IntegerType;

class ResaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('visitDate', DateType::class, [
                'widget'    => 'single_text',
                'html5'     => false,
                'attr'      => [
                    'class'         => 'js-datepicker',
                    'format'        => 'dd/mm/Y',
                    'placeholder'   => 'Jour de votre visite'
                ]
            ])
            ->add('emailResa', EmailType::class, [
                'attr' => [
                    'palceholder' => 'email de réception de votre commande'
                ]
            ])
            ->add('typeTicket', ChoiceType::class, [
                'choices' => $radioChoices = [
                    'Journée'       => true,
                    'Demi-journée'  => false
                ],
                'expanded' => true
            ])
            ->add('nbTickets', IntegerType::class, ['data' => '1']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Resa::class,
        ]);
    }
}
