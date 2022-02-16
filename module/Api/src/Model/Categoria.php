<?php

namespace Api\Model;

use Zend\Db\Sql\Sql;

class Categoria
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
        $select = $sql->select('categoria');
        if($limit){
            $select->limit($limit);
        }
        if($offset){
            $select->offset($offset);
        }
        $select->order("$coluna $order");
        $selectString = $sql->buildSqlString($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        $categorias = array();

        foreach ($results->toArray() as $value) {
            $categorias[$value['id']] = $value['nome'];
        }
        return $categorias;
    }
    
    public function fetch()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $select = $sql->select('categoria');
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
        $insert = $sql->insert('categoria');
        $insert->values(['nome'=>$this->nome]);
        $insertString = $sql->buildSqlString($insert);
        $result = $adapter->query($insertString,$adapter::QUERY_MODE_EXECUTE);
        return $result->getAffectedRows();
    }
    public function delete()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $deleteString = "DELETE FROM categoria WHERE id = $this->id";
        $result = $adapter->query($deleteString,$adapter::QUERY_MODE_EXECUTE);
        return $result->getAffectedRows();
    }
    public function editCategoria()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $update = $sql->update('categoria');
        $update->set(['nome' => $this->nome]);
        $update->where(['id'=>$this->id]);
        $updateString = $sql->buildSqlString($update);
        echo $updateString;
        $adapter->query($updateString, $adapter::QUERY_MODE_EXECUTE);
    }
}
