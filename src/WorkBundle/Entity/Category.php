<?php
namespace WorkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category {
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
     * @ORM\ManyToMany(targetEntity="Worker", mappedBy="categories")
     */
    protected $workers;
    /**
     * @ORM\ManyToMany(targetEntity="Employer", mappedBy="categories")
     */
    protected $employers;

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
     * @return Category
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
     * Constructor
     */
    public function __construct()
    {
        $this->workers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->employers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add workers
     *
     * @param \WorkBundle\Entity\Worker $workers
     * @return Category
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
     * Add employers
     *
     * @param \WorkBundle\Entity\Employer $employers
     * @return Category
     */
    public function addEmployer(\WorkBundle\Entity\Employer $employers)
    {
        $this->employers[] = $employers;

        return $this;
    }

    /**
     * Remove employers
     *
     * @param \WorkBundle\Entity\Employer $employers
     */
    public function removeEmployer(\WorkBundle\Entity\Employer $employers)
    {
        $this->employers->removeElement($employers);
    }

    /**
     * Get employers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmployers()
    {
        return $this->employers;
    }

    /**
     * Get all possible categories
     *
     * @param \Doctrine\Common\Persistence\ObjectManager|\Doctrine\ORM\EntityManager|object $entityManager
     * @return array
     */
    public function getAllCategories($entityManager)
    {
        $categoryRepository = $entityManager->getRepository('WorkBundle:Category');
        $categoryModels = $categoryRepository->findAll();
        $categories = array();
        if($categoryModels){
            /** @var \WorkBundle\Entity\Category $category */
            foreach ($categoryModels as $category) {
                $categories[$category->getId()] = $category->getName();
            }
        }
        return $categories;
    }
}
