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
           // $image->deleteImage('img/qqqa.jpeg');die;
            $image->imageUpload($request->files->get('image'),'','');
        } else {
        }
    }

    /**
     * Image Delete
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteImageAction(Request $request)
    {
        if($request->query->get('img_id')){
            $image = new Image();
            $image->deleteImage($request->query->get('img_id'), $this->getEntityManager());
        }
        return $this->redirectToRoute('image_managing');
    }

    /**
     * Image status change
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function changeStatusAction(Request $request)
    {
        $imgId = $request->query->get('img_id');
        $changeTo = $request->query->get('change_to');
        if(isset($imgId) && isset($changeTo)) {
            $image = new Image();
            $image->changeStatus($request->query->get('img_id'),$request->query->get('change_to'), $this->getEntityManager());
        }
        return $this->redirectToRoute('image_managing');
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
