<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WorkBundle\Entity\Image;

class ImageController extends Controller
{
    public function imageUploadAction(Request $request)
    {
        $image = new Image();
        $images = $image->generateImageArray($image->getAllImages($this->getEntityManager()));
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($images,$request->query->getInt('page', 1),20);
        return $this->render('WorkBundle:Admin:imageUpload.html.twig', array(
            'imagesData' => $pagination,
            'roles' => $image->getAllRoles($this->getEntityManager()),
        ));
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

    public function deleteImageAction(Request $request)
    {
        echo 'Deleted';die;
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
