<?php
namespace WorkBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="images_banners")
 */
class Image
{
    /**
     * @var image max size that is allowed
     */
    const MAX_IMG_SIZE = 5;
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;
    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $extension;
    /**
     * @ORM\ManyToOne(targetEntity="ImageRole")
     */
    protected $role;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $path;
    /**
     * @ORM\Column(type="boolean", length=255)
     */
    protected $status;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Image
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set extension
     *
     * @param string $extension
     * @return Image
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Image
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set role
     *
     * @param \WorkBundle\Entity\ImageRole $role
     * @return Image
     */
    public function setRole(\WorkBundle\Entity\ImageRole $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \WorkBundle\Entity\ImageRole
     */
    public function getRole()
    {
        return $this->role;
    }
    /**
     * Set status
     *
     * @param integer $status
     * @return Image
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get all images
     *
     * @param int|null $imageRole
     * @param \Doctrine\Common\Persistence\ObjectManager|\Doctrine\ORM\EntityManager|object $em
     * @return mixed
     */
    public function getAllImages($em,$imageRole = null)
    {
        $imageRepository = $em->getRepository('WorkBundle:Image');
        if($imageRole){
            return $imageRepository->findBy(array('role_id' => $imageRole)) ;
        } else {
            return $imageRepository->findAll();
        }
    }

    /**
     * @param \Doctrine\Common\Persistence\ObjectManager|\Doctrine\ORM\EntityManager|object $em
     * @return array|null
     */
    public function getAllRoles($em)
    {
        $rolesRepo = $em->getRepository('WorkBundle:ImageRole');
        $allRoles = $rolesRepo->findAll();
        if($allRoles){
            $roles = array();
            /** @var \WorkBundle\Entity\ImageRole $role */
            foreach ($allRoles as $role){
                $roles[] = array(
                    'id' => $role->getId(),
                    'name' => $role->getName(),
                );
            }
            return $roles;
        } else {
            return null;
        }
    }

    /**
     * Generates an array for template from objects array
     *
     * @param array $imageObjectsArray
     * @return array|null
     */
    public function generateImageArray($imageObjectsArray)
    {
        if($imageObjectsArray){
            $images = array();
            /** @var \WorkBundle\Entity\Image $image */
            foreach ($imageObjectsArray as $image) {
                $images[] = array(
                    'id' => $image->getId(),
                    'name' => $image->getName(),
                    'role' => array('id' => $image->getRole()->getId(), 'role' => $image->getRole()->getName()),
                    'extension' => $image->getExtension(),
                    'path' => $image->getPath(),
                    'status' => $image->getStatus(),
                );
            }
            return $images;
        } else {
            return null;
        }
    }

    /**
     * Image uploading on the server
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $image
     * @param string $fileName
     * @param bool $isForSlider
     * @return string
     */
    public function imageUpload($image, $fileName, $isForSlider = false)
    {
        if($this->checkExtension($image->getClientMimeType())){
            if($image->getSize()< $this->getMaxImageSize()){
                $imageName = $fileName . '.' . $image->guessClientExtension();
                if($isForSlider){
                    $image->move('img/slider',$imageName);
                    return null;
                } else {
                    $image->move('img',$imageName);
                    return null;
                }
            } else {
                return 'Розмір зображення занадто великий (макс. 5 MB).';
            }
        } else {
            return 'Розширення зображення недопустиме(можливі: jpg, jpeg, gif, png).';
        }
    }

    /**
     * @param string $imageId
     * @param \Doctrine\Common\Persistence\ObjectManager|\Doctrine\ORM\EntityManager|object $em
     * @return string
     */
    public function deleteImage($imageId, $em)
    {
        /** @var \WorkBundle\Entity\Image $image */
        $image = $em->getRepository('WorkBundle:Image')->find($imageId);
        if($image) {
            try {
                $imagePath = $image->getPath();
                $fs        = new Filesystem();
                $fs->remove($imagePath);
                $em->remove($image);
                $em->flush();
                return null;
            } catch (IOExceptionInterface $e) {
                return $e->getMessage();
            }
        } else {
            return null;
        }
    }

    /**
     * Image status changing
     *
     * @param int $imgId
     * @param int $changeTo
     * @param \Doctrine\Common\Persistence\ObjectManager|\Doctrine\ORM\EntityManager|object $em
     */
    public function changeStatus($imgId, $changeTo, $em)
    {
        $imageRepo = $em->getRepository('WorkBundle:Image');
        /** @var \WorkBundle\Entity\Image $changingImage */
        $changingImage = $imageRepo->find($imgId);
        if ($changingImage) {
            if($changingImage->getRole()->getName()=='slider'){
                $changingImage->setStatus($changeTo);
                $em->persist($changingImage);
                $em->flush();
            } else {
                if ($changeTo==0) {
                    $changingImage->setStatus($changeTo);
                    $em->persist($changingImage);
                    $em->flush();
                } else {
                    $selectedImage = $imageRepo->findBy(array('status' => $changeTo, 'role' => $changingImage->getRole()->getId()));
                    if(count($selectedImage)==1) {
                        /** @var \WorkBundle\Entity\Image $selectedImage */
                        $selectedImage = array_shift($selectedImage);
                        $selectedImage->setStatus(abs($selectedImage->getStatus()-1));
                        $em->persist($selectedImage);
                    } elseif(!$selectedImage) {
                        $changingImage->setStatus($changeTo);
                        $em->persist($changingImage);
                        $em->flush();
                    } else {
                        return;
                    }
                    $changingImage->setStatus($changeTo);
                    $em->persist($changingImage);
                    $em->flush();
                }
            }
        }
    }

    /**
     * Get max image size, that is allowed
     *
     * @return int|double
     */
    public function getMaxImageSize()
    {
        return self::MAX_IMG_SIZE * 1024 * 1024;
    }

    /**
     * Checks, if extension is correct
     *
     * @param string $extension
     * @return bool
     */
    protected function checkExtension($extension)
    {
        return $extension=='image/jpeg'||$extension=='image/jpg'||$extension=='image/png'||$extension=='image/gif';
    }
}
