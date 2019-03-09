<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class, ['label' => 'Nom de famille'])
            ->add('firstName', TextType::class, ['label' => 'Prénom'])
            ->add('birthday', BirthdayType::class, ['widget' => 'single_text'])
            ->add('country', CountryType::class, [
                'label'              => 'Pays',
                'preferred_choices'  => ['FR']
            ])
            ->add('reducePrice', CheckBoxType::class, [
                'label'     => 'Tarif reduit *',
                'required'  => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
