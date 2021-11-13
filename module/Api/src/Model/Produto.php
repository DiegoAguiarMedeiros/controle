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

    public function __construct()
    {
        $this->id = "";
        $this->nome = "";
        $this->id_medida = "";
        $this->quantidade = "";
        $this->id_fornecedor = "";
        $this->id_categoria = "";
        $this->valor = "";
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
        $select = $sql->select('produto');
        if($limit){
            $select->limit($limit);
        }
        if($offset){
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
    
    public function fetch()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $select = $sql->select('produto');
        $select->where(['id'=>$this->id]);
        $selectString = $sql->buildSqlString($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);

        foreach ($results->toArray() as $value) {
            $this->__set('nome',$value['nome']);
            $this->__set('id_medida',$value['id_medida']);
            $this->__set('quantidade',$value['quantidade']);
            $this->__set('id_fornecedor',$value['id_fornecedor']);
            $this->__set('id_categoria',$value['id_categoria']);
            $this->__set('valor',$value['valor']);
        }
    }

    public function insert()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $insert = $sql->insert('produto');
        $insert->values(['path'=>$this->path]);
        $insertString = $sql->buildSqlString($insert);
        $adapter->query($insertString,$adapter::QUERY_MODE_EXECUTE);
    }
    public function delete()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $delete = $sql->delete('produto');
        $delete->where(['id'=>$this->id]);
        $deleteString = $sql->buildSqlString($delete);
        $adapter->query($deleteString,$adapter::QUERY_MODE_EXECUTE);
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
        $update->where(['id'=>$this->id]);
        $updateString = $sql->buildSqlString($update);
        echo $updateString;
        $adapter->query($updateString, $adapter::QUERY_MODE_EXECUTE);
    }
}
