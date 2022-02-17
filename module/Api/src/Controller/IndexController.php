<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Api\Controller;

use Api\Model\Lista;
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
    public function insertProdutoFornecedorAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        $fornecedor = new Fornecedor();
        $fornecedor->__set('id', $request->getPost('fornecedorhidden'));
        $fornecedor->__set('produto', $request->getPost('produto'));
        $fornecedor->__set('valor', $request->getPost('valor'));
        $result = $fornecedor->addProduto();

        if ($result) {
            $arr_result = ['success' => 1, 'error' => 0];
        } else {
            $arr_result = ['success' => 0, 'error' => 1];
        }
        echo json_encode($arr_result);

        return $request;
    }
    public function insertFornecedorAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        $fornecedor = new Fornecedor();
        $fornecedor->__set('nome', $request->getPost('nome'));

        $result = $fornecedor->insert();

        if ($result) {
            $arr_result = ['success' => 1, 'error' => 0];
        } else {
            $arr_result = ['success' => 0, 'error' => 1];
        }
        echo json_encode($arr_result);

        return $request;
    }
    public function updateFornecedorAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        $fornecedor = new Fornecedor();
        $fornecedor->__set('id', $request->getPost('id'));
        $fornecedor->__set('nome', $request->getPost('nome'));

        $result = $fornecedor->update();

        if ($result) {
            $arr_result = ['success' => 1, 'error' => 0];
        } else {
            $arr_result = ['success' => 0, 'error' => 1];
        }
        echo json_encode($arr_result);

        return $request;
    }
    public function insertCategoriaAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        $categoria = new Categoria();
        $categoria->__set('nome', $request->getPost('nome'));

        $result = $categoria->insert();

        if ($result) {
            $arr_result = ['success' => 1, 'error' => 0];
        } else {
            $arr_result = ['success' => 0, 'error' => 1];
        }
        echo json_encode($arr_result);

        return $request;
    }
    public function updateCategoriaAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        $categoria = new Categoria();
        $categoria->__set('id', $request->getPost('id'));
        $categoria->__set('nome', $request->getPost('nome'));

        $result = $categoria->update();

        if ($result) {
            $arr_result = ['success' => 1, 'error' => 0];
        } else {
            $arr_result = ['success' => 0, 'error' => 1];
        }
        echo json_encode($arr_result);

        return $request;
    }
    public function insertListaAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        $lista = new Lista();
        $lista->__set('nome', $request->getPost('nome'));
        $result = $lista->insert();

        if ($result) {
            $arr_result = ['success' => 1, 'error' => 0];
        } else {
            $arr_result = ['success' => 0, 'error' => 1];
        }
        echo json_encode($arr_result);

        return $request;
    }
    public function insertProdutoAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        $produto = new Produto();
        $produto->__set('nome', $request->getPost('nome'));
        $produto->__set('id_medida', $request->getPost('medida'));
        $produto->__set('quantidade', $request->getPost('quantidade'));
        $produto->__set('id_categoria', $request->getPost('categoria'));
        $produto->__set('valor', $request->getPost('valor'));
        $result = $produto->insert();

        if ($result) {
            $arr_result = ['success' => 1, 'error' => 0];
        } else {
            $arr_result = ['success' => 0, 'error' => 1];
        }
        echo json_encode($arr_result);

        return $request;
    }
    public function updateProdutoAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        $produto = new Produto();
        $produto->__set('id', $request->getPost('id'));
        $produto->__set('nome', $request->getPost('nome'));
        $produto->__set('id_medida', $request->getPost('medida'));
        $produto->__set('quantidade', $request->getPost('quantidade'));
        $produto->__set('id_categoria', $request->getPost('categoria'));
        $produto->__set('valor', $request->getPost('valor'));
        $result = $produto->update();

        if ($result) {
            $arr_result = ['success' => 1, 'error' => 0];
        } else {
            $arr_result = ['success' => 0, 'error' => 1];
        }
        echo json_encode($arr_result);

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
    
    public function listaProdutoAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        $produto = new Produto();
        $produtos = $produto->fetchAllList();
        echo json_encode($produtos);
        return $request;
    }
    public function listaProdutoFornecedorAction()
    {
        $request = $this->getRequest();
        $id = (int) $this->params()->fromRoute('id', 0);
        $this->layout()->setTemplate('layout/blank');
        $fornecedor = new Fornecedor();
        $fornecedores = $fornecedor->fetchAllFornecedorList($id);
        echo json_encode($fornecedores);
        return $request;
    }
    public function categoriasAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        $categoria = new Categoria;
        $categorias = $categoria->fetchAllWithProdutc();

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
    public function listaFornecedoresAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        $fornecedor = new Fornecedor;
        $fornecedores = $fornecedor->fetchAllFornecedoresProduto();
        echo json_encode($fornecedores);
        return $request;
    }
    public function listaFornecedorAction()
    {
        $request = $this->getRequest();
        $id = (int) $this->params()->fromRoute('id', 0);
        $this->layout()->setTemplate('layout/blank');
        $fornecedor = new Fornecedor($id);
        $fornecedores = $fornecedor->fetchFornecedorProduto();
        echo json_encode($fornecedores);
        return $request;
    }
    public function addListaProdutoAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        $listaProdutos = $request->getPost('produto');


        foreach ($listaProdutos as $produtoId) {
            $produto = new Produto($produtoId);
            $produto->fetch();
            $result = $produto->insertLista();
        }

        if ($result) {
            $arr_result = ['success' => 1, 'error' => 0];
        } else {
            $arr_result = ['success' => 0, 'error' => 1];
        }
        echo json_encode($arr_result);

        return $request;
    }
    public function removerProdutoFornecedorAction()
    {
        $request = $this->getRequest();
        $fornecedor = (int) $this->params()->fromRoute('id', 0);
        $produto = (int) $this->params()->fromRoute('id2', 0);
        $this->layout()->setTemplate('layout/blank');
        $fornecedor = new Fornecedor($fornecedor);
        $result = $fornecedor->removeProduto($produto);

        if ($result) {
            $arr_result = ['success' => 1, 'error' => 0];
        } else {
            $arr_result = ['success' => 0, 'error' => 1];
        }
        echo json_encode($arr_result);
        return $request;
    }
    public function removerProdutoAction()
    {
        $request = $this->getRequest();
        $id = (int) $this->params()->fromRoute('id', 0);
        $this->layout()->setTemplate('layout/blank');
        $produto = new Produto();
        $produto->__set('id',$id);
        $result = $produto->delete();

        if ($result) {
            $arr_result = ['success' => 1, 'error' => 0];
        } else {
            $arr_result = ['success' => 0, 'error' => 1];
        }
        echo json_encode($arr_result);
        return $request;
    }
    public function removerFornecedorAction()
    {
        $request = $this->getRequest();
        $id = (int) $this->params()->fromRoute('id', 0);
        $this->layout()->setTemplate('layout/blank');
        $fornecedor = new Fornecedor();
        $fornecedor->__set('id',$id);
        $result = $fornecedor->delete();

        if ($result) {
            $arr_result = ['success' => 1, 'error' => 0];
        } else {
            $arr_result = ['success' => 0, 'error' => 1];
        }
        echo json_encode($arr_result);
        return $request;
    }
    public function removerCategoriaAction()
    {
        $request = $this->getRequest();
        $id = (int) $this->params()->fromRoute('id', 0);
        $this->layout()->setTemplate('layout/blank');
        $categoria = new Categoria();
        $categoria->__set('id',$id);
        $result = $categoria->delete();

        if ($result) {
            $arr_result = ['success' => 1, 'error' => 0];
        } else {
            $arr_result = ['success' => 0, 'error' => 1];
        }
        echo json_encode($arr_result);
        return $request;
    }
}
