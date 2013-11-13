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
 * Class UploadController
 * @package CoreSys\MediaBundle\Controller
 * @Route("/admin/media/upload")
 */
class UploadController extends BaseController
{
    /**
     * @Route("/image", name="media_upload_image")
     * @Template()
     **/
    public function uploadImageAction()
    {
        $request = $this->get( 'request' );
        $manager = $this->get( 'core_sys_media.image_manager' );
        $upload_folder = $manager->getUploadFolder();
        $file_types = array( 'jpeg', 'jpg', 'gif', 'png' );
        $salt = $this->container->getParameter('secret');
        $verifyToken = md5( $salt . $request->get( 'timestamp', 0 ) );
        $type = $request->get( 'type', 'image' );

        $data = $request->request->all();
        $data[ 'success' ] = false;
        $data[ 'msg' ] = 'Could not save image to the system.';

        if( $request->files->count() > 0 && $request->get( 'token' ) == $verifyToken ) {
            foreach( $request->files->all() as $file ) {
                $image = $manager->uploadImage( $file, $type );
                if( $image !== false ) {
                    $data[ 'success' ] = true;
                    $data[ 'msg' ] = 'Success';
                    $data[ 'image_id' ] = $image->getId();
                }
            }
        }

        echo json_encode( $data );
        exit;
    }
}