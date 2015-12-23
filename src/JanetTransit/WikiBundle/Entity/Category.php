<?php

namespace JanetTransit\WikiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="JanetTransit\WikiBundle\Entity\CategoryRepository")
 */
class Category
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
     * @ORM\OneToMany(targetEntity="Article", mappedBy="category", cascade={"persist"})
     */
    private $articles;


    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     **/
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children", cascade={"persist"})
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     **/
    private $parent;


    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="span_class", type="string", length=255)
     */
    private $spanClass;

    /**
     * @var string
     *
     * @ORM\Column(name="i_class", type="string", length=255)
     */
    private $iClass;

    // constructeur
    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    public function __toString(){
        return $this->name;
        return $this->parent;

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
     * @return string
     */
    public function getSpanClass()
    {
        return $this->spanClass;
    }

    /**
     * @param string $spanClass
     */
    public function setSpanClass($spanClass)
    {
        $this->spanClass = $spanClass;
    }

    /**
     * @return string
     */
    public function getIClass()
    {
        return $this->iClass;
    }

    /**
     * @param string $iClass
     */
    public function setIClass($iClass)
    {
        $this->iClass = $iClass;
    }


    /**
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param mixed $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }


    /**
     * @return mixed
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param mixed $articles
     */
    public function setArticles($articles)
    {
        $this->articles = $articles;
    }


    /**
     * Set name
     *
     * @param string $name
     *
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
     * Set description
     *
     * @param string $description
     *
     * @return Category
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}

