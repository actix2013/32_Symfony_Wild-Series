<?php


namespace App\Form\Category;

use App\Entity\Category;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends \Symfony\Component\Form\AbstractType
{

    private $name;

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }

}
