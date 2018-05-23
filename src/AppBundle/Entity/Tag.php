<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tag
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TagRepository")
 */
class Tag
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tag", type="string", length=50, unique=true)
     */
    private $tag;

    /**
     * @ORM\ManyToMany(targetEntity="Equipo", mappedBy="tags")
     */
    private $equipos;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->equipos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set tag
     *
     * @param string $tag
     *
     * @return Tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Add equipo
     *
     * @param \AppBundle\Entity\Equipo $equipo
     *
     * @return Tag
     */
    public function addEquipo(\AppBundle\Entity\Equipo $equipo)
    {
        $this->equipos[] = $equipo;
        $equipo->addTag($this);

        return $this;
    }

    /**
     * Remove equipo
     *
     * @param \AppBundle\Entity\Equipo $equipo
     */
    public function removeEquipo(\AppBundle\Entity\Equipo $equipo)
    {
        $this->equipos->removeElement($equipo);
        $equipo->removeTag($this);
    }

    /**
     * Get equipos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEquipos()
    {
        return $this->equipos;
    }

    public function __toString()
    {
        return $this->tag;
    }


}
