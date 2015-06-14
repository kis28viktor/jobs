<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WorkBundle\Entity\Image;

class ImageController extends Controller
{
    public function imageUploadAction()
    {
        return $this->render('WorkBundle:Admin:imageUpload.html.twig');
    }

    public function imageSavingAction(Request $request)
    {
        if ($request->files->get('image')) {
            $image = new Image();
            //delete Image: path from web folder.
            $image->deleteImage('img/qqqa.jpeg');die;
            $image->imageUpload($request->files->get('image'),'','');
        } else {
        }
    }
}
