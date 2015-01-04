<?php

namespace Company\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Company\Entity\Product;

class ProductController extends AbstractRestfulController {
  
  /**
   *
   * @var EntityRepository
   */
  private $companyRepository;
  
  /**
   *
   * @var EntityRepository
   */
  private $templateRepository;
  
  /**
   *
   * @var ProductTemplateConverter
   */
  private $templateConverter;
  
  /**
   *
   * @var EntityManager
   */
  private $entityManager;
  
  /**
   *
   * @var ProductConverter
   */
  private $productConverter;
  
  /**
   *
   * @param EntityManager $entityManager          
   * @param ProductTemplateConverter $templateConverter          
   * @param ProductConverter $productConverter          
   */
  public function __construct(EntityManager $entityManager, $templateConverter, $productConverter) {
    $this->entityManager = $entityManager;
    $this->templateConverter = $templateConverter;
    $this->productConverter = $productConverter;
  }
  
  /**
   * (non-PHPdoc)
   *
   * @see \Zend\Mvc\Controller\AbstractRestfulController::getList()
   */
  public function getList() {
    $companyId = $this->params()->fromRoute('company_id');
    
    $qb = $this->entityManager->createQueryBuilder();
    $q = $this->entityManager->createQuery("SELECT p, c FROM \Company\Entity\Product p JOIN p.company c WHERE c.id = :company_id");
    $q->setParameter("company_id", $companyId);
    
    $result = $q->getResult();
    
    return new JsonModel($this->productConverter->toJson($result));
  }
  
  /**
   * (non-PHPdoc)
   *
   * @see \Zend\Mvc\Controller\AbstractRestfulController::get()
   */
  public function get($id) {
    $companyId = $this->params()->fromRoute('company_id');
    $productId = $id;
    
    $qb = $this->entityManager->createQueryBuilder();
    $q = $this->entityManager->createQuery("SELECT p, c FROM \Company\Entity\Product p JOIN p.company c WHERE c.id = :company_id AND p.id = :product_id");
    $q->setParameter("company_id", $companyId);
    $q->setParameter("product_id", $productId);
    
    $result = $q->getOneOrNullResult();
    
    if (! $result) {
      $this->getResponse()->setStatusCode(404);
    } else {
      return new JsonModel($this->productConverter->entityToJson($result));
    }
  }

  
  /**
   * (non-PHPdoc)
   * 
   * @see \Zend\Mvc\Controller\AbstractRestfulController::delete()
   */
  public function delete($id) {
    $companyId = $this->params()->fromRoute('company_id');
    $productId = $id;
    
    $qb = $this->entityManager->createQueryBuilder();
    $q = $this->entityManager->createQuery("SELECT p, c FROM \Company\Entity\Product p JOIN p.company c WHERE c.id = :company_id AND p.id = :product_id");
    $q->setParameter("company_id", $companyId);
    $q->setParameter("product_id", $productId);
    
    $result = $q->getOneOrNullResult();
    
    if (! $result) {
      $this->getResponse()->setStatusCode(404);
    } else {
      $this->entityManager->remove($result);
      $this->entityManager->flush();
      $this->getResponse()->setStatusCode(204);
    }
  }
  
  /**
   * (non-PHPdoc)
   *
   * @see \Zend\Mvc\Controller\AbstractRestfulController::create()
   */
  public function create($data) {
    $companyId = $this->params()->fromRoute('company_id');
    $company = $this->getCompanyRepository()->find($companyId);
    if (! $company) {
      return $this->badRequest();
    }
    
    $templateId = $data ['template_id'];
    $template = $this->getTemplateRepository()->find($templateId);
    if (! $template) {
      return $this->badRequest();
    }
    
    $product = new Product();
    $product->setCompany($company);
    $product->setTemplate($template);
    
    $this->entityManager->persist($product);
    $this->entityManager->flush();
    
    return new JsonModel($this->productConverter->entityToJson($product));
  }
  
  /**
   */
  private function badRequest() {
    $this->getResponse()->setStatusCode(400);
    return;
  }
  
  /**
   *
   * @return EntityRepository
   */
  protected function getCompanyRepository() {
    if (! $this->companyRepository) {
      $this->companyRepository = $this->entityManager->getRepository('\Company\Entity\Company');
    }
    return $this->companyRepository;
  }
  
  /**
   *
   * @return EntityRepository
   */
  protected function getTemplateRepository() {
    if (! $this->templateRepository) {
      $this->templateRepository = $this->entityManager->getRepository('\Company\Entity\ProductTemplate');
    }
    return $this->templateRepository;
  }
  
  /**
   *
   * @return EntityRepository
   */
  protected function getProductRepository() {
    if (! $this->templateRepository) {
      $this->templateRepository = $this->entityManager->getRepository('\Company\Entity\Product');
    }
    return $this->templateRepository;
  }
}