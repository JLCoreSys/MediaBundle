<?php

namespace CoreSys\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class DefaultController
 * @package CoreSys\MediaBundle\Controller
 *
 * @Route("/media")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="media_idx")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
