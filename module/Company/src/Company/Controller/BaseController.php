<?php

namespace Company\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Doctrine\ORM\EntityManager;
use Zend\View\Model\JsonModel;

abstract class BaseController extends AbstractRestfulController {
  
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
   *
   * @param array $data          
   */
  abstract protected function fromData($data);
  abstract protected function getRepository();
  
  /**
   * (non-PHPdoc)
   *
   * @see \Zend\Mvc\Controller\AbstractRestfulController::create()
   */
  public function create($data) {
    $entity = $this->fromData($data);
    
    $this->getResponse()->setStatusCode(201);
    $this->getEntityManager()->persist($entity);
    $this->getEntityManager()->flush();
    
    return new JsonModel($this->entityToJson($entity));
  }
  
  /**
   * (non-PHPdoc)
   *
   * @see \Zend\Mvc\Controller\AbstractRestfulController::get()
   */
  public function get($id) {
    $entity = $this->getRepository()->find($id);
    
    if ($entity) {
      return new JsonModel($this->entityToJson($entity));
    } else {
      $this->getResponse()->setStatusCode(404);
    }
  }
  
  /**
   * (non-PHPdoc)
   *
   * @see \Zend\Mvc\Controller\AbstractRestfulController::delete()
   */
  public function delete($id) {
    $r = $this->getRepository();
    $entity = $this->getRepository()->find($id);
    if ($entity) {
      $this->getEntityManager()->remove($entity);
      $this->getEntityManager()->flush();
      $this->getResponse()->setStatusCode(204);
    } else {
      $this->getResponse()->setStatusCode(404);
    }
  }
  
  /**
   * (non-PHPdoc)
   *
   * @see \Zend\Mvc\Controller\AbstractRestfulController::getList()
   */
  public function getList() {
    return new JsonModel($this->toJson($this->getRepository()->findAll()));
  }
  
  /**
   *
   * @param array $companies          
   * @return multitype:|multitype:number string
   */
  public function toJson($entities) {
    if (! $entities) {
      return array ();
    }
    
    if (is_array($entities)) {
      $result = array ();
      foreach ( $entities as $e ) {
        array_push($result, $this->entityToJson($e));
      }
      return $result;
    } else {
      return $this->entityToJson($entities);
    }
  }
  
  /**
   *
   * @param unknown $entity          
   */
  public abstract function entityToJson($entity);
  
  /**
   *
   * @return \Doctrine\ORM\EntityManager
   */
  public function getEntityManager() {
    return $this->entityManager;
  }
  
  
}