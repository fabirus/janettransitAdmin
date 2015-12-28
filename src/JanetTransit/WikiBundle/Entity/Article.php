<?php

namespace JanetTransit\WikiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="JanetTransit\WikiBundle\Entity\ArticleRepository")
 * @Vich\Uploadable
 */
class Article
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="raw_content", type="text", nullable =true)
     */
    private $rawContent;


    /**
     * @var string
     *
     * @ORM\Column(name="content_formatter", type="text", nullable=true)
     */
    private $contentFormatter;


    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="articles")
     */
    private $category;


    /**
     *
     * @Vich\UploadableField(mapping="article_file", fileNameProperty="articleFileName")
     * @Assert\File(
     * maxSize="2M",
     * maxSizeMessage = "Taille max 2Mo",
     * mimeTypes = {"image/jpeg", "image/png"},
     * mimeTypesMessage = "Uploader une image au format jpg ou png"
     * )
     *
     * @var File
     */
    private $articleFile;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $articleFileName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = new \Datetime();
    }

    /**
     * @return File
     */
    public function getArticleFile()
    {
        return $this->articleFile;
    }

    /**
     * @param File $articleFile
     */
    public function setArticleFile($articleFile)
    {
        $this->articleFile = $articleFile;
    }

    /**
     * @return string
     */
    public function getArticleFileName()
    {
        return $this->articleFileName;
    }

    /**
     * @param string $articleFileName
     */
    public function setArticleFileName($articleFileName)
    {
        $this->articleFileName = $articleFileName;
    }


//    /**
//     * @ORM\OneToOne(targetEntity="\Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"})
//     */
//    private $image;

//    /**
//     * @return mixed
//     */
//    public function getImage()
//    {
//        return $this->image;
//    }
//
//    /**
//     * @param mixed $image
//     */
//    public function setImage($image)
//    {
//        $this->image = $image;
//    }



    /**
     * @return mixed
     */
    public function getRawContent()
    {
        return $this->rawContent;
    }

    /**
     * @param mixed $rawContent
     */
    public function setRawContent($rawContent)
    {
        $this->rawContent = $rawContent;
    }

    /**
     * @return mixed
     */
    public function getContentFormatter()
    {
        return $this->contentFormatter;
    }

    /**
     * @param mixed $contentFormatter
     */
    public function setContentFormatter($contentFormatter)
    {
        $this->contentFormatter = $contentFormatter;
    }



    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
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
     * Set title
     *
     * @param string $title
     *
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
}

