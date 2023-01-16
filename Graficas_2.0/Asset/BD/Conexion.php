<?php

/**
 * @author SalvadorAsquit
 * conecta con la base de datos
 */
class Conection
{
    public $ip;
    public $usuario;
    public $password;
    public $bd;


    /**
     * Funcion De la coneccion con la base de datos
     * @param servidor $String es la direccion ip del servidor
     * @param usuario $String es el login de la base de datos
     * @param password $String es la contraseña del usuario
     * @param bd  $String es el nombre d ela base de datos
     */
    function __construct($ip = "localhost", $usuario = "root", $password = "", $bd = "graficas")
    {
        $this->ip = $ip;
        $this->usuario = $usuario;
        $this->password = $password;
        $this->bd = $bd;
    }

    /**
     * Crea la Conection con la base de datos y nos devuelve el objeto Conection
     * o nos devuelve el error Sql
     */
    function coneccion_Mysqli()
    {

        try {
            $mysqli = new mysqli($this->ip, $this->usuario, $this->password, $this->bd);
            return $mysqli;
        } catch (\Throwable $exception) {
            $response = array(
                'status' => "500",
                'msg' => "Fallo en la coneccion de la base de datos"
            );
            return $response;
        }    
    }
}
