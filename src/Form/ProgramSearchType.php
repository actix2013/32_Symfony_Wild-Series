<?php


namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ProgramSearchType extends \Symfony\Component\Form\AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('searchField', null,
            [
                "label" => "%_labalSearch_%",
                'label_translation_parameters' => [
                    '%_labalSearch_%' => 'Search a program , type his name or part his name : ',
                ],
            ]);
    }

}

