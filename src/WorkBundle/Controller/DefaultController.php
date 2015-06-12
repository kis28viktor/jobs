<?php

namespace WorkBundle\Controller;

use Proxies\__CG__\WorkBundle\Entity\Category;
use Proxies\__CG__\WorkBundle\Entity\Gender;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        if($request->query->get('city')){
            $cityCookie = new Cookie('city', $request->query->get('city'), 0, 'find_worker',null, false, false);
            $cityCookie2 = new Cookie('city', $request->query->get('city'), 0, 'find_work',null, false, false);
            $response = new Response();
            $response->headers->setCookie($cityCookie);
            $response->headers->setCookie($cityCookie2);
            $response->send();
        }
        return $this->render('WorkBundle:Default:index.html.twig');
    }

    /**
     * Get Entity Manager
     *
     * @return \Doctrine\Common\Persistence\ObjectManager|\Doctrine\ORM\EntityManager|object
     */
    protected function getEntityManager()
    {
        return $this->getDoctrine()->getEntityManager();
    }
}
