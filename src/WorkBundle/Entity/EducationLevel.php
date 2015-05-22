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
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

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
}
