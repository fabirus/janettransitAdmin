<?php

namespace Application\Sonata\UserBundle\Entity;

use Sonata\UserBundle\Entity\BaseUser as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;


    /**
     * @ORM\Entity
     * @Vich\Uploadable
     */
class User extends BaseUser
{
    /**
     * @var integer $id
     */
    protected $id;


    /**
     *
     * @Vich\UploadableField(mapping="user_image", fileNameProperty="imageName")
     * @Assert\File(
     * maxSize="2M",
     * maxSizeMessage = "Taille max 2Mo",
     * mimeTypes = {"image/jpeg", "image/png"},
     * mimeTypesMessage = "Uploader une image au format jpg ou png"
     * )
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;


    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     * @param File $image
     */
    public function setImageFile($image)
    {
        $this->imageFile = $image;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }
















}