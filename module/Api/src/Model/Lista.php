<?php

namespace Api\Model;

use Zend\Db\Sql\Sql;

class Lista
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
        $select = $sql->select('lista');
        if($limit){
            $select->limit($limit);
        }
        if($offset){
            $select->offset($offset);
        }
        $select->order("$coluna $order");
        $selectString = $sql->buildSqlString($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        $Listas = array();

        foreach ($results->toArray() as $value) {
            $Listas[$value['id']] = $value['nome'];
        }
        return $Listas;
    }
    
    public function fetch()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $select = $sql->select('lista');
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
        $insert = $sql->insert('Lista');
        $insert->values(['nome'=>$this->nome]);
        $insertString = $sql->buildSqlString($insert);
        return  $adapter->query($insertString,$adapter::QUERY_MODE_EXECUTE);
    }
    public function delete()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $delete = $sql->delete('Lista');
        $delete->where(['id'=>$this->id]);
        $deleteString = $sql->buildSqlString($delete);
        $adapter->query($deleteString,$adapter::QUERY_MODE_EXECUTE);
    }
    public function editLista()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $update = $sql->update('Lista');
        $update->set(['nome' => $this->nome]);
        $update->where(['id'=>$this->id]);
        $updateString = $sql->buildSqlString($update);
        echo $updateString;
        $adapter->query($updateString, $adapter::QUERY_MODE_EXECUTE);
    }
}
