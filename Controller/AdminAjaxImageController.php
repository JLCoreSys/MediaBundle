<?php

namespace CoreSys\MediaBundle\Controller;

use CoreSys\MediaBundle\Entity\Image;
use CoreSys\MediaBundle\Form\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CoreSys\SiteBundle\Controller\BaseController;

/**
 * Class AdminAjaxImageController
 * @package CoreSys\MediaBundle\Controller
 *
 * @Route("/admin/ajax/media")
 */
class AdminAjaxImageController extends BaseController
{
    /**
     * @Route("/image_form", name="admin_ajax_media_image", defaults={"id"="null"})
     * @Route("/image_form/{id}", name="admin_ajax_media_image_edit", defaults={"id"="null"})
     * @Template("CoreSysMediaBundle:AdminAjaxImage:ImageForm.html.twig")
     */
    public function imageFormAction( $id )
    {
        $repo = $this->getRepo( 'CoreSysMediaBundle:Image' );
        $new = empty( $id );
        $image_id = null;

        $image = $repo->findOneById( $id );
        if( empty( $image ) ) {
            $image = new Image();
        }

        $form = $this->createForm( new ImageType(), $image );

        if( $new ) {
            $action = $this->generateUrl( 'admin_ajax_media_image_save_new' );
            $id = 'create-image-form';
        } else {
            $action = $this->generateUrl( 'admin_ajax_media_image_save', array( 'id' => $image->getId() ) );
            $id = 'edit-image-form';
            $image_id = $image->getId();
        }

        return array( 'image_id' => $image_id, 'form' => $form->createView(), 'action' => $action, 'form_id' => $id, 'show_submit' => false, 'new' => $new );
    }

    /**
     * @Route("/modal_image_form", name="admin_ajax_media_modal_image", defaults={"id"="null"})
     * @Route("/modal_image_form/{id}", name="admin_ajax_media_modal_image_edit", defaults={"id"="null"})
     * @Template("CoreSysMediaBundle:AdminAjaxImage:ModalImageForm.html.twig")
     */
    public function modalImageFormAction( $id )
    {
        $data = $this->imageFormAction( $id );
        if( isset( $data[ 'new' ] ) && $data[ 'new' ] ) {
            $data[ 'title' ] = 'Create a new Image';
        } else {
            $data[ 'title' ] = 'Edit Image';
        }

        $data[ 'modal_id' ] = 'modal-' . $data[ 'form_id' ];

        return $data;
    }

    /**
     * @Route("/image_save_new", name="admin_ajax_media_image_save_new")
     * @Template()
     */
    public function imageSaveNewAction()
    {
        $this->echoJsonSuccess( 'Success' );
    }

    /**
     * @route("/image_save/{id}", name="admin_ajax_media_image_save", defaults={"id"="null"})
     * @Template()
     */
    public function imageSaveAction( $id )
    {
        $repo = $this->getRepo( 'CoreSysMediaBundle:Image' );
        $image = $repo->findOneById( $id );
        if( empty( $image ) ) {
            $this->echoJsonError( 'Could not locate image' );
        }

        $data = array();

        $form = $this->createForm( new ImageType(), $image );
        $request = $this->get( 'request' );
        $form->handleRequest( $request );
        if( $form->isValid() ) {
            $image = $form->getData();
            $this->persist( $image );
            $this->flush();

            $data = array(
                'image' => array(
                    'id' => $image->getId(),
                    'title' => $image->getTitle(),
                    'slug' => $image->getSlug()
                )
            );
        }

        $this->echoJsonSuccess( 'Success', $data );
    }

    /**
     * @Route("/image_info/{id}", name="admin_ajax_media_image_info", defaults={"id"="null"})
     * @ParamConverter("image", class="CoreSysMediaBundle:Image")
     * @Template("CoreSysMediaBundle:AdminAjaxImage:ImageInfo.html.twig")
     */
    public function imageInfoAction( Image $image )
    {
        $image_id = $image->getId();

        return array( 'image_id' => $image_id, 'image' => $image );
    }

    /**
     * @Route("/modal_image_info/{id}", name="admin_ajax_media_modal_image_info", defaults={"id"="null"})
     * @ParamConverter("image", class="CoreSysMediaBundle:Image")
     * @Template("CoreSysMediaBundle:AdminAjaxImage:ModalImageInfo.html.twig")
     */
    public function modalImageInfoAction( Image $image = null )
    {
        return array(
            'image' => $image,
            'title' => 'Image Info',
            'image_id' => $image->getId(),
            'modal_id' => 'modal-image-view-' . $image->getId()
        );
    }
}
