<?php

namespace CoreSys\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CoreSys\SiteBundle\Controller\BaseController;

use CoreSys\MediaBundle\Entity\Image;

use Imagine\Gd\Imagine;
use Imagine\Gd\Image as IImage;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Image\Color;
use Imagine\Image\ImageInterface;

/**
 * Class ImageController
 * @package CoreSys\MediaBundle\Controller
 * @Route("/csimg")
 */
class ImageController extends BaseController
{

    /**
     * @Route("/src/{slug}", name="media_image_src", defaults={"slug"="null"})
     * @Template()
     */
    public function srcAction( $slug )
    {
        $this->imageAction( 'original', $slug );
        exit;
    }

    /**
     * @Route("/tiny/{slug}", name="media_image_tiny", defaults={"slug"="null"}, requirements={"slug"=".*"})
     * @Template()
     */
    public function tinyAction( $slug )
    {
        $this->imageAction( 'tiny', $slug );
        exit;
    }

    /**
     * @Route("/thumb/{slug}", name="media_image_thumb", defaults={"slug"="null"}, requirements={"slug"=".*"})
     * @Template()
     */
    public function thumbAction( $slug )
    {
        $this->imageAction( 'thumb', $slug );
        exit;
    }

    /**
     * @Route("/small/{slug}", name="media_image_small", defaults={"slug"="null"}, requirements={"slug"=".*"})
     * @Template()
     */
    public function smallAction( $slug )
    {
        $this->imageAction( 'small', $slug );
        exit;
    }

    /**
     * @Route("/medium/{slug}", name="media_image_medium", defaults={"slug"="null"}, requirements={"slug"=".*"})
     * @Template()
     */
    public function mediumAction( $slug )
    {
        $this->imageAction( 'medium', $slug );
        exit;
    }

    /**
     * @Route("/large/{slug}", name="media_image_large", defaults={"slug"="null"}, requirements={"slug"=".*"})
     * @Template()
     */
    public function largeAction( $slug )
    {
        $this->imageAction( 'large', $slug );
        exit;
    }

    /**
     * @Route("/original/{slug}", name="media_image_original", defaults={"slug"="null"}, requirements={"slug"=".*"})
     * @Template()
     */
    public function originalAction( $slug )
    {
        $this->imageAction( 'original', $slug );
        exit;
    }

    /**
     * @Route("/{size}/{slug}", name="media_image_size", defaults={"size"="null","slug"="null"}, requirements={"slug"=".*"})
     * @Template()
     */
    public function imageAction($size, $slug)
    {
        $repo = $this->getRepo( 'CoreSysMediaBundle:Image' );
        $image = $repo->locateImage( $slug );

        if( empty( $image ) )
        {
            echo 'File not found.';
        } else {
            $image->show( $size );
        }
        exit;
    }
}
