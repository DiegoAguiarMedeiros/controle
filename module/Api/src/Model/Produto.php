<?php

namespace Api\Model;

use Zend\Db\Sql\Sql;

class Produto
{
    private $id;
    private $nome;
    private $id_medida;
    private $quantidade;
    private $id_fornecedor;
    private $id_categoria;
    private $valor;

    public function __construct($id = "", $nome = "", $medida = "", $quantidade = "", $fornecedor = "", $categoria = "", $valor = "")
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->id_medida = $medida;
        $this->quantidade = $quantidade;
        $this->id_fornecedor = $fornecedor;
        $this->id_categoria = $categoria;
        $this->valor = $valor;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }
    public function fetchAll($limit = null, $offset = null, $coluna = 'id', $order = 'ASC')
    {

        $con = new Connection();
        $adapter = $con->getAdapter();
        $strLimit = '';
        if ($limit) {
            $strLimit = "LIMIT $limit";
        }
        $strOffset = '';
        if ($offset) {
            $strOffset = "OFFSET $offset";
        }
        $order = "ORDER BY $coluna $order";

        $selectString = "SELECT p.id, p.nome, m.medida, p.quantidade, c.nome as categoria FROM produto p JOIN medida m ON m.id = p.id_medida JOIN categoria c ON c.id = p.id_categoria ";

        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        $produtos = array();

        foreach ($results->toArray() as $value) {
            $produto = array();
            $produto['id'] = $value['id'];
            $produto['nome'] = $value['nome'];
            $produto['id_medida'] = $value['quantidade'] . ' ' . $value['medida'];
            $produto['id_categoria'] = $value['categoria'];
            $produtos[] = $produto;
        }
        return $produtos;
    }
    public function fetchAllWithFornecedor()
    {

        $con = new Connection();
        $adapter = $con->getAdapter();

        $selectString = "SELECT p.id, p.nome, m.medida, p.quantidade, c.nome as categoria FROM produto p JOIN produto_fornecedor pf ON pf.id_produto = p.id JOIN fornecedor f ON f.id = pf.id_fornecedor JOIN medida m ON m.id = p.id_medida JOIN categoria c ON c.id = p.id_categoria GROUP BY p.id";

        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        $produtos = array();

        foreach ($results->toArray() as $value) {
            $produto = array();
            $produto['id'] = $value['id'];
            $produto['nome'] = $value['nome'];
            $produto['id_medida'] = $value['quantidade'] . ' ' . $value['medida'];
            $produto['id_categoria'] = $value['categoria'];
            $produtos[] = $produto;
        }
        return $produtos;
    }
    
    public function fetchAllList($limit = null, $offset = null, $coluna = 'id_produto', $order = 'ASC')
    {

        $con = new Connection();
        $adapter = $con->getAdapter();
        $selectString = 'SELECT p.id as id_produto, p.nome, (SELECT f.nome FROM produto_fornecedor pf JOIN fornecedor f ON pf.id_fornecedor = f.id WHERE pf.id_produto = p.id LIMIT 1) as fornecedor, (SELECT pf.valor FROM produto_fornecedor pf JOIN fornecedor f ON pf.id_fornecedor = f.id WHERE pf.id_produto = p.id LIMIT 1) as valor, SUM(l.quantidade) as quantidade FROM produto p JOIN lista_produto l ON l.id_produto = p.id GROUP BY p.id;';
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        $produtos = array();

        foreach ($results->toArray() as $value) {
            $nomeProduto = new Produto($value['id_produto']);
            $fornecedor = new Fornecedor();
            $fornecedor->fetchBestValue($value['id_produto']);
            $nomeProduto->fetch();
            $produto = array();
            $produto['id'] = $value['id_produto'];
            $produto['nome'] = $nomeProduto->__get('nome');
            $produto['fornecedor'] = $fornecedor->__get('nome');
            $produto['valor'] = $fornecedor->__get('valor');
            $produto['id_medida'] = $nomeProduto->__get('id_medida');
            $produto['quantidade'] = $value['quantidade'];
            $produto['id_categoria'] = $nomeProduto->__get('id_categoria');
            $produtos[] = $produto;
        }
        return $produtos;
    }
    public function fetchAllNome($limit = null, $offset = null, $coluna = 'id', $order = 'ASC', $fornecedor = null)
    {

        $con = new Connection();
        $adapter = $con->getAdapter();

        $strLimit = '';
        if ($limit) {
            $strLimit = "LIMIT $limit";
        }
        $strOffset = '';
        if ($offset) {
            $strOffset = "OFFSET $offset";
        }
        $strFornecedor = '';
        if ($fornecedor) {
            $strFornecedor = "WHERE id NOT IN (SELECT id_produto FROM produto_fornecedor WHERE id_fornecedor = $fornecedor )";
        }

        $order = "ORDER BY $coluna $order";

        $selectString = "SELECT id, nome FROM produto $strFornecedor $order $strLimit $strOffset";
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        $produtos = array();

        foreach ($results->toArray() as $value) {
            $produtos[$value['id']] = $value['nome'];
        }
        return $produtos;
    }
    public function fetchAllNomeWithFornecedor()
    {

        $con = new Connection();
        $adapter = $con->getAdapter();


        $selectString = "SELECT p.id, p.nome FROM produto p JOIN produto_fornecedor pf ON pf.id_produto = p.id JOIN fornecedor f ON pf.id_fornecedor = f.id GROUP BY p.id";
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        $produtos = array();

        foreach ($results->toArray() as $value) {
            $produtos[$value['id']] = $value['nome'];
        }
        return $produtos;
    }

    public function fetch()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();

        $selectString = "SELECT p.nome, m.medida, p.quantidade, c.nome as categoria FROM produto p JOIN medida m ON m.id = p.id_medida JOIN categoria c ON c.id = p.id_categoria WHERE p.id = " . $this->id;
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);

        foreach ($results->toArray() as $value) {
            $this->__set('nome', $value['nome']);
            $this->__set('id_medida',  $value['quantidade'] . '' . $value['medida']);
            $this->__set('quantidade', $value['quantidade']);
            $this->__set('id_categoria', $value['categoria']);
        }
    }
    public function fetchQuantidade()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();

        $selectString = "SELECT l.quantidade FROM lista_produto l WHERE l.id_produto = " . $this->id;
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);

        foreach ($results->toArray() as $value) {
            if ($value['quantidade']) {

                $this->__set('quantidade', $value['quantidade']);
            } else {
                $this->__set('quantidade', 0);
            }
        }
    }

    public function insert()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $insert = $sql->insert('produto');
        $insert->values([
            'nome' => $this->nome,
            'id_medida' => $this->id_medida,
            'quantidade' => $this->quantidade,
            'id_categoria' => $this->id_categoria,
        ]);
        $insertString = $sql->buildSqlString($insert);
        $result = $adapter->query($insertString, $adapter::QUERY_MODE_EXECUTE);

        return $result->getAffectedRows();
    }
    public function update()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $update = $sql->update('produto');
        $update->set([
            'nome' => $this->nome,
            'id_medida' => $this->id_medida,
            'quantidade' => $this->quantidade,
            'id_categoria' => $this->id_categoria,
        ]);
        $update->where(['id' => $this->id]);
        $updateString = $sql->buildSqlString($update);
        $result = $adapter->query($updateString, $adapter::QUERY_MODE_EXECUTE);

        return $result->getAffectedRows();
    }
    public function insertLista($quantidade)
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        if ($this->quantidade == 0) {

            $insert = $sql->insert('lista_produto');
            $insert->values([
                'id_produto' => $this->id,
                'quantidade' => $quantidade,
            ]);
            $insertString = $sql->buildSqlString($insert);
            $result = $adapter->query($insertString, $adapter::QUERY_MODE_EXECUTE);
        } else {
            $result = $this->editProdutoLista(true, $quantidade);
        }
        return $result->getAffectedRows();
    }
    public function removeLista($quantidade)
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        if ($this->quantidade <= $quantidade) {
            $adapter = $con->getAdapter();
            $deleteString = "DELETE FROM lista_produto WHERE id_produto = $this->id";
            $result = $adapter->query($deleteString, $adapter::QUERY_MODE_EXECUTE);
        } else if ($this->quantidade > 0) {
            $result = $this->editProdutoLista(false, $quantidade);
        }

        return $result->getAffectedRows();
    }
    public function delete()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $deleteString = "DELETE FROM produto WHERE id = $this->id";
        $result = $adapter->query($deleteString, $adapter::QUERY_MODE_EXECUTE);
        return $result->getAffectedRows();
    }
    public function editProdutoLista($adicionar, $quantidade)
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $update = $sql->update('lista_produto');

        if ($adicionar) {
            $quantidadeFinal = $this->quantidade + $quantidade;
        } else {
            $quantidadeFinal = $this->quantidade - $quantidade;
        }

        $update->set(['quantidade' =>  $quantidadeFinal]);
        $update->where(['id_produto' => $this->id]);
        $updateString = $sql->buildSqlString($update);
        // echo $updateString;
        $result = $adapter->query($updateString, $adapter::QUERY_MODE_EXECUTE);
        return $result;
    }
}
