<?php

namespace Company\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="company")
 */
class Company {
  
  /**
   *
   * @ORM\Id
   * @ORM\Column(type="integer", nullable=false)
   * @ORM\GeneratedValue(strategy="AUTO")
   *
   * @var integer
   */
  protected $id;
  
  /**
   * @ORM\Column(type="string" ,length=255)
   *
   * @var string
   */
  protected $name;
  
  /**
   *
   * @@ORM\Mapping\Column(type="text")
   *
   * @var string
   */
  protected $description;
  
  /**
   * @ORM\OneToMany(targetEntity="Product", mappedBy="company", cascade={"persist"})
   *
   * @var Product[]
   */
  protected $products;
  public function __construct() {
    $this->products = new \Doctrine\Common\Collections\ArrayCollection();
  }
  public function getId() {
    return $this->id;
  }
  public function setId($id) {
    $this->id = $id;
  }
  public function setName($name) {
    $this->name = $name;
  }
  public function getName() {
    return $this->name;
  }
  public function getDescription() {
    return $this->description;
  }
  public function setDescription($description) {
    $this->description = $description;
  }
  public function getProducts() {
    return $this->products;
  }
  public function setProducts($products) {
    $this->products = $products;
  }
}
    
