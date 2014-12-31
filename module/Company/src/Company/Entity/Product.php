<?php

namespace Company\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 */
class Product {
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
   * @ORM\ManyToOne(targetEntity="Company", inversedBy="products", cascade={"persist"})
   * @ORM\JoinColumn(name="company_id", referencedColumnName="id", unique=false, nullable=false)
   */
  protected $company;
  
  /**
   *
   * @@ORM\Mapping\Column(type="text")
   *
   * @var string
   */
  protected $description;
  
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
  public function getCompany() {
    return $this->company;
  }
  public function setCompany($company) {
    $this->company = $company;
  }
  
}