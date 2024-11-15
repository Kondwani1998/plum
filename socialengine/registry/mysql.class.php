<?php class Mysqldb{
private $connections = array();
private $activeConnection = 0;
private $queryCache = array();
private $dataCache = array();
private $queryCounter = 0;
private $last;
private $registry;
public function __construct( Registry $registry )
{
$this->registry = $registry;
}


public function newConnection( $host, $user, $password, $database )
{
$this->connections[] = new mysqli( $host, $user, $password,$database );
$connection_id = count( $this->connections )-1;
if( mysqli_connect_errno() )
{
trigger_error('Error connecting to host. '.$this->connections[$connection_id]->error, E_USER_ERROR);
}
return $connection_id;
}

public function setActiveConnection( int $new )
{
$this->activeConnection = $new;
}


public function deleteRecords( $table, $condition, $limit )
{
$limit = ( $limit == '' ) ? '' : ' LIMIT ' . $limit;
$delete = "DELETE FROM {$table} WHERE {$condition} {$limit}";
$this->executeQuery( $delete );
}


}