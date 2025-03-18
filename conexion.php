<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jp"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

class Conexion 
{
    public string $Query;
    private $Conection = null;
    public $Pps = null;

    private array $CredencialsBD = [
        "server"=>"localhost",
        "puerto"=>"3306",
        "name_bd"=>"jp",
        "user"=>"root",
        "pasword"=>""
    ];
    

    public function getBaseDeDatosConection()
    {
        $DriverMysql = "mysql:host=".$this->CredencialsBD["server"].";dbname="
        .$this->CredencialsBD["name_bd"];

        $this->Conection = new PDO($DriverMysql,$this->CredencialsBD["user"],$this->CredencialsBD["pasword"]);

        $this->Conection->exec("set names utf8");

        return $this->Conection;
    }

    /**
     * Cerrar la base de datos
     */

    public function closeDataBase()
    {
        if($this->Conection != null)
        {
            $this->Conection = null;
        }

        if($this->Pps != null)
        {
            $this->Pps = null;
        }
    }

}
?>
