<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Operation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\OperationRepository")
 */
class Operation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;


    /**
     * @var string
     *
     * @ORM\Column(name="nomComplet", type="string", length=255)
     */
    private $nomComplet;

    /**
     * @var string
     *
     * @ORM\Column(name="action", type="string", length=255)
     */
    private $action;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="entity", type="array")
     */
    private $entity;


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
     * Set username
     *
     * @param string $username
     *
     * @return Operation
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getNomComplet()
    {
        return $this->nomComplet;
    }

    /**
     * @param string $nomComplet
     */
    public function setNomComplet($nomComplet)
    {
        $this->nomComplet = $nomComplet;
    }



    /**
     * Set action
     *
     * @param string $action
     *
     * @return Operation
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Operation
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = new \Datetime();

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set entity
     *
     * @param \stdClass $entity
     *
     * @return Operation
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return \stdClass
     */
    public function getEntity()
    {
        return $this->entity;
    }
}

