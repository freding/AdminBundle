<?php

namespace Fredb\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    
    
    
    /**
     * @Route("/test",name="test", defaults={"_locale" = "fr"}, requirements={"_locale" = "en|fr|it"})
     */
    public function indexAction()
    {
       
        echo "test";
        
        
        return $this->render('FredbAdminBundle:Default:index.html.twig', array());
    }
}
