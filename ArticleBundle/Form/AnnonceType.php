<?php

namespace ArticleBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use blackknight467\StarRatingBundle\Form\RatingType;
class AnnonceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomArticle')->add('description')->add('photo',FileType::class,array('attr'=>array( 'class'=>'form-control col-md-6','style'=>'margin-bottom:15px;')))->add('date')->add('Categorie',EntityType::class, array(
            'class'=>'ArticleBundle:Categorie',
            'choice_label'=>'type',
            'multiple'=>false
        ))->add( 'rating',RatingType::class, [
            'label' => 'Rating'])->add('save',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ArticleBundle\Entity\Annonce'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'articlebundle_annonce';
    }


}
