<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Form\ListaForm;
use Application\Form\FornecedorForm;
use Application\Form\CategoriaForm;
use Application\Form\ProdutoForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    public function produtosAction()
    {
        $request = $this->getRequest();
        $fornecedorForm = new FornecedorForm('fornecedorForm');
        $categoriaForm = new CategoriaForm('categoriaForm');
        $produtoForm = new ProdutoForm('produtoForm');
        if (!$request->isPost()) {
            return new ViewModel(['produtoForm' => $produtoForm,'categoriaForm' => $categoriaForm,'fornecedorForm' => $fornecedorForm]);
        }
        return new ViewModel();
    }
    public function listaAction()
    {
        $request = $this->getRequest();
        $produtoForm = new ProdutoForm('produtoForm');
        if (!$request->isPost()) {
            return new ViewModel(['produtoForm' => $produtoForm]);
        }
        return new ViewModel();
    }
}
