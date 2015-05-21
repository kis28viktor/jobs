<?php
namespace WorkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="education")
 */
class Education {
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
     * @ORM\ManyToOne(targetEntity="EducationLevel")
     */
    protected $level;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $city;
    /**
     * @ORM\ManyToMany(targetEntity="Worker", mappedBy="education")
     */
    protected $workers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->workers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Education
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
     * Set city
     *
     * @param string $city
     * @return Education
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Add workers
     *
     * @param \WorkBundle\Entity\Worker $workers
     * @return Education
     */
    public function addWorker(\WorkBundle\Entity\Worker $workers)
    {
        $this->workers[] = $workers;

        return $this;
    }

    /**
     * Remove workers
     *
     * @param \WorkBundle\Entity\Worker $workers
     */
    public function removeWorker(\WorkBundle\Entity\Worker $workers)
    {
        $this->workers->removeElement($workers);
    }

    /**
     * Get workers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWorkers()
    {
        return $this->workers;
    }

    /**
     * Set level
     *
     * @param \WorkBundle\Entity\EducationLevel $level
     * @return Education
     */
    public function setLevel(\WorkBundle\Entity\EducationLevel $level = null)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return \WorkBundle\Entity\EducationLevel
     */
    public function getLevel()
    {
        return $this->level;
    }
}
