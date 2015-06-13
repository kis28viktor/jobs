<?php
namespace WorkBundle\Entity;

class Image
{
    /**
     * @var image max size that is allowed
     */
    const MAX_IMG_SIZE = 5;

    /**
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
