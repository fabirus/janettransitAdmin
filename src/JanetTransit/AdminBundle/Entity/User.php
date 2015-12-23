<?php
//
//namespace JanetTransit\AdminBundle\Entity;
//
//use Sonata\UserBundle\Entity\BaseUser;
//use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Validator\Constraints as Assert;
//
//
///**
// * User
// *
// * @ORM\Table()
// * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\UserRepository")
// * @ORM\Entity
// */
//class User extends BaseUser
//{
//    /**
//     * @var integer
//     *
//     * @ORM\Column(name="id", type="integer")
//     * @ORM\Id
//     * @ORM\GeneratedValue(strategy="AUTO")
//     */
//    protected $id;
//
//
//    /**
//     * @ORM\Column(type="string", length=255, nullable=true)
//     */
//    public $path;
//
//    public function getAbsolutePath()
//    {
//        return null === $this->path
//            ? null
//            : $this->getUploadRootDir().'/'.$this->path;
//    }
//
//    public function getWebPath()
//    {
//        return null === $this->path
//            ? null
//            : $this->getUploadDir().'/'.$this->path;
//    }
//
//    protected function getUploadRootDir()
//    {
//        // the absolute directory path where uploaded
//        // documents should be saved
//        return __DIR__.'/../../../../web/'.$this->getUploadDir();
//    }
//
//    protected function getUploadDir()
//    {
//        // get rid of the __DIR__ so it doesn't screw up
//        // when displaying uploaded doc/image in the view.
//        return 'uploads/documents';
//    }
//
//    /**
//     * @Assert\File(maxSize="6000000")
//     */
//    private $file;
//
//    /**
//     * Sets file.
//     *
//     * @param UploadedFile $file
//     */
//    public function setFile(UploadedFile $file = null)
//    {
//        $this->file = $file;
//    }
//
//    /**
//     * Get file.
//     *
//     * @return UploadedFile
//     */
//    public function getFile()
//    {
//        return $this->file;
//    }
//
//    /**
//     * @return int
//     */
//    public function getId()
//    {
//        return $this->id;
//    }
//
//
//
//
//
//
//
//}