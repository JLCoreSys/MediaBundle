<?php

namespace CoreSys\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Flash
 *
 * @ORM\Table(name="flash")
 * @ORM\Entity(repositoryClass="CoreSys\MediaBundle\Entity\FlashRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Flash
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
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updated_at;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255, nullable=true)
     */
    private $filename;

    /**
     * @var integer
     *
     * @ORM\Column(name="width", type="integer", nullable=true)
     */
    private $width;

    /**
     * @var integer
     *
     * @ORM\Column(name="height", type="integer", nullable=true)
     */
    private $height;

    /**
     * @var array
     *
     * @ORM\Column(name="sizes", type="array", nullable=true)
     */
    private $sizes;

    /**
     * @var mixed
     */
    private $file;

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile( $file = NULL )
    {
        $this->file = $file;
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
     * Get created_at
     *
     * @param string $format
     * @return \DateTime
     */
    public function getCreatedAt( $format = NULL )
    {
        return !empty( $format ) ? $this->created_at->format( $format ) : $this->created_at;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     *
     * @return Flash
     */
    public function setCreatedAt( $createdAt = NULL )
    {
        if( empty( $createdAt ) )
        {
            $createdAt = new \DateTime();
        }
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get updated_at
     *
     * @param string $format
     * @return \DateTime
     */
    public function getUpdatedAt( $format = NULL )
    {
        return !empty( $format ) ? $this->updated_at->format( $format ) : $this->updated_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     *
     * @return Flash
     */
    public function setUpdatedAt( $updatedAt = NULL )
    {
        if( empty( $updatedAt ) )
        {
            $updatedAt = new \DateTime();
        }
        $this->updated_at = $updatedAt;

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
     * Set title
     *
     * @param string $title
     *
     * @return Flash
     */
    public function setTitle( $title = NULL )
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active === TRUE;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Flash
     */
    public function setActive( $active = TRUE )
    {
        $this->active = $active === TRUE;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set filename
     *
     * @param string $filename
     *
     * @return Flash
     */
    public function setFilename( $filename = NULL )
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get width
     *
     * @return integer
     */
    public function getWidth()
    {
        return intval( $this->width );
    }

    /**
     * Set width
     *
     * @param integer $width
     *
     * @return Flash
     */
    public function setWidth( $width )
    {
        $this->width = intval( $width );

        return $this;
    }

    /**
     * Get height
     *
     * @return integer
     */
    public function getHeight()
    {
        return intval( $this->height );
    }

    /**
     * Set height
     *
     * @param integer $height
     *
     * @return Flash
     */
    public function setHeight( $height = NULL )
    {
        $this->height = intval( $height );

        return $this;
    }

    /**
     * Get sizes
     *
     * @return array
     */
    public function getSizes()
    {
        if( !is_array( $this->sizes ) )
        {
            $this->sizes = $this->getDefaultSizes();
        }
        return $this->sizes;
    }

    /**
     * Set sizes
     *
     * @param array $sizes
     *
     * @return Flash
     */
    public function setSizes( $sizes )
    {
        $sizes = is_array( $sizes ) ? $sizes : $this->getDefaultSizes();

        $this->sizes = $sizes;

        return $this;
    }

    public function getDefaultSizes()
    {
        return array(
            'thumb' => 150,
            'small' => 300,
            'medium' => 640,
            'large' => 1024
        );
    }

    public function __construct()
    {
        $this->setCreatedAt( new \DateTime() );
        $this->setUpdatedAt( new \DateTime() );
        $this->setActive( TRUE );
        $this->setWidth( -1 );
        $this->setHeight( -1 );
    }

    /**
     * @ORM\PrePersist
     */
    public function PrePersist()
    {
        $this->setUpdatedAt( new \DateTime() );
    }
}
