<?php


namespace User\Model;

/**
 * Class User
 * @package User\Model
 */
class User
{
    private $id;
    private $name;
    private $eduid;
    private $education;
    private $sities;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getEduId()
    {
        return $this->eduid;
    }

    /**
     * @return mixed
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * @return mixed
     */
    public function getSities()
    {
        return $this->sities;
    }

}
