<?php

namespace Company;

use Company\Entity\Company;
use Company\Controller\CompanyController;
use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Controller\ControllerManager;
use Company\Controller\ProductController;

return array (
    
    // Doctrine config
    'doctrine' => array (
        'driver' => array (
            __NAMESPACE__ . '_driver' => array (
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array (
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity' 
                ) 
            ),
            'orm_default' => array (
                'drivers' => array (
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver' 
                ) 
            ) 
        ) 
    ),
    
    'router' => array (
        'routes' => array (
            'company' => array (
                'type' => 'segment',
                'options' => array (
                    'route' => '/api/companies[/:id]',
                    'constraints' => array (
                        'id' => '[0-9]+' 
                    ),
                    'defaults' => array (
                        'controller' => 'Company\Controller\Company' 
                    ) 
                ) 
            ),
            'products' => array (
                'type' => 'segment',
                'options' => array (
                    'route' => '/api/companies/:company_id/products[/:product_id]',
                    'constraints' => array (
                        'company_id' => '[0-9]+',
                        'product_id' => '[0-9]+'
                    ),
                    'defaults' => array (
                        'controller' => 'Company\Controller\Product'
                    )
                )
            )
        ) 
    ),
    
    'controllers' => array (
        'factories' => array (
            'Company\Controller\Company' => function (ControllerManager $cm) {
              $locator = $cm->getServiceLocator();
              return new CompanyController($locator->get("doctrine.entitymanager.orm_default"));
            },
            'Company\Controller\Product' => function(ControllerManager $cm) {
              $locator = $cm->getServiceLocator();
              return new ProductController($locator->get("doctrine.entitymanager.orm_default"));
            } 
        ) 
    ),
    
    'view_manager' => array (
        'strategies' => array (
            'ViewJsonStrategy' 
        ),
        'template_path_stack' => array (
            'album' => __DIR__ . '/../view' 
        ) 
    ) 
);
