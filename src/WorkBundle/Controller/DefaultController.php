<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('WorkBundle:Default:index.html.twig');
    }

    public function allIssuesAction(Request $request)
    {
        var_dump($request->query->all());die;
    }
}
