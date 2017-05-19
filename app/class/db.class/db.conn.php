 <?php
/**
 * Clase de conexiòn
 *
 * Clase para gestionar la conn a la base de datos
 *
 * @category   Configuracion
 * @package    base de datos
 * @copyright  Copyright (c) 2016 pseba20@gmail.com
 * @version    $Id:$
 */

require  "db.inc.php";
class MySQL {

   private $conn;
   private $query;
   private $transaction;


    /**
    * Contructor que inicia la conn
    */
    public function __construct (){
       $this->conn = mysqli_connect (DATABASE_HOST,DATABASE_USER,DATABASE_PASS);
       mysqli_set_charset($this->conn,"utf8");
       mysqli_select_db($this->conn,DATABASE_NAME);
   }

    /*funcion para transacciones*/
    public function transaction($sql_array)
    {
            /* switch autocommit status to FALSE. Actually, it starts transaction */
        $this->transaction = mysqli_autocommit($this->conn,FALSE);

            for($i=0;$i<count($sql_array);$i++)
            {
                $res = $this->query($sql_array[$i]);
                if ($res != "")
                {
                    $this->transaction = mysqli_rollback($this->conn);
                    return $sql_array[$i];
                }
            }

            mysqli_commit($this->conn);

        /* switch back autocommit status */
        $this->transaction = mysqli_autocommit($this->conn,TRUE);
    }

    /*
    * funcion que ejecuta una query sql
    * @param $Sql
    */

    public function query($sql){
       $this->query =  mysqli_query($this->conn,$sql);
        return mysqli_error($this->conn);
    }

    /**
    * funcion que retorna el resultado de una query en objetos
    */
    public function getObject(){
        $i = mysqli_num_rows($this->query); //Verifico si la query ha devuelto resultados
        if($i>0) {
            return mysqli_fetch_object($this->query);
        }
        else{
            /*Creo un objeto vacio para devolver*/
            $obj = new stdClass();
            $obj->queryr=0;
            $obj->agregar=0;
            $obj->editar=0;
            $obj->eliminar=0;
            return $obj;
        }
    }

    /**
    * Funcion que finaliza la conn a la base de datos
    */
    public function close () {
        mysqli_close($this->conn);
    }

    public function num_rows($query){
        return mysqli_num_rows($this->query);
    }

     public function fetch_array($query){

         return mysqli_fetch_array($this->query);
     }
 }