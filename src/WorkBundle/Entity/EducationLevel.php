<?php

namespace WorkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="educationLevel")
 */
class EducationLevel
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;
    /**
     * @ORM\OneToMany(targetEntity="Education", mappedBy="level")
     */
    protected $education;

    /**
     * Get education
     *
     * @return mixed
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * Set education
     *
     * @param $education
     * @return $this
     */
    public function setEducation($education)
    {
        $this->education = $education;
        return $this;
    }

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
     * @return EducationLevel
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
     * Get all possible education levels
     *
     * @param \Doctrine\Common\Persistence\ObjectManager|\Doctrine\ORM\EntityManager|object $entityManager
     * @return array
     */
    public function getAllEducationLevels($entityManager)
    {
        $educationLevelRepository = $entityManager->getRepository('WorkBundle:EducationLevel');
        $levelModels = $educationLevelRepository->findAll();
        $levels = array();
        if($levelModels){
            /** @var \WorkBundle\Entity\EducationLevel $level */
            foreach ($levelModels as $level) {
                $levels[$level->getId()] = $level->getName();
            }
        }
        return $levels;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->education = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add education
     *
     * @param \WorkBundle\Entity\Education $education
     * @return EducationLevel
     */
    public function addEducation(\WorkBundle\Entity\Education $education)
    {
        $this->education[] = $education;

        return $this;
    }

    /**
     * Remove education
     *
     * @param \WorkBundle\Entity\Education $education
     */
    public function removeEducation(\WorkBundle\Entity\Education $education)
    {
        $this->education->removeElement($education);
    }
}
