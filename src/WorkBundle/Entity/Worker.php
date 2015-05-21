<?php

namespace WorkBundle\Entity;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="worker")
 */
class Worker {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $firstName;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $lastName;
    /**
     * @ORM\ManyToOne(targetEntity="Gender")
     */
    protected $gender;
    /**
     * @ORM\Column(type="string", length=50);
     */
    protected $phone;
    /**
     * @ORM\Column(type="integer")
     */
    protected $age;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $city;
    /**
     * @ORM\Column(type="string", length=1000)
     */
    protected $aboutMe;
    /**
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="workers")
     * @ORM\JoinTable(name="workers_categories",
     * joinColumns={@ORM\JoinColumn(name="worker_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")})
     */
    protected $categories;
    /**
     * @ORM\ManyToMany(targetEntity="Education", inversedBy="workers")
     * @ORM\JoinTable(name="workers_education",
     * joinColumns={@ORM\JoinColumn(name="worker_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="education_id", referencedColumnName="id")})
     */
    protected $education;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->education = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set phone
     *
     * @param string $phone
     * @return Worker
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set age
     *
     * @param integer $age
     * @return Worker
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Worker
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
     * Set aboutMe
     *
     * @param string $aboutMe
     * @return Worker
     */
    public function setAboutMe($aboutMe)
    {
        $this->aboutMe = $aboutMe;

        return $this;
    }

    /**
     * Get aboutMe
     *
     * @return string
     */
    public function getAboutMe()
    {
        return $this->aboutMe;
    }

    /**
     * Add categories
     *
     * @param \WorkBundle\Entity\Category $categories
     * @return Worker
     */
    public function addCategory(\WorkBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \WorkBundle\Entity\Category $categories
     */
    public function removeCategory(\WorkBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add education
     *
     * @param \WorkBundle\Entity\Education $education
     * @return Worker
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

    /**
     * Get education
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Worker
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Worker
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set gender
     *
     * @param \WorkBundle\Entity\Gender $gender
     * @return Worker
     */
    public function setGender(\WorkBundle\Entity\Gender $gender = null)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return \WorkBundle\Entity\Gender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Get workers with checking post params
     *
     * @param Request $request
     * @param \Doctrine\Common\Persistence\ObjectManager|\Doctrine\ORM\EntityManager|object $entityManager
     * @return array
     */
    public function getAllWorkersWithPostFilter(Request $request, $entityManager)
    {
        $workersRepository = $entityManager->getRepository('WorkBundle:Worker');
        $filterData        = $request->request->all();
        if ($filterData) {
            if (!empty($filterData['city']) || !empty($filterData['ageFrom']) || !empty($filterData['ageTo'])
                || (!empty($filterData['gender'])&& $filterData['gender'][0] != 'all')
            ) {
                $whereCondition = '';
                $workerModels   = $workersRepository->createQueryBuilder('p');
                if ($filterData['city']) {
                    $workerModels->setParameter('city', $filterData['city']);
                    $whereCondition .= 'p.city = :city AND ';
                }
                if ($filterData['ageFrom']) {
                    $workerModels->setParameter('ageFrom', $filterData['ageFrom']);
                    $whereCondition .= 'p.age >= :ageFrom AND ';
                }
                if ($filterData['ageTo']) {
                    $workerModels->setParameter('ageTo', $filterData['ageTo']);
                    $whereCondition .= 'p.age <= :ageTo AND ';
                }
                if (isset($filterData['gender']) && $filterData['gender'][0] != 'all') {
                    $workerModels->setParameter('gender', $filterData['gender'][0]);
                    $whereCondition .= 'p.gender = :gender AND ';
                }
                $workerModels->where(substr($whereCondition, 0, -5));
                $workers = $workerModels->getQuery()->getResult();
                return $workers;
            } else {
                $workerModels = $workersRepository->findAll();
            }
        } else {
            $workerModels = $workersRepository->findAll();
        }
        return $workerModels;
    }
    /**
     * @param int $workerId
     * @param \Doctrine\Common\Persistence\ObjectManager|\Doctrine\ORM\EntityManager|object $entityManager
     * @return array
     */
    public function getEducationForWorker($workerId, $entityManager)
    {
        $workerRepository = $entityManager->getRepository('WorkBundle:Worker')->findOneBy(
            array('id' => $workerId)
        );
        $educationModels  = $workerRepository->getEducation()->getValues();
        if ($educationModels) {
            $educations = array();
            /** @var \WorkBundle\Entity\Education $education */
            foreach ($educationModels as $education) {
                /** @var \WorkBundle\Entity\EducationLevel $educationLevel */
                $educationLevel = $education->getLevel();
                $educations[]   = array(
                    'name'  => $education->getName(),
                    'level' => $educationLevel->getName(),
                    'city'  => $education->getCity(),
                );
            }
            return $educations;
        } else {
            return array('No education');
        }
    }

    /**
     * @param int $workerId
     * @param \Doctrine\Common\Persistence\ObjectManager|\Doctrine\ORM\EntityManager|object $entityManager
     * @return array
     */
    public function getCategoriesForWorker($workerId, $entityManager)
    {
        $workerRepository = $entityManager->getRepository('WorkBundle:Worker')->findOneBy(
            array('id' => $workerId)
        );
        $categoryModels   = $workerRepository->getCategories()->getValues();
        $categories       = array();
        if ($categoryModels) {
            /** @var \WorkBundle\Entity\Category $category */
            foreach ($categoryModels as $category) {
                $categories[] = array(
                    'name' => $category->getName(),
                );
            }
            return $categories;
        } else {
            return array('The user didn`t chose any category.');
        }
    }
}
