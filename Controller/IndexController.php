<?php

namespace Fredb\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Doctrine\Common\Util\Debug;
use Zgroupe\Annotations;

class IndexController extends Controller
{
    /**
     * @Route("/admin",name="admin_index")
     * @Route("/{_locale}/admin",name="admin_index_local")
     */
    public function indexAction()
    {  
	$route = "";	
	if (true === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
		$route = $this->redirect($this->generateUrl("home_admin"));
	}elseif (true === $this->get('security.context')->isGranted('ROLE_ADMINROOT')){
		$route = $this->redirect($this->generateUrl("home_adminroot"));
	}else{
		throw new AccessDeniedException();
	}

        return $route;
    }
	
	
	
    /**
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{_locale}/admin/adminhome",name="home_admin", defaults={"_locale" = "fr"}, requirements={"_locale" = "en|fr|it"})
     * @Template()
     */
    public function adminhomeAction()
    {        
        $oAdmin_form_service = $this->get("admin_form_service");
    
        $oItem = new Acme\DemoBundle\Entity\Test();
        
        echo $oAdmin_form_service->getRows($oItem);
        return array();
    }	
	
	
	
    /**
     * @Secure(roles="ROLE_ADMINROOT")
     * @Route("/{_locale}/admin/adminroothome",name="home_adminroot", defaults={"_locale" = "fr"}, requirements={"_locale" = "en|fr|it"})
     * @Template()
     */
    public function adminroothomeAction()
    {  

        return array();
    }	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
