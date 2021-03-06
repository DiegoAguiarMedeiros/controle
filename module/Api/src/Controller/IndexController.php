<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Api\Controller;

use Api\Model\Lista;
use Api\Model\Categoria;
use Api\Model\FichaTecnica;
use Api\Model\Fornecedor;
use Api\Model\Produto;
use Api\Model\Estoque;
use Api\Model\EntradaEstoque;
use Api\Model\SaidaEstoque;
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
    public function estoqueAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        $estoque = new Estoque();
        $produtos = $estoque->fetchAllProdutosEmEstoque();
        echo json_encode($produtos);
        return $request;
    }
    public function estoqueEntradaAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        $entradaEstoque = new EntradaEstoque();
        $produtos = $entradaEstoque->fetchAllProdutosEntradaEstoque();
        echo json_encode($produtos);
        return $request;
    }
    public function addEstoqueEntradaAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        $dados = $request->getPost();
        $retorno = Array();
        
        for ($i=0; $i < count($dados); $i++) { 
            $dadosProduto = json_decode($dados[$i]);
            $entradaEstoque = new EntradaEstoque();
            $entradaEstoque->__set('id_produto',$dadosProduto->produto);
            $entradaEstoque->__set('valor_unitario',$dadosProduto->valor);
            $entradaEstoque->__set('quantidade',$dadosProduto->quantidade);

            $result = $entradaEstoque->insert();
            if($result == 1){
                $retorno[$i] = ['success' => 1 , 'ID' => $dadosProduto->produto];
            }else{
                
                $retorno[$i] = ['success' => 0 , 'error' => 0];
            }
        }

        echo json_encode($retorno);
        return $request;
    }
    public function addEstoqueSaidaAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        $dados = $request->getPost();
        $retorno = Array();
        
        for ($i=0; $i < count($dados); $i++) { 
            $dadosProduto = json_decode($dados[$i]);
            $entradaEstoque = new SaidaEstoque();
            $entradaEstoque->__set('id_produto',$dadosProduto->produto);
            $entradaEstoque->__set('valor_unitario',$dadosProduto->valor);
            $entradaEstoque->__set('quantidade',$dadosProduto->quantidade);

            $result = $entradaEstoque->insert();
            if($result == 1){
                $retorno[$i] = ['success' => 1 , 'ID' => $dadosProduto->produto];
            }else{
                
                $retorno[$i] = ['success' => 0 , 'error' => 0];
            }
        }

        echo json_encode($retorno);
        return $request;
    }
    public function estoqueSaidaAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        $saidaEstoque = new SaidaEstoque();
        $produtos = $saidaEstoque->fetchAllProdutosSaidaEstoque();
        echo json_encode($produtos);
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
    public function insertFichaTecnicaAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        $fichaTecnica = new FichaTecnica();
        $fichaTecnica->__set('nome', $request->getPost('nome'));

        $result = $fichaTecnica->insert();

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
    public function produtosParaListaAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        $produto = new Produto();
        $produtos = $produto->fetchAllWithFornecedor();
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
        $categorias = $categoria->fetchAllWithProduct();

        echo json_encode($categorias);
        return $request;
    }
    public function fichaTecnicaAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        $fichaTecnica = new FichaTecnica;
        $fichaTecnicas = $fichaTecnica->fetchAll();

        echo json_encode($fichaTecnicas);
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
        $id = $request->getPost('produtoLista');
        $quantidade = $request->getPost('quantidade');

        $produto = new Produto($id);
        $produto->fetchQuantidade();
        $result = $produto->insertLista($quantidade);

        if ($result) {
            $arr_result = ['success' => 1, 'error' => 0];
        } else {
            $arr_result = ['success' => 0, 'error' => 1];
        }
        echo json_encode($arr_result);

        return $request;
    }
    public function removerListaProdutoAction()
    {
        $request = $this->getRequest();
        $this->layout()->setTemplate('layout/blank');
        $id = $request->getPost('id');
        $quantidade = $request->getPost('quantidade');

        $produto = new Produto($id);
        $produto->fetchQuantidade();
        $result = $produto->removeLista($quantidade);

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
        $produto->__set('id', $id);
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
        $fornecedor->__set('id', $id);
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
        $categoria->__set('id', $id);
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
