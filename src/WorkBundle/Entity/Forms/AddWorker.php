<?php
namespace WorkBundle\Entity\Forms;

class AddWorker
{
    protected $name;

    protected $phone;

    protected $age;

    protected $city;

    protected $aboutMe;


    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function setAge($age)
    {
        $this->age = $age;
        return $this;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    public function getAboutMe()
    {
        return $this->aboutMe;
    }

    public function setAboutMe($info)
    {
        $this->aboutMe = $info;
        return $this;
    }
}
