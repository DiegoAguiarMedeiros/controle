<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Api\Controller;

use Api\Model\Categoria;
use Api\Model\Fornecedor;
use Api\Model\Produto;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        echo 'indexAction';
        return $request;
    }
    public function produtosAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        $produto = new Produto();
        $produtos = $produto->fetchAll();
        echo json_encode($produtos);
        return $request;
    }
    public function categoriasAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        $categoria = new Categoria;
        $categorias = $categoria->fetchAll();
        echo json_encode($categorias);
        return $request;
    }
    public function fornecedoresAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        $fornecedor = new Fornecedor;
        $fornecedores = $fornecedor->fetchAll();
        echo json_encode($fornecedores);
        return $request;
    }
}
