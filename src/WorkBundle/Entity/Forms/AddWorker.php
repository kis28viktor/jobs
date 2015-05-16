<?php
namespace WorkBundle\Entity\Forms;

/**
 * Class AddWorker
 *
 * @package WorkBundle\Entity\Forms
 */
class AddWorker
{
    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $phone
     */
    protected $phone;

    /**
     * @var int $age
     */
    protected $age;

    /**
     * @var string $city
     */
    protected $city;

    /**
     * @var string $aboutMe
     */
    protected $aboutMe;

    /**
     * @var array $categories
     */
    protected $categories;
    /**
     * @var string $education
     */
    protected $education;
    /**
     * @var string $educationLevel
     */
    protected $educationLevel;
    /**
     * @var string $educationCity
     */
    protected $educationCity;

    /**
     * Get education city
     *
     * @return string
     */
    public function getEducationCity()
    {
        return $this->educationCity;
    }

    /**
     * Set education city
     *
     * @param string $educationCity
     * @return $this
     */
    public function setEducationCity($educationCity)
    {
        $this->educationCity = $educationCity;
        return $this;
    }

    /**
     * Get education level
     *
     * @return string
     */
    public function getEducationLevel()
    {
        return $this->educationLevel;
    }

    /**
     * Set education level
     *
     * @param string $educationLevel
     * @return $this
     */
    public function setEducationLevel($educationLevel)
    {
        $this->educationLevel = $educationLevel;
        return $this;
    }

    /**
     * Get education name
     *
     * @return array
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * Set education name
     *
     * @param string $education
     * @return $this
     */
    public function setEducation($education)
    {
        $this->education = $education;
        return $this;
    }

    /**
     * Get categories
     *
     * @return array
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set categories
     *
     * @param object $val
     * @return $this
     */
    public function setCategories($val)
    {
        $this->categories = $val;
        return $this;
    }

    /**
     * Set workers name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set workers name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get workers phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set workers phone
     *
     * @param string $phone
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * Get workers age
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set workers age
     *
     * @param int $age
     * @return $this
     */
    public function setAge($age)
    {
        $this->age = $age;
        return $this;
    }

    /**
     * Get workers city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set workers city
     *
     * @param string $city
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Get workers bio
     *
     * @return string
     */
    public function getAboutMe()
    {
        return $this->aboutMe;
    }

    /**
     * Set workers bio
     *
     * @param string $info
     * @return $this
     */
    public function setAboutMe($info)
    {
        $this->aboutMe = $info;
        return $this;
    }
}
