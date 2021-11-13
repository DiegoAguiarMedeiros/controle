<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

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
        $produtoForm = new ProdutoForm('produto');
        if (!$request->isPost()) {
            return new ViewModel(['produtoForm' => $produtoForm]);
        }
        return new ViewModel();
    }
}
