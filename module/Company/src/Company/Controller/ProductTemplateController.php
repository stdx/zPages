<?php

namespace Company\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;
use Company\Entity\ProductTemplate;

class ProductTemplateController extends BaseController {
  
  /**
   *
   * @var EntityRepository
   */
  private $repository;
  
  /**
   *
   * @var ProductTemplateConverter
   */
  private $converter;
  
  /**
   *
   * @param EntityManager $entityManager          
   */
  public function __construct(EntityManager $entityManager, $converter) {
    parent::__construct($entityManager);
    $this->converter = $converter;
  }
  
  /**
   * (non-PHPdoc)
   *
   * @see \Company\Controller\BaseController::fromData()
   */
  protected function fromData($data) {
    $template = new ProductTemplate();
    $template->setName($data ['name']);
    $template->setDescription($data ['description']);
    return $template;
  }
  
  /**
   *
   * @param ProductTemplate $entity          
   * @return multitype:number string
   */
  public function entityToJson($entity) {
    return $this->converter->entityToJson($entity);
  }
  
  /**
   *
   * @return EntityRepository
   */
  protected function getRepository() {
    if (! $this->repository) {
      $this->repository = $this->getEntityManager()->getRepository('\Company\Entity\ProductTemplate');
    }
    return $this->repository;
  }
}