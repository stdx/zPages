<?php

namespace Company\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="product_template")
 */
class ProductTemplate {
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
}