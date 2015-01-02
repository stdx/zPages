<?php

namespace Company\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Company\Entity\Company;

class CompanyController extends BaseController {
  
  /**
   *
   * @var EntityRepository
   */
  private $repository;
  
  /**
   *
   * @param EntityManager $entityManager          
   */
  public function __construct(EntityManager $entityManager) {
    parent::__construct($entityManager);
  }
  
  
  /**
   * (non-PHPdoc)
   * 
   * @see \Company\Controller\BaseController::fromData()
   */
  protected function fromData($data) {
    $company = new Company();
    $company->setName($data ['name']);
    $company->setDescription($data ['description']);
    
    return $company;
  }
  
  /**
   *
   * @param Company $company          
   * @return multitype:number string
   */
  public function entityToJson($company) {
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
  protected function getRepository() {
    if (! $this->repository) {
      $this->repository = $this->getEntityManager()->getRepository('\Company\Entity\Company');
    }
    return $this->repository;
  }
}
