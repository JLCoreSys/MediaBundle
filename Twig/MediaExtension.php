<?php

namespace CoreSys\MediaBundle\Twig;

use CoreSys\MediaBundle\Entity\Image;
use CoreSys\SiteBundle\Twig\BaseExtension;

/**
 * Class MediaExtension
 * @package CoreSys\MediaBundle\Twig
 */
class MediaExtension extends BaseExtension
{

    /**
     * @var string
     */
    protected $name = 'media_extension';

    /**
     * @return array
     */
    public function getFilters()
    {
        return array();
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'fullImage'       => new \Twig_Function_Method( $this, 'getFullImage' ),
            'fullImageTiny'       => new \Twig_Function_Method( $this, 'getFullImageTiny' ),
            'fullImageThumb'       => new \Twig_Function_Method( $this, 'getFullImageThumb' ),
            'fullImageSmall'       => new \Twig_Function_Method( $this, 'getFullImageSmall' ),
            'fullImageMedium'       => new \Twig_Function_Method( $this, 'getFullImageMedium' ),
            'fullImageLarge'       => new \Twig_Function_Method( $this, 'getFullImageLarge' ),
            'fullImageXLarge'       => new \Twig_Function_Method( $this, 'getFullImageXLarge' ),
            'fullImageXXLarge'       => new \Twig_Function_Method( $this, 'getFullImageXXLarge' ),
            'fullImageXXXLarge'       => new \Twig_Function_Method( $this, 'getFullImageXXXLarge' ),
            'fullImageOriginal'       => new \Twig_Function_Method( $this, 'getFullImageOriginal' )
        );
    }

    public function getImageEntity( $slug = null )
    {
        if( $slug instanceof Image) { return $slug; }
        $repo = $this->getRepo( 'CoreSysMediaBundle:Image' );
        return $repo->locateImage( $slug );
    }

    public function generateUrl($route, $parameters = array(), $referenceType = null)
    {
        return $this->getContainer()->get('router')->generate($route, $parameters, $referenceType);
    }

    public function getFullImage( $image = null, $size = 'thumb', $internal = false, $extras = array() )
    {
        $extras = is_array( $extras ) ? $extras : array();
        $image = $this->getImageEntity( $image );
        if( empty( $image ) ) { return null; }
        $internal = $internal === true;

        $class = isset( $extras[ 'class' ] ) ? $extras[ 'class' ] : null;
        if( $internal ) {
            $base = $this->generateUrl( 'site_base', array(), true );
            $base = str_replace( 'app_dev.php/', '', $base );
            $path = $image->getUrl( null, $size, true );
            $path = $base . $path;
        } else {
            $path = $this->generateUrl( 'media_image_size', array( 'size' => $size, 'slug' => $image->getId() ), true ) . '.' . $image->getExt();
        }

        $attr = isset( $extras[ 'attr' ] ) ? $extras[ 'attr' ] : array();
        $add_attr = array();
        foreach( $attr as $key => $var ) {
            $add_attr[] = $key . '="' . $var . '"';
        }
        $attr = implode( ' ', $add_attr );

        $return = array(
            '<img',
            'class="' . $class . '"',
            'src="' . $path . '"',
            $attr,
            ' />'
        );

        return implode( ' ', $return );
    }

    public function getFullImageThumb( $image = null, $internal = false, $extras = array() )
    {
        return $this->getFullImage( $image, 'thumb', $internal, $extras );
    }

    public function getFullImageXLarge( $image = null, $internal = false, $extras = array() )
    {
        return $this->getFullImage( $image, 'xlarge', $internal, $extras );
    }

    public function getFullImageXXLarge( $image = null, $internal = false, $extras = array() )
    {
        return $this->getFullImage( $image, 'xxlarge', $internal, $extras );
    }

    public function getFullImageXXXLarge( $image = null, $internal = false, $extras = array() )
    {
        return $this->getFullImage( $image, 'xxxlarge', $internal, $extras );
    }

    public function getFullImageLarge( $image = null, $internal = false, $extras = array() )
    {
        return $this->getFullImage( $image, 'large', $internal, $extras );
    }

    public function getFullImageMedium( $image = null, $internal = false, $extras = array() )
    {
        return $this->getFullImage( $image, 'medium', $internal, $extras );
    }

    public function getFullImageSmall( $image = null, $internal = false, $extras = array() )
    {
        return $this->getFullImage( $image, 'small', $internal, $extras );
    }

    public function getFullImageTiny( $image = null, $internal = false, $extras = array() )
    {
        return $this->getFullImage( $image, 'tiny', $internal, $extras );
    }

    public function getFullImageOriginal( $image = null, $internal = false, $extras = array() )
    {
        return $this->getFullImage( $image, 'original', $internal, $extras );
    }
}