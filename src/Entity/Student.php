<?php

namespace LeoDoctrineBug\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Book", mappedBy="student", cascade={"persist"})
     * @var Book[]|ArrayCollection
     */
    protected $books;

    /**
     * @ORM\OneToMany(targetEntity="Gadget", mappedBy="student", cascade={"persist"})
     * @var Gadget[]|ArrayCollection
     */
    protected $gadgets;

    public function __construct()
    {
        $this->books = new ArrayCollection();
        $this->gadgets = new ArrayCollection();
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return ArrayCollection|Book[]
     */
    public function getBooks()
    {
        return $this->books;
    }

    /**
     * @param Book $book
     */
    public function addBook(Book $book)
    {
        $this->books->add($book);
    }

    /**
     * @return ArrayCollection|Gadget[]
     */
    public function getGadgets()
    {
        return $this->gadgets;
    }

    /**
     * @param Gadget $gadget
     */
    public function addGadget(Gadget $gadget)
    {
        $this->gadgets->add($gadget);
    }
}