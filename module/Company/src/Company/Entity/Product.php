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
   * @ORM\ManyToOne(targetEntity="ProductTemplate")
   * @ORM\JoinColumn(name="product_template_id", referencedColumnName="id")
   *
   * @var ProductTemplate
   */
  protected $template;
  
  /**
   * @ORM\ManyToOne(targetEntity="Company")
   * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
   *
   * @var Company
   */
  protected $company;
  
  /**
   *
   * @return number
   */
  public function getId() {
    return $this->id;
  }
  
  /**
   *
   * @param integer $id          
   */
  public function setId($id) {
    $this->id = $id;
  }
  
  /**
   *
   * @return Company
   */
  public function getCompany() {
    return $this->company;
  }
  
  /**
   *
   * @param Company $company          
   */
  public function setCompany($company) {
    $this->company = $company;
  }
  
  /**
   *
   * @param ProductTemplate $template          
   */
  public function setTemplate($template) {
    $this->template = $template;
  }
  
  /**
   * return ProductTemplate
   */
  public function getTemplate() {
    return $this->template;
  }
}