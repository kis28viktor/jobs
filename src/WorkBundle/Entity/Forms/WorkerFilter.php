<?php
namespace WorkBundle\Entity\Forms;
/**
 * Class WorkerFilter
 *
 * @package WorkBundle\Entity\Forms
 */
class WorkerFilter
{
    /**
     * @var string $city
     */
    protected $city;
    /**
     * @var int $ageFrom
     */
    protected $ageFrom;
    /**
     * @var int $ageTo
     */
    protected $ageTo;

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
     * Set city
     *
     * @param  string $city
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Get ageFrom
     *
     * @return int
     */
    public function getAgeFrom()
    {
        return $this->ageFrom;
    }

    /**
     * Set ageFrom
     *
     * @param int $age
     * @return $this
     */
    public function setAgeFrom($age)
    {
        $this->ageFrom = $age;
        return $this;
    }

    /**
     * Get ageTo
     *
     * @return int
     */
    public function getAgeTo()
    {
        return $this->ageTo;
    }

    /**
     * Set ageTo
     *
     * @param int $age
     * @return $this
     */
    public function setAgeTo($age)
    {
        $this->ageTo = $age;
        return $this;
    }
}
