<?php

namespace Api\Model;

use Zend\Db\Sql\Sql;

class Fornecedor
{
    private $id;
    private $nome;

    public function __construct()
    {
        $this->id = "";
        $this->nome = "";
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
            $this->__set('nome',$value['nome']);
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
    public function delete()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $delete = $sql->delete('fornecedor');
        $delete->where(['id'=>$this->id]);
        $deleteString = $sql->buildSqlString($delete);
        $adapter->query($deleteString,$adapter::QUERY_MODE_EXECUTE);
    }
    public function editfornecedor()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $update = $sql->update('fornecedor');
        $update->set(['nome' => $this->nome]);
        $update->where(['id'=>$this->id]);
        $updateString = $sql->buildSqlString($update);
        echo $updateString;
        $adapter->query($updateString, $adapter::QUERY_MODE_EXECUTE);
    }
}
