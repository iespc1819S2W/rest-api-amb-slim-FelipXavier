<?php
/**
 * Created by IntelliJ IDEA.
 * User: Felip Xavier
 * Date: 10/01/2019
 * Time: 19:57
 */

namespace App\Model;
use App\Lib\Database;
use App\Lib\Resposta;
use PDO;
use Exception;

class Llibre
{
    private $conn;       //connexió a la base de dades (PDO)
    private $resposta;   // resposta

    public function __CONSTRUCT()
    {
        $objectebd=Database::getInstance();
        $this->conn = $objectebd->getConnection();
        $this->resposta = new Resposta();
    }
    public function getAll($orderby="id_llib")
    {
        try
        {
            $result = array();
            $stm = $this->conn->prepare("SELECT * FROM LLIBRES ORDER BY $orderby");
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

    public function get($id)
    {
        try
        {
            $result = array();
            $stm = $this->conn->prepare("SELECT * FROM LLIBRES lli left outer join editors ed on ed.ID_EDIT=lli.FK_IDEDIT where id_LLIB=:id_LLIB");
            $stm->bindValue(':id_LLIB',$id);
            $stm->execute();
            $tupla=$stm->fetch();
            $this->resposta->setDades($tupla);    // array de tuples
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
            $sql = "SELECT max(id_llib) as N from LLIBRES";
            $stm=$this->conn->prepare($sql);
            $stm->execute();
            $row=$stm->fetch();
            $id_llibre=$row["N"]+1;

            $titol=$data['titol'];
            $numedicio=isset($data['numedicio']) ? $data['numedicio'] : '';
            $llocedicio=isset($data['llocedicio']) ? $data['llocedicio'] : '';
            $anyedicio=isset($data['anyedicio']) ? $data['anyedicio'] : '';
            $descrip_llib=isset($data['descrip_llib']) ? $data['descrip_llib'] : '';
            $isbn=isset($data['isbn']) ? $data['isbn'] : '';
            $deplegal=isset($data['deplegal']) ? $data['deplegal'] : '';
            $signtop=isset($data['signtop']) ? $data['signtop'] : '';
            $databaixa_llib=isset($data['databaixa_llib']) ? $data['databaixa_llib'] : '';
            $motiubaixa=isset($data['motiubiaxa']) ? $data['motiubiaxa']: '';
            $fk_coleccio=isset($data['fk_coleccio']) ? $data['fk_coleccio'] : '';
            $fk_departament=isset($data['fk_departament']) ? $data['fk_departament'] : '';
            $fk_idedit=isset($data['fk_idedit']) ? $data['fk_idedit'] : '';
            $fk_llengua=isset($data['fk_llengua']) ? $data['fk_llengua'] : '';
            $img_llib=isset($data['img_llib']) ? $data['img_llib'] : '';

            $sql = " INSERT INTO LLIBRES (ID_LLIB, TITOL, NUMEDICIO, LLOCEDICIO, 
                          ANYEDICIO, DESCRIP_LLIB, ISBN, DEPLEGAL, SIGNTOP, DATBAIXA_LLIB, MOTIUBAIXA, 
                          FK_COLLECCIO, FK_DEPARTAMENT, FK_IDEDIT, FK_LLENGUA, IMG_LLIB)
                            VALUES (:id_llib,:titol,:numedicio,:llocedicio,:anyedicio,
                            :descrip_llib,:isbn,:deplegal,:signtop,:databaixa_llib,:motiubaixa,
                            :fk_coleccio,:fk_departament,:fk_idedit,:fk_llengua,:img_llib)";

            $stm=$this->conn->prepare($sql);
            $stm->bindValue(':id_llib',$id_llibre);
            $stm->bindValue(':titol',$titol);
            $stm->bindValue(':numedicio',!empty($numedicio)?$numedicio:NULL,PDO::PARAM_STR);
            $stm->bindValue(':llocedicio',!empty($llocedicio)?$llocedicio:NULL,PDO::PARAM_STR);
            $stm->bindValue(':anyedicio',!empty($anyedicio)?$anyedicio:NULL,PDO::PARAM_STR);
            $stm->bindValue(':descrip_llib',!empty($descrip_llib)?$descrip_llib:NULL,PDO::PARAM_STR);
            $stm->bindValue(':isbn',!empty($isbn)?$isbn:NULL,PDO::PARAM_STR);
            $stm->bindValue(':deplegal',!empty($deplegal)?$deplegal:NULL,PDO::PARAM_STR);
            $stm->bindValue(':signtop',!empty($signtop)?$signtop:NULL,PDO::PARAM_STR);
            $stm->bindValue(':databaixa_llib',!empty($databaixa_llib)?$databaixa_llib:NULL,PDO::PARAM_STR);
            $stm->bindValue(':motiubaixa',!empty($motiubaixa)?$motiubaixa:NULL,PDO::PARAM_STR);
            $stm->bindValue(':fk_coleccio',!empty($fk_coleccio)?$fk_coleccio:NULL,PDO::PARAM_STR);
            $stm->bindValue(':fk_departament',!empty($fk_departament)?$fk_departament:NULL,PDO::PARAM_STR);
            $stm->bindValue(':fk_idedit',!empty($fk_idedit)?$fk_idedit:NULL,PDO::PARAM_STR);
            $stm->bindValue(':fk_llengua',!empty($fk_llengua)?$fk_llengua:NULL,PDO::PARAM_STR);
            $stm->bindValue(':img_llib',!empty($img_llib)?$img_llib:NULL,PDO::PARAM_STR);
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


    public function update($data)
    {
        try{
            $id_llib = $data["id_llib"];
            $nomLlibre = $data["titol"];
            $numEdicio = isset($data['numEdicio']) ? $data['numEdicio'] : '';
            $llocedicio = isset($data['llocedicio']) ? $data['llocedicio'] : '';
            $anyedicio = isset($data['anyedicio']) ? $data['anyedicio'] : '';
            $descrip_llib = isset($data['descrip_llib']) ? $data['descrip_llib'] : '';
            $isbn = isset($data['isbn']) ? $data['isbn'] : '';
            $deplegal = isset($data['deplegal']) ? $data['deplegal'] : '';
            $signtop = isset($data['signtop']) ? $data['signtop'] : '';
            $datbaixa_llib = isset($data['datbaixa_llib']) ? $data['datbaixa_llib'] : '';
            $motiubaixa = isset($data['motiubaixa']) ? $data['motiubaixa'] : '';
            $fk_colleccio = isset($data['fk_colleccio']) ? $data['fk_colleccio'] : '';
            $fk_departament = isset($data['fk_departament']) ? $data['fk_departament'] : '';
            $fk_idedit = isset($data['fk_idedit']) ? $data['fk_idedit'] : '';
            $fk_llengua = isset($data['fk_llengua']) ? $data['fk_llengua'] : '';
            $img_llib = isset($data['img_llib']) ? $data['img_llib'] : '';

            $sql = "UPDATE LLIBRES SET
            titol = :nomLlibre,
            numEdicio = :numEdicio,
            llocedicio = :llocedicio,
            anyedicio = :anyedicio,
            descrip_llib = :descrip_llib,
            isbn = :isbn,
            deplegal = :deplegal,
            signtop = :signtop,
            datbaixa_llib = :datbaixa_llib,
            motiubaixa = :motiubaixa,
            fk_colleccio = :fk_colleccio,
            fk_departament =:fk_departament, 
            fk_idedit = :fk_idedit,
            fk_llengua = :fk_llengua, 
            img_llib = :img_llib
            WHERE id_llib = :id_llib";

            $stm=$this->conn->prepare($sql);
            $stm->bindValue(':id_llib', $id_llib);
            $stm->bindValue(':nomLlibre', $nomLlibre);
            $stm->bindValue(':numEdicio', !empty($numEdicio)?$numEdicio:NULL,PDO::PARAM_STR);
            $stm->bindValue(':llocedicio', !empty($llocedicio)?$llocedicio:NULL,PDO::PARAM_STR);
            $stm->bindValue(':anyedicio', !empty($anyedicio)?$anyedicio:NULL,PDO::PARAM_STR);
            $stm->bindValue(':descrip_llib', !empty($descrip_llib)?$descrip_llib:NULL,PDO::PARAM_STR);
            $stm->bindValue(':isbn', !empty($isbn)?$isbn:NULL,PDO::PARAM_STR);
            $stm->bindValue(':deplegal', !empty($deplegal)?$deplegal:NULL,PDO::PARAM_STR);
            $stm->bindValue(':signtop', !empty($signtop)?$signtop:NULL,PDO::PARAM_STR);
            $stm->bindValue(':datbaixa_llib',!empty($datbaixa_llib)?$datbaixa_llib:NULL,PDO::PARAM_STR);
            $stm->bindValue(':motiubaixa', !empty($motiubaixa)?$motiubaixa:NULL,PDO::PARAM_STR);
            $stm->bindValue(':fk_colleccio',!empty($fk_colleccio)?$fk_colleccio:NULL,PDO::PARAM_STR);
            $stm->bindValue(':fk_departament',!empty($fk_departament)?$fk_departament:NULL,PDO::PARAM_STR);
            $stm->bindValue(':fk_idedit', !empty($fk_idedit)?$fk_idedit:NULL,PDO::PARAM_STR);
            $stm->bindValue(':fk_llengua',!empty($fk_llengua)?$fk_llengua:NULL,PDO::PARAM_STR);
            $stm->bindValue(':img_llib', !empty($img_llib)?$img_llib:NULL,PDO::PARAM_STR);
            $stm->execute();
            $this->resposta->setCorrecta(true,"Update".$stm->rowCount());
            return $this->resposta;
        }
        catch (Exeption $e)
        {
            $this->resposta->setCorrecta(false, "Error actualitzant: ".$e->getMessage());
            return $this->resposta;
        }
    }
    public function delete($data)
    {
        try {
            $id_llib = $data["id_llib"];
            $sql="DELETE from llibres where id_llib = :id_llib";
            $stm=$this->conn->prepare($sql);
            $stm->bindValue(':id_llib',$id_llib);
            $stm->execute();
            $this->resposta->setCorrecta(true, $stm->rowCount());
            return $this->resposta;
        } catch (Exeption $e){
            $this->resposta->setCorrecta(false, "Error ID incorrecte o no se ha pogut borrar: ".$e->getMessage());
            return $this->resposta;
        }
    }
    public function filtra($where,$orderby,$offset,$count)
    {
        try {
            $bWhere=true;
            $limit=false;
            $bOffset=false;
            $sql="SELECT * from LLIBRES";
            if(strlen($where)==0){
                $bWhere=false;
            } else {
                $sql=$sql." WHERE titol like :w";
            }

            if(strlen($orderby)==0){
            } else {
                $orderby = filter_var($orderby, FILTER_SANITIZE_STRING);
                $sql=$sql." ORDER BY $orderby";
            }
            if($count!=""){
                $limit=true;
                if($offset!=""){
                    $bOffset=true;
                    $sql=$sql." limit :offset,:count";
                } else {
                    $sql=$sql." limit :count";
                }
            }
            $stm=$this->conn->prepare($sql);

            if($bWhere){
                $stm->bindValue(':w','%'.$where.'%');
            }
            if($limit){
                $count=(int)$count;
                $stm->bindValue(':count',$count,PDO::PARAM_INT);
            }
            if($bOffset){
                $offset=(int)$offset;
                $stm->bindValue(':offset',$offset,PDO::PARAM_INT);
            }

            $stm->execute();
            $tuples=$stm->fetchAll();

            $this->resposta->setDades($tuples);
            $this->resposta->setCorrecta(true);
            return $this->resposta;
        } catch (Exeption $e){
            $this->resposta->setCorrecta(false, "Error select: ".$e->getMessage());
            return $this->resposta;
        }
    }

    public function insertAutLlib($data)
    {
        try
        {
            $fk_idllib=(int)$data['id_llib'];
            $fk_idaut=(int)$data['id_aut'];
            $fk_rolaut=isset($data['rolaut']) ? $data['rolaut'] : '';
            $sql = "INSERT INTO LLI_AUT
                            (fk_idllib,fk_idaut,fk_rolaut)
                            VALUES (:fk_idllib,:fk_idaut,:fk_rolaut)";

            $stm=$this->conn->prepare($sql);
            $stm->bindValue(':fk_idllib',$fk_idllib);
            $stm->bindValue(':fk_idaut',$fk_idaut);
            $stm->bindValue(':fk_rolaut',!empty($fk_rolaut)?$fk_rolaut:NULL,PDO::PARAM_STR);
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

    public function deleteAutLlib($data)
    {
        try
        {
            $fk_idllib=(int)$data['id_llib'];
            $fk_idaut=(int)$data['id_aut'];

            $sql = "DELETE FROM LLI_AUT
                    WHERE FK_IDLLIB = :fk_idllib AND
                    FK_IDAUT = :fk_idaut";

            $stm=$this->conn->prepare($sql);
            $stm->bindValue(':fk_idllib',$fk_idllib);
            $stm->bindValue(':fk_idaut',$fk_idaut);

            $stm->execute();

            $this->resposta->setCorrecta(true, $stm->rowCount());
            return $this->resposta;
        }
        catch (Exception $e)
        {
            $this->resposta->setCorrecta(false, "Error borrant: ".$e->getMessage());
            return $this->resposta;
        }
    }


    public function llibreAutors($id_llibre)
    {
        try
        {
            $result = array();
            $stm = $this->conn->prepare("SELECT au.ID_AUT as Codi_Autor,NOM_AUT as Nom, llib.ID_LLIB as Codi_Llibre, llib.TITOL as Titol, au.FK_NACIONALITAT as Nacionalitat, au.DNAIX_AUT as Data_naixament from AUTORS au
            INNER join LLI_AUT llia on au.ID_AUT=llia.FK_IDAUT
            INNER join LLIBRES llib on llia.FK_IDLLIB=llib.ID_LLIB where llib.id_LLIB=:id_llib");
            $stm->bindValue(':id_llib',$id_llibre);
            $stm->execute();
            $tupla=$stm->fetchAll();
            $this->resposta->setDades($tupla);    // array de tuples
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