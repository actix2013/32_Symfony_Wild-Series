<?php

namespace App\Form;

use App\Entity\Program;
use App\Repository\ActorRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Actor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ProgramType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('title')
            ->add('summary')
            ->add('posterFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true, // not mandatory, default is true
                'download_uri' => true, // not mandatory, default is true
            ])
            ->add('category', null, ['choice_label' => 'name'])
        ;
        $builder->add('actors', EntityType::class, [
            'class' => Actor::class,
            'query_builder' => function (ActorRepository $ac)
            {
                    return $ac->createQueryBuilder('actor')->orderBy('actor . name', 'ASC');
             },
            'choice_label' => 'name',
            "multiple" => true,
            "expanded" => true,
            'by_reference' => false,
        ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
        ]);
    }
}
