<?php

namespace Company\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;

class ProductController extends AbstractRestfulController {
  
  /**
   *
   * @var EntityRepository
   */
  private $companyRepository;
  
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
   * @see \Zend\Mvc\Controller\AbstractRestfulController::getList()
   */
  public function getList() {
    $companyId = $this->params()->fromRoute('company_id');
    $company = $this->getRepository()->find($companyId);
    print_r($company->getProducts());
    
    
    return new JsonModel(array (
        "lala" => $companyId 
    ));
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