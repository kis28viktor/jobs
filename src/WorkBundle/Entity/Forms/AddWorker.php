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
     * @var array|object $categories
     */
    protected $categories;

    /**
     * Get categories
     *
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set categories
     *
     * @param object|array $val
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
