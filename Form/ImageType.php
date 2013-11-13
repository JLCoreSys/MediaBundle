<?php

namespace CoreSys\MediaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\DataEvent;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', null, array( 'required' => false, 'attr' => array( 'data-postdesc' => 'The name for this image' ) ) )
                ->add('slug', null, array( 'required' => false, 'attr' => array( 'data-postdesc' => 'The slug for this image' ) ) )
                ->add('description', 'genemu_tinymce', array( 'required' => false, 'attr' => array( 'data-postdesc' => 'The description for this image' ) ) );

    }

    public function getName()
    {
        return 'media_image_type';
    }
}