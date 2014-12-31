<?php

namespace Company\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Company\Entity\Company;

class CompanyController extends AbstractRestfulController {
  
  /**
   * 
   * @var EntityRepository
   */
  private $companyRepository;
  
  /**
   *
   * @var EntityManager
   */
  private $entityManager;
  
  /**
   *
   * @param EntityManager $entityManager          
   */
  public function __construct(EntityManager $entityManager) {
    $this->entityManager = $entityManager;
  }
  
  /**
   * (non-PHPdoc)
   *
   * @see \Zend\Mvc\Controller\AbstractRestfulController::get()
   */
  public function get($id) {
    return new JsonModel($this->entityToJson($this->getRepository()->find($id)));
  }
  
  /**
   * (non-PHPdoc)
   * @see \Zend\Mvc\Controller\AbstractRestfulController::delete()
   */
  public function delete($id) {
    $r = $this->getRepository();
    $company = $r->find($id);
  }
  
  /**
   * (non-PHPdoc)
   *
   * @see \Zend\Mvc\Controller\AbstractRestfulController::getList()
   */
  public function getList() {
    $companies = $this->getRepository()->findAll();
    return new JsonModel($this->toJson($companies));
  }
  
  /**
   * (non-PHPdoc)
   * @see \Zend\Mvc\Controller\AbstractRestfulController::create()
   */
  public function create($data) {
    
  }
  
  
  /**
   *
   * @param unknown $companies          
   * @return multitype:|multitype:number string
   */
  private function toJson($companies) {
    if (! $companies) {
      return array ();
    }
    
    if (is_array($companies)) {
      $result = array ();
      foreach ( $companies as $c ) {
        array_push($result, $this->entityToJson($c));
      }
      return $result;
    } else {
      return $this->entityToJson($companies);
    }
  }
  
  /**
   *
   * @param Company $company          
   * @return multitype:number string
   */
  private function entityToJson(Company $company) {
    $dto = array (
        'id' => $company->getId(),
        'name' => $company->getName() 
    );
    
    if ($company->getDescription()) {
      $dto ['description'] = $company->getDescription();
    }
    
    return $dto;
  }
  

  
  /**
   *
   * @return EntityRepository
   */
  private function getRepository() {
    if (! $this->companyRepository) {
      $this->companyRepository = $this->entityManager->getRepository('\Company\Entity\Company');
    }
    return $this->companyRepository;
  }
}
