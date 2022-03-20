<?php

namespace Api\Model;

use Zend\Db\Sql\Sql;

class FichaTecnica
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
        $select = $sql->select('ficha_tecnica');
        if($limit){
            $select->limit($limit);
        }
        if($offset){
            $select->offset($offset);
        }
        $select->order("$coluna $order");
        $selectString = $sql->buildSqlString($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        $FichaTecnicas = array();

        foreach ($results->toArray() as $value) {
            $FichaTecnica = array();
            $FichaTecnica['id'] = $value['id'];
            $FichaTecnica['nome'] = $value['nome'];
            $FichaTecnicas[] = $FichaTecnica;
        }
        return $FichaTecnicas;
    }
    public function fetchAllWithProduct($limit = null, $offset = null, $coluna = 'id' , $order = 'ASC' )
    {

        
        $con = new Connection();
        $adapter = $con->getAdapter();
        $selectString = "SELECT ft.id, ft.nome FROM ficha_tecnica ft JOIN ficha_tecnica_content ftc ON ftc.id_ficha_tecnica = ft.id  JOIN produto p ON p.id_FichaTecnica = ftc.id_produto GROUP BY c.id $limit $offset";
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        $FichaTecnicas = array();

        foreach ($results->toArray() as $value) {
            $FichaTecnica = array();
            $FichaTecnica['id'] = $value['id'];
            $FichaTecnica['nome'] = $value['nome'];
            $FichaTecnica['produtos'] = $value['produtos'];
            $FichaTecnicas[] = $FichaTecnica;
        }
        return $FichaTecnicas;

    }
    
    public function fetch()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $select = $sql->select('ficha_tecnica');
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
        $insert = $sql->insert('ficha_tecnica');
        $insert->values(['nome'=>$this->nome]);
        $insertString = $sql->buildSqlString($insert);
        $result = $adapter->query($insertString,$adapter::QUERY_MODE_EXECUTE);
        return $result->getAffectedRows();
    }
    public function delete()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $deleteString = "DELETE FROM FichaTecnica WHERE id = $this->id";
        $result = $adapter->query($deleteString,$adapter::QUERY_MODE_EXECUTE);
        return $result->getAffectedRows();
    }
    public function update()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $update = $sql->update('ficha_tecnica');
        $update->set(['nome' => $this->nome]);
        $update->where(['id'=>$this->id]);
        $updateString = $sql->buildSqlString($update);
        $result = $adapter->query($updateString, $adapter::QUERY_MODE_EXECUTE);
        return $result->getAffectedRows();
    }
}
