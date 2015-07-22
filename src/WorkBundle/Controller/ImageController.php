<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use WorkBundle\Entity\Image;

class ImageController extends Controller
{
    public function imageUploadAction(Request $request)
    {
        $image = new Image();
        $images = $image->generateImageArray($image->getAllImages($this->getEntityManager()));
        return $this->render('WorkBundle:Admin:imageUpload.html.twig', array(
            'imagesData' => $images,
            'roles' => $image->getAllRoles($this->getEntityManager()),
        ));
    }

    public function imageSavingAction(Request $request)
    {
        if ($request->files->get('image') && $request->request->get('imageRole')) {
            $image = new Image();
            $image->saveImage($request->files->get('image'), $request->request->get('imageRole'), $this->getEntityManager());
            $this->addFlash('notice', 'The picture has been successfully uploaded.');
            return $this->redirectToRoute('image_managing');
        } else {
            $this->addFlash('notice', 'Upload some image, please.');
            return $this->redirectToRoute('image_managing');
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
            $this->addFlash('notice', 'The picture has been successfully deleted.');
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
     * @param $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getBanerAction($role)
    {
        if($role == 3)
        {
            $paths = Image::getBanner($role, $this->getEntityManager());
            return $this->render('WorkBundle:Image:slider.html.twig',
                array('sliders'=>$paths));
        }
        else {
            $path = Image::getBanner($role, $this->getEntityManager());
            return $this->render('WorkBundle:Image:baner.html.twig',
                array('baner'=>$path));
        }
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
