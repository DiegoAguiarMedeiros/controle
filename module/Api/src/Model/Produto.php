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

    public function __construct($id = "",$nome = "",$medida = "",$quantidade="",$fornecedor="",$categoria="",$valor="")
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
        $sql = new Sql($adapter);
        $select = $sql->select('produto');
        if ($limit) {
            $select->limit($limit);
        }
        if ($offset) {
            $select->offset($offset);
        }
        $select->order("$coluna $order");
        $selectString = $sql->buildSqlString($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        $produtos = array();

        foreach ($results->toArray() as $value) {
            $produto = array();
            $produto['id'] = $value['id'];
            $produto['nome'] = $value['nome'];
            $produto['id_medida'] = $value['id_medida'];
            $produto['quantidade'] = $value['quantidade'];
            $produto['id_fornecedor'] = $value['id_fornecedor'];
            $produto['id_categoria'] = $value['id_categoria'];
            $produto['valor'] = $value['valor'];
            $produtos[] = $produto;
        }
        return $produtos;
    }
    public function fetchAllList($limit = null, $offset = null, $coluna = 'id_produto', $order = 'ASC')
    {

        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $select = $sql->select('lista_produto');
        
        if ($limit) {
            $select->limit($limit);
        }
        if ($offset) {
            $select->offset($offset);
        }
        $select->order("$coluna $order");
        $selectString = $sql->buildSqlString($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        $produtos = array();

        foreach ($results->toArray() as $value) {
            $nomeProduto = new Produto($value['id_produto']);
            $nomeProduto->fetch();
            $produto = array();
            $produto['id'] = $value['id_produto'];
            $produto['nome'] = $nomeProduto->__get('nome');
            $produto['id_medida'] = $nomeProduto->__get('id_medida');
            $produto['quantidade'] = $value['quantidade'];
            $produto['id_fornecedor'] = $nomeProduto->__get('id_fornecedor');
            $produto['id_categoria'] = $nomeProduto->__get('id_categoria');
            $produto['valor'] = $value['valor'];
            $produtos[] = $produto;
        }
        return $produtos;
    }
    public function fetchAllNome($limit = null, $offset = null, $coluna = 'id', $order = 'ASC')
    {

        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $select = $sql->select('produto');
        if ($limit) {
            $select->limit($limit);
        }
        if ($offset) {
            $select->offset($offset);
        }
        $select->order("$coluna $order");
        $select->group("nome");
        $selectString = $sql->buildSqlString($select);
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
        $sql = new Sql($adapter);
        $select = $sql->select('produto');
        $select->where(['id' => $this->id]);
        $selectString = $sql->buildSqlString($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);

        foreach ($results->toArray() as $value) {
            $this->__set('nome', $value['nome']);
            $this->__set('id_medida', $value['id_medida']);
            $this->__set('quantidade', $value['quantidade']);
            $this->__set('id_fornecedor', $value['id_fornecedor']);
            $this->__set('id_categoria', $value['id_categoria']);
            $this->__set('valor', $value['valor']);
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
            'id_fornecedor' => $this->id_fornecedor,
            'id_categoria' => $this->id_categoria,
            'valor' => $this->valor
        ]);
        $insertString = $sql->buildSqlString($insert);
        $result = $adapter->query($insertString, $adapter::QUERY_MODE_EXECUTE);
        return $result->getAffectedRows();
    }
    public function insertLista()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $insert = $sql->insert('lista_produto');
        $insert->values([
            'id_produto' => $this->id,
            'valor' => $this->valor
        ]);
        $insertString = $sql->buildSqlString($insert);
        $result = $adapter->query($insertString, $adapter::QUERY_MODE_EXECUTE);
        return $result->getAffectedRows();
    }
    public function delete()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $delete = $sql->delete('produto');
        $delete->where(['id' => $this->id]);
        $deleteString = $sql->buildSqlString($delete);
        $adapter->query($deleteString, $adapter::QUERY_MODE_EXECUTE);
    }
    public function editHome()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $update = $sql->update('produto');
        if ($this->home == 0) {
            $this->home = 1;
        } else {
            $this->home = 0;
        }

        $update->set(['home' => $this->home]);
        $update->where(['id' => $this->id]);
        $updateString = $sql->buildSqlString($update);
        echo $updateString;
        $adapter->query($updateString, $adapter::QUERY_MODE_EXECUTE);
    }
}