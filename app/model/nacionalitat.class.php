<?php
/**
 * Created by IntelliJ IDEA.
 * User: Felip Xavier
 * Date: 03/03/2019
 * Time: 11:18
 */

namespace App\Model;
use App\Lib\Database;
use App\Lib\Resposta;
use PDO;
use Exception;

class Nacionalitat
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
            $stm = $this->conn->prepare("SELECT * FROM NACIONALITATS");
            $stm->execute();
            $tuples=$stm->fetchALL();
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
}