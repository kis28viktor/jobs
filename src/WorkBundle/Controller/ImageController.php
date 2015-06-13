<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ImageController extends Controller
{
    public function imageUploadAction()
    {
        return $this->render('WorkBundle:Admin:imageUpload.html.twig');
    }

    public function imageSavingAction(Request $request)
    {

    }
}
