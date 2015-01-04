<?php

namespace Company\Controller;

use Company\Entity\Product;

class ProductConverter extends BaseConverter {
  
  /**
   *
   * @var Product $entity
   *     
   */
  public function entityToJson($entity) {
    $dto = array (
        'id' => $entity->getId(),
        'companyId' => $entity->getCompany()->getId(),
        'templateId' => $entity->getTemplate()->getId()
    );
    return $dto;
  }
}