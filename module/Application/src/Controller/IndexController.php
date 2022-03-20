<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Api\Model\FichaTecnica;
use Application\Form\FichaTecnicaForm;
use Application\Form\ListaForm;
use Application\Form\EntradaSaidaEstoqueForm;
use Application\Form\FornecedorForm;
use Application\Form\CategoriaForm;
use Application\Form\ProdutoForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Api\Model\Produto;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    public function fichaTecnicaAction()
    {
        $request = $this->getRequest();
        $fichaTecnicaForm = new FichaTecnicaForm('fichaTecnicaForm');
        if (!$request->isPost()) {
            return new ViewModel(['fichaTecnicaForm' => $fichaTecnicaForm]);
        }
        return new ViewModel();
    }
    public function fichaAction()
    {
        $request = $this->getRequest();
        $id = (int) $this->params()->fromRoute('id', 0);

        $fichaTecnica = new FichaTecnica();
        $fichaTecnica->__set('id',$id);
        $fichaTecnica->fetch();
        $fichaTecnicaForm = new FichaTecnicaForm('fichaTecnicaForm');
        if (!$request->isPost()) {
            return new ViewModel(['fichaTecnicaForm' => $fichaTecnicaForm, 'nomeFichaTenica' => $fichaTecnica->__get('nome')]);
        }
        return new ViewModel();
    }
    public function estoqueAction()
    {
        return new ViewModel();
    }
    public function entradaEstoqueAction()
    {
        $request = $this->getRequest();
        $entradaSaidaEstoqueForm = new EntradaSaidaEstoqueForm('entradaSaidaEstoqueForm');
        if (!$request->isPost()) {
            return new ViewModel(['entradaSaidaEstoqueForm' => $entradaSaidaEstoqueForm]);
        }
        return new ViewModel();
    }
    public function saidaEstoqueAction()
    {
        $request = $this->getRequest();
        $entradaSaidaEstoqueForm = new EntradaSaidaEstoqueForm('entradaSaidaEstoqueForm');
        if (!$request->isPost()) {
            return new ViewModel(['entradaSaidaEstoqueForm' => $entradaSaidaEstoqueForm]);
        }
        return new ViewModel();
    }
    public function produtosAction()
    {
        $request = $this->getRequest();
        $fornecedorForm = new FornecedorForm('fornecedorForm');
        $categoriaForm = new CategoriaForm('categoriaForm');
        $produtoForm = new ProdutoForm('produtoForm');
        if (!$request->isPost()) {
            return new ViewModel(['produtoForm' => $produtoForm, 'categoriaForm' => $categoriaForm, 'fornecedorForm' => $fornecedorForm]);
        }
        return new ViewModel();
    }
    public function listaAction()
    {
        $request = $this->getRequest();
        $produtoForm = new ProdutoForm('produtoForm');
        $listaForm = new ListaForm('listaForm');
        if (!$request->isPost()) {
            return new ViewModel(['produtoForm' => $produtoForm, 'listaForm' => $listaForm]);
        }
        return new ViewModel();
    }
    public function listaFornecedorAction()
    {
        $request = $this->getRequest();
        $fornecedorForm = new FornecedorForm('fornecedorForm');
        if (!$request->isPost()) {
            return new ViewModel(['fornecedorForm' => $fornecedorForm]);
        }
        return new ViewModel();
    }
    public function categoriasAction()
    {
        $request = $this->getRequest();
        $categoriaForm = new CategoriaForm('categoriaForm');
        if (!$request->isPost()) {
            return new ViewModel(['categoriaForm' => $categoriaForm]);
        }
        return new ViewModel();
    }
    public function fornecedorAction()
    {
        $request = $this->getRequest();
        $id = (int) $this->params()->fromRoute('id', 0);
        $produtoForm = new ProdutoForm('produtoForm', $id);
        if (!$request->isPost()) {
            return new ViewModel(['produtoForm' => $produtoForm, 'fornecedor' => $id]);
        }
        return new ViewModel();
    }
    public function imprimirListaAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        $produto = new Produto();
        $produtos = $produto->fetchAllList();

        $table = '<table width="100%" onload="print()">';
        $tHead = '<tHead><tr><th>Quantidade</th><th>Produto</th><th>Medida</th><tr></tHead>';
        $tBody  = '<tBody>';
        foreach ($produtos as $key => $value) {
            $tBody .= "<tr><td Align='center'>".$value['quantidade']."</td><td Align='center'>".$value['nome']."</td><td Align='center'>".$value['id_medida']."</td></tr>";
        }
        $tBody .= '</tBody>'; 

        $table .= $tHead.$tBody.'</table>';

        echo $table;
        return $request;
    }
}
