<?php

namespace WorkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="employer")
 */
class Employer
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
     * @ORM\Column(type="date", nullable=true)
     */
    protected $termFrom;
    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $termTo;
    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $priceFrom;
    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $priceTo;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $ageFrom;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $ageTo;
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $city;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $aboutMe;
    /**
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="employers")
     * @ORM\JoinTable(name="employer_categories",
     * joinColumns={@ORM\JoinColumn(name="employer_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")})
     */
    protected $categories;
    /**
     * @ORM\Column(type="date")
     */
    protected $postDate;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Employer
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
     * Set termFrom
     *
     * @param \DateTime $termFrom
     * @return Employer
     */
    public function setTermFrom($termFrom)
    {
        $this->termFrom = $termFrom;

        return $this;
    }

    /**
     * Get termFrom
     *
     * @return \DateTime
     */
    public function getTermFrom()
    {
        return $this->termFrom;
    }

    /**
     * Set termTo
     *
     * @param \DateTime $termTo
     * @return Employer
     */
    public function setTermTo($termTo)
    {
        $this->termTo = $termTo;

        return $this;
    }

    /**
     * Get termTo
     *
     * @return \DateTime
     */
    public function getTermTo()
    {
        return $this->termTo;
    }

    /**
     * Set ageFrom
     *
     * @param integer $ageFrom
     * @return Employer
     */
    public function setAgeFrom($ageFrom)
    {
        $this->ageFrom = $ageFrom;

        return $this;
    }

    /**
     * Get ageFrom
     *
     * @return integer
     */
    public function getAgeFrom()
    {
        return $this->ageFrom;
    }

    /**
     * Set ageTo
     *
     * @param integer $ageTo
     * @return Employer
     */
    public function setAgeTo($ageTo)
    {
        $this->ageTo = $ageTo;

        return $this;
    }

    /**
     * Get ageTo
     *
     * @return integer
     */
    public function getAgeTo()
    {
        return $this->ageTo;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Employer
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
     * @return Employer
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
     * @return Employer
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
     * Set priceFrom
     *
     * @param float $priceFrom
     * @return Employer
     */
    public function setPriceFrom($priceFrom)
    {
        $this->priceFrom = $priceFrom;

        return $this;
    }

    /**
     * Get priceFrom
     *
     * @return float
     */
    public function getPriceFrom()
    {
        return $this->priceFrom;
    }

    /**
     * Set priceTo
     *
     * @param float $priceTo
     * @return Employer
     */
    public function setPriceTo($priceTo)
    {
        $this->priceTo = $priceTo;

        return $this;
    }

    /**
     * Get priceTo
     *
     * @return float
     */
    public function getPriceTo()
    {
        return $this->priceTo;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Employer
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
     * @return Employer
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
     * @return Employer
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
     * Set postDate
     *
     * @param \DateTime $postDate
     * @return Employer
     */
    public function setPostDate($postDate)
    {
        $this->postDate = $postDate;

        return $this;
    }

    /**
     * Get postDate
     *
     * @return \DateTime
     */
    public function getPostDate()
    {
        return $this->postDate;
    }

    /**
     * Get all employers by filter post params
     *
     * @param Request                                                                       $request
     * @param \Doctrine\Common\Persistence\ObjectManager|\Doctrine\ORM\EntityManager|object $entityManager
     * @param bool $post
     * @return array
     */
    public function getAllEmployersByFilter(Request $request, $entityManager, $post = true)
    {
        $employersRepository = $entityManager->getRepository('WorkBundle:Employer');
        if($post == true) {
            $filterData          = $request->request->all();
        } else {
            $filterData          = $request->query->all();
        }
        if ($filterData) {
            if (!empty($filterData['city']) || !empty($filterData['ageFrom']) || !empty($filterData['ageTo'])
                || !empty($filterData['priceFrom']) || !empty($filterData['priceTo'])
                || !empty($filterData['termFrom']) || !empty($filterData['termTo'])
                || (!empty($filterData['gender']) && $filterData['gender'][0] != 'all')
                || (!empty($filterData['categories']) && $filterData['categories'][0] != 'all')
            ) {
                $whereCondition = '';
                $employerModels = $employersRepository->createQueryBuilder('p');
                if ($filterData['city']) {
                    $employerModels->setParameter('city', $filterData['city']);
                    $whereCondition .= 'p.city = :city AND ';
                }
                if (!empty($filterData['ageFrom'])) {
                    $employerModels->setParameter('ageFrom', $filterData['ageFrom']);
                    $whereCondition .= 'p.ageFrom >= :ageFrom AND ';
                }
                if (!empty($filterData['ageTo'])) {
                    $employerModels->setParameter('ageTo', $filterData['ageTo']);
                    $whereCondition .= 'p.ageTo <= :ageTo AND ';
                }
                if (!empty($filterData['priceFrom'])) {
                    $employerModels->setParameter('priceFrom', $filterData['priceFrom']);
                    $whereCondition .= 'p.priceFrom >= :priceFrom AND ';
                }
                if (!empty($filterData['priceTo'])) {
                    $employerModels->setParameter('priceTo', $filterData['priceTo']);
                    $whereCondition .= 'p.priceTo <= :priceTo AND ';
                }
                if (!empty($filterData['gender']) && $filterData['gender'][0] != 'all') {
                    $employerModels->setParameter('gender', $filterData['gender'][0]);
                    $whereCondition .= 'p.gender = :gender AND ';
                }
                if (!empty($filterData['termFrom'])&&$filterData['termFrom'] != '') {
                    $employerModels->setParameter('termFrom', $filterData['termFrom']);
                    $whereCondition .= 'p.termFrom <= :termFrom AND ';
                }
                if (!empty($filterData['termFrom'])&&$filterData['termTo'] != '') {
                    $employerModels->setParameter('termTo', $filterData['termFrom']);
                    $whereCondition .= 'p.termTo >= :termTo AND ';
                }
                if ($whereCondition == '') {
                    $employers = $employersRepository->findBy(array(), array('postDate' => 'DESC'));
                } else {
                    $employerModels->where(substr($whereCondition, 0, -5))->orderBy('p.postDate', 'DESC');
                    $employers = $employerModels->getQuery()->getResult();
                }
                if (isset($filterData['categories']) && $filterData['categories'][0] != 'all') {
                    $categoryModel = new Category();
                    /** @var \WorkBundle\Entity\Employer $employer */
                    foreach ($employers as $key => $employer) {
                        foreach($filterData['categories'] as $category) {
                            $curCategories = $employer->getCategories()->getValues();
                            if(!in_array($categoryModel->find($category, $entityManager), $curCategories)){
                                unset($employers[$key]);
                            }
                        }
                    }
                }
                return $employers;
            } else {
                $employerModels = $employersRepository->findBy(array(), array('postDate' => 'DESC'));
            }
        } else {
            $employerModels = $employersRepository->findBy(array(), array('postDate' => 'DESC'));
        }
        return $employerModels;
    }

    /**
     * @param int $employerId
     * @param \Doctrine\Common\Persistence\ObjectManager|\Doctrine\ORM\EntityManager|object $entityManager
     * @return array
     */
    public function getCategoriesForEmployer($employerId, $entityManager)
    {
        $employerRepository = $entityManager->getRepository('WorkBundle:Employer')->findOneBy(
            array('id' => $employerId)
        );
        $categoryModels   = $employerRepository->getCategories()->getValues();
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

    /**
     * Employer saving by data filled in the form
     *
     * @param array $formData
     * @param \Doctrine\Common\Persistence\ObjectManager|\Doctrine\ORM\EntityManager|object $em
     */
    public function saveEmployer($formData, $em)
    {
        /** @var \WorkBundle\Entity\Gender $gender */
        $gender = $em->getRepository('WorkBundle:Gender')->find($formData['gender']);
        $employer = new Employer();
        $employer->setFirstName($formData['firstName'])
            ->setLastName($formData['lastName'])
            ->setPhone($formData['phone'])
            ->setGender($gender);
        if($formData['city']){
            $employer->setCity($formData['city']);
        }
        if(!empty($formData['termFrom'])){
            $date = new \DateTime($formData['termFrom']);
            $employer->setTermFrom($date);
        }
        if(!empty($formData['termTo'])){
            $date = new \DateTime($formData['termTo']);
            $employer->setTermTo($date);
        }
        if (!empty($formData['ageFrom'])) {
           $employer->setAgeFrom($formData['ageFrom']);
        }
        if (!empty($formData['ageTo'])) {
            $employer->setAgeTo($formData['ageTo']);
        }
        if (!empty($formData['priceFrom'])) {
            $employer->setPriceFrom($formData['priceFrom']);
        }
        if (!empty($formData['priceTo'])) {
            $employer->setPriceTo($formData['priceTo']);
        }
        if(!empty($formData['aboutMe'])){
            $employer->setAboutMe($formData['aboutMe']);
        }
        if(isset($formData['categories'])){
            foreach ($formData['categories'] as $category){
                /** @var \WorkBundle\Entity\Category $categoryEntity */
                $categoryEntity = $em->getRepository('WorkBundle:Category')->find($category);
                $employer->addCategory($categoryEntity);
            }
        }
        $employer->setPostDate(new \DateTime());
        $em->persist($employer);
        $em->flush();
    }

    /**
     * Generate array of employers for view
     *
     * @param $employersModels
     * @param \Doctrine\Common\Persistence\ObjectManager|\Doctrine\ORM\EntityManager|object $entityManager
     * @return array
     */
    public function generateEmployersArray($employersModels, $entityManager)
    {
        $employers = array();
        $employerModel = new Employer();
        /** @var \WorkBundle\Entity\Employer $employer */
        foreach ($employersModels as $employer) {
            $employers[] = array(
                'id' => $employer->getId(),
                'name' => $employer->getFirstName() . ' ' . $employer->getLastName(),
                'phone' => $employer->getPhone(),
                'city' => $employer->getCity(),
                'aboutMe' => $employer->getAboutMe(),
                'ageFrom' => $employer->getAgeFrom(),
                'ageTo' => $employer->getAgeTo(),
                'priceFrom' => $employer->getPriceFrom(),
                'priceTo' => $employer->getPriceTo(),
                'termFrom' => $employer->getTermFrom()?$employer->getTermFrom()->format('Y-m-d'): 'Employer didn`t specified term from.',
                'termTo' => $employer->getTermTo()?$employer->getTermTo()->format('Y-m-d'): 'Employer didn`t specified term to.',
                'categories' => $employerModel->getCategoriesForEmployer($employer->getId(), $entityManager),
                'postDate' => $employer->getPostDate()->format('Y-m-d'),
            );
        }
        return $employers;
    }
}
