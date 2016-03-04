<?php

namespace AppBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class CategoryType extends AbstractType
{
    public function __construct()
    {

    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('name', EntityType::class, array(
            'class' => 'AppBundle:Category',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                          ->where('c.parent IS NOT NULL');
            },
            'choice_label' => 'name',
            'label' => false,
            'attr'      => array('class' => 'form-control')
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Category',
        ));
    }

    public function getName()
    {
        return 'app_bundle_category_type';
    }
}
