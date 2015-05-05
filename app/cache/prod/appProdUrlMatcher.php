<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appProdUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        // main
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'main');
            }

            return array (  '_controller' => 'WorkBundle\\Controller\\DefaultController::indexAction',  '_route' => 'main',);
        }

        // find_work
        if ($pathinfo === '/findwork') {
            return array (  '_controller' => 'WorkBundle\\Controller\\WorkerController::findWorkAction',  '_route' => 'find_work',);
        }

        if (0 === strpos($pathinfo, '/post')) {
            // post_worker
            if ($pathinfo === '/postwork') {
                return array (  '_controller' => 'WorkBundle\\Controller\\WorkerController::postWorkerAction',  '_route' => 'post_worker',);
            }

            // post_hire
            if ($pathinfo === '/posthire') {
                return array (  '_controller' => 'WorkBundle\\Controller\\HireController::postAction',  '_route' => 'post_hire',);
            }

        }

        // find_hire
        if ($pathinfo === '/findhire') {
            return array (  '_controller' => 'WorkBundle\\Controller\\HireController::findAction',  '_route' => 'find_hire',);
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
