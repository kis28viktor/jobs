<?php

namespace WorkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="gender")
 */
class Gender
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
     * @return Gender
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
     * Get all possible genders from database in array
     *
     * @param \Doctrine\Common\Persistence\ObjectManager|\Doctrine\ORM\EntityManager|object $entityManager
     * @return array
     */
    public function getAllGendersArray($entityManager)
    {
        $gendersRepository = $entityManager->getRepository('WorkBundle:Gender');
        $genderModels     = $gendersRepository->findAll();
        $genders          = array();
        if ($genderModels) {
            /** @var \WorkBundle\Entity\Gender $gender */
            foreach ($genderModels as $gender) {
                $genders[$gender->getId()] = $gender->getName();
            }
        }
        return $genders;
    }
}
