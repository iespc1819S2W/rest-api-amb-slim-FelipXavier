<?php
/**
 * Created by IntelliJ IDEA.
 * User: Felip Xavier
 * Date: 22/02/2019
 * Time: 18:43
 */

namespace App\Model;
use App\Lib\Database;
use App\Lib\Resposta;
use PDO;
use Exception;

class Colleccio
{
    private $conn;       //connexió a la base de dades (PDO)
    private $resposta;   // resposta

    public function __CONSTRUCT()
    {
        $objectebd=Database::getInstance();
        $this->conn = $objectebd->getConnection();
        $this->resposta = new Resposta();
    }

    public function getAll()
    {
        try
        {
            $result = array();
            $stm = $this->conn->prepare("SELECT * FROM COLLECCIONS");
            $stm->execute();
            $tuples=$stm->fetchAll();
            $this->resposta->setDades($tuples);    // array de tuples
            $this->resposta->setCorrecta(true);       // La resposta es correcta
            return $this->resposta;
        }
        catch(Exception $e)
        {   // hi ha un error posam la resposta a fals i tornam missatge d'error
            $this->resposta->setCorrecta(false, $e->getMessage());
            return $this->resposta;
        }
    }


    public function insert($data)
    {
        try
        {

            $collecio=$data['colleccio'];

            $sql = " INSERT INTO COLLECCIONS (COLLECCIO)
                            VALUES (:colleccio)";

            $stm=$this->conn->prepare($sql);
            $stm->bindValue(':colleccio',$collecio);
            $stm->execute();

            $this->resposta->setCorrecta(true, $stm->rowCount());
            return $this->resposta;
        }
        catch (Exception $e)
        {
            $this->resposta->setCorrecta(false, "Error insertant: ".$e->getMessage());
            return $this->resposta;
        }
    }

    public function getQuery($filtre)
    {
        try
        {

            $sql = "SELECT colleccio as label, colleccio as value FROM colleccions where colleccio like '%$filtre%'";

            $stm=$this->conn->prepare($sql);
            $stm->execute();
            $tuples = $stm->fetchAll();
            return $tuples;

        }
        catch (Exception $e)
        {
            $this->resposta->setCorrecta(false, "Error insertant: ".$e->getMessage());
            return $this->resposta;
        }
    }

}