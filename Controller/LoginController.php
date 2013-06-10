<?php

namespace Fredb\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;

class LoginController extends Controller
{
    /**
     * @Route("/log/login", name="login")
     * @Template()
     */
    public function loginAction()
    {   
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('FredbAdminBundle:Login:login.html.twig', array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));        
    }
    
    
    /**
     * @Route("/log/login_check", name="login_check")
     * @Template()
     */
    public function logincheckAction()
    {   echo "logincheck";$name="ok";
        return array('name' => $name);
    }    
    
    
    
    
}
