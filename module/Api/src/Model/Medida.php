<?php

namespace Api\Model;

use Zend\Db\Sql\Sql;

class Medida
{
    private $id;
    private $medida;

    public function __construct()
    {
        $this->id = "";
        $this->medida = "";
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
        $select = $sql->select('medida');
        if($limit){
            $select->limit($limit);
        }
        if($offset){
            $select->offset($offset);
        }
        $select->order("$coluna $order");
        $selectString = $sql->buildSqlString($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        $medidas = array();

        foreach ($results->toArray() as $value) {
            $medidas[$value['id']] = $value['medida'];
        }
        return $medidas;
    }
    
    public function fetch()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $select = $sql->select('medida');
        $select->where(['id'=>$this->id]);
        $selectString = $sql->buildSqlString($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);

        foreach ($results->toArray() as $value) {
            $this->__set('medida',$value['medida']);
        }
    }

    public function insert()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $insert = $sql->insert('medida');
        $insert->values(['path'=>$this->path]);
        $insertString = $sql->buildSqlString($insert);
        $adapter->query($insertString,$adapter::QUERY_MODE_EXECUTE);
    }
    public function delete()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $delete = $sql->delete('medida');
        $delete->where(['id'=>$this->id]);
        $deleteString = $sql->buildSqlString($delete);
        $adapter->query($deleteString,$adapter::QUERY_MODE_EXECUTE);
    }
    public function editmedida()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $update = $sql->update('medida');
        $update->set(['medida' => $this->medida]);
        $update->where(['id'=>$this->id]);
        $updateString = $sql->buildSqlString($update);
        echo $updateString;
        $adapter->query($updateString, $adapter::QUERY_MODE_EXECUTE);
    }
}
