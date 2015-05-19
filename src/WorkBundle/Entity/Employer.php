<?php

namespace WorkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="employer")
 */
class Employer {
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
     * @ORM\Column(type="date")
     */
    protected $termFrom;
    /**
     * @ORM\Column(type="date")
     */
    protected $termTo;
    /**
     * @ORM\Column(type="float")
     */
    protected $priceFrom;
    /**
     * @ORM\Column(type="float")
     */
    protected $priceTo;
    /**
     * @ORM\Column(type="integer")
     */
    protected $ageFrom;
    /**
     * @ORM\Column(type="integer")
     */
    protected $ageTo;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $city;
    /**
     * @ORM\Column(type="string", length=1000)
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
}
