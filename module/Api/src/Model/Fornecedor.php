<?php

namespace Api\Model;

use Zend\Db\Sql\Sql;

class Fornecedor
{
    private $id;
    private $nome;
    private $produto;
    private $valor;
    private $qtd;

    public function __construct($id = "",$nome = "")
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->produto = "";
        $this->valor = "";
        $this->qtd = "";
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }
    public function fetchAll($limit = null, $offset = null, $coluna = 'id' , $order = 'ASC' )
    {

        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $select = $sql->select('fornecedor');
        if($limit){
            $select->limit($limit);
        }
        if($offset){
            $select->offset($offset);
        }
        $select->order("$coluna $order");
        $selectString = $sql->buildSqlString($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        $fornecedores = array();

        foreach ($results->toArray() as $value) {
            $fornecedores[$value['id']] = $value['nome'];
        }
        return $fornecedores;
    }
    public function fetchAllFornecedorList($lista)
    {

        $con = new Connection();
        $adapter = $con->getAdapter();
        $selectString = "SELECT f.id, f.nome, SUM(pf.valor) as valor FROM fornecedor f JOIN produto_fornecedor pf ON f.id = pf.id_fornecedor JOIN lista_produto l ON l.id_produto = pf.id_produto WHERE l.id_lista = $lista GROUP BY f.id";
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        $fornecedores = array();

        foreach ($results->toArray() as $value) {
            $fornecedor = array();
            $fornecedor['id'] = $value['id'];
            $fornecedor['nome'] = $value['nome'];
            $fornecedor['valor'] = $value['valor'];
            $fornecedores[] = $fornecedor;
        }
        return $fornecedores;
    }
    public function fetchAllFornecedoresProduto($limit = null, $offset = null, $coluna = 'id' , $order = 'ASC' )
    {

        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $select = $sql->select('fornecedor');
        if($limit){
            $select->limit($limit);
        }
        if($offset){
            $select->offset($offset);
        }
        $select->order("$coluna $order");
        $selectString = $sql->buildSqlString($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        $fornecedores = array();

        foreach ($results->toArray() as $value) {
            $nomeFornecedor = new Fornecedor($value['id']);
            $nomeFornecedor->fetch();
            $nomeFornecedor->fetchFornecedorQtdProduto();
            $fornecedor = array();
            $fornecedor['id'] = $value['id'];
            $fornecedor['nome'] = $nomeFornecedor->__get('nome');
            $fornecedor['qtd'] = $nomeFornecedor->__get('qtd');
            $fornecedores[] = $fornecedor;
        }
        return $fornecedores;
    }
    
    public function fetchFornecedorQtdProduto()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $selectString = "SELECT COUNT(id_produto) as qtd FROM `produto_fornecedor` WHERE id_fornecedor = ".$this->id;
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);

        foreach ($results->toArray() as $value) {
            $this->qtd = $value['qtd'];
        }
    }
    public function fetchFornecedorProduto()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $selectString = "SELECT p.id, p.nome, f.nome as fornecedor, p.status, p.quantidade, m.medida, c.nome as categoria, pf.valor FROM produto p JOIN produto_fornecedor pf on pf.id_produto = p.id JOIN fornecedor f ON f.id = pf.id_fornecedor JOIN medida m ON m.id = p.id_medida JOIN categoria c ON c.id = p.id_categoria WHERE pf.id_fornecedor = ".$this->id;
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        $produto = array();
        $produtos = array();
        foreach ($results->toArray() as $value) {
            $produto['id'] = $value['id'];
            $produto['nome'] = $value['nome'];
            $produto['fornecedor'] = $value['fornecedor'];
            $produto['quantidade'] = $value['quantidade'];
            $produto['medida'] = $value['medida'];
            $produto['categoria'] = $value['categoria'];
            $produto['valor'] = $value['valor'];
            $produtos[] = $produto;
        }
        return $produtos;
    }
    public function fetch()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $select = $sql->select('fornecedor');
        $select->where(['id'=>$this->id]);
        $selectString = $sql->buildSqlString($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);

        foreach ($results->toArray() as $value) {
            $this->nome = $value['nome'];
        }
    }
    public function fetchBestValue($produto)
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $selectString = "SELECT f.nome, pf.valor FROM fornecedor f JOIN produto_fornecedor pf ON pf.id_fornecedor = f.id WHERE pf.id_produto = $produto ORDER BY pf.valor ASC LIMIT 1";
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);

        foreach ($results->toArray() as $value) {
            $this->nome = $value['nome'];
            $this->valor = $value['valor'];
        }
    }

    public function insert()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $insert = $sql->insert('fornecedor');
        $insert->values(['nome'=>$this->nome]);
        $insertString = $sql->buildSqlString($insert);
        $result = $adapter->query($insertString,$adapter::QUERY_MODE_EXECUTE);
        return $result->getAffectedRows();
    }
    public function addProduto()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $insert = $sql->insert('produto_fornecedor');
        $insert->values([
            'id_produto'=>$this->produto,
            'id_fornecedor'=>$this->id,
            'valor'=>$this->valor,
        ]);
        $insertString = $sql->buildSqlString($insert);
        $result = $adapter->query($insertString,$adapter::QUERY_MODE_EXECUTE);
        return $result->getAffectedRows();
    }
    public function removeProduto($produto)
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $deleteString = "DELETE FROM produto_fornecedor WHERE id_produto = $produto AND id_fornecedor = $this->id";
        $result = $adapter->query($deleteString,$adapter::QUERY_MODE_EXECUTE);
        return $result->getAffectedRows();
    }
    public function delete()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $deleteString = "DELETE FROM fornecedor WHERE id = $this->id";
        $result = $adapter->query($deleteString,$adapter::QUERY_MODE_EXECUTE);
        return $result->getAffectedRows();
    }
    public function update()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $update = $sql->update('fornecedor');
        $update->set(['nome' => $this->nome]);
        $update->where(['id'=>$this->id]);
        $updateString = $sql->buildSqlString($update);
        $result = $adapter->query($updateString, $adapter::QUERY_MODE_EXECUTE);
        return $result->getAffectedRows();
    }
}
