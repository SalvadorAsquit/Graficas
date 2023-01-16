<?php
require_once "../Asset/BD/Conexion.php";

class Grafica
{
    public $mysqli;
    public $fail_conexion;

    function __construct()
    {
        $conexion = new Conection();
        $this->mysqli = $conexion->coneccion_Mysqli();

        if (!isset($this->mysqli->errno)) {
            $this->fail_conexion = $this->mysqli;
        }
    }

    function Grafica_base()
    {
        $sql = "SELECT * FROM `registros` ORDER BY fecha_Inserccion;";

        $result = $this->mysqli->query($sql);

        while ($row = $result->fetch_assoc()) {
            $datos[] = $row;
        }

        if (isset($datos)) {
            $cabeceras = array_column($datos, "concepto");
            $cabeceras_sin_repetir = array_unique($cabeceras);
            sort($cabeceras_sin_repetir);

            $Fechas = array_column($datos, "fecha_Inserccion");
            $Fechas_sin_repetir = array_unique($Fechas);
            sort($Fechas_sin_repetir);

            $response = array(
                "status" => "202",
                "cabeceras" => $cabeceras_sin_repetir,
                "datos" => $datos,
                "fecha" => $Fechas_sin_repetir,
            );

            return $response;
        } else {
            $response = array(
                "status" => "500",
                "msg" => "No se encontraron datos",
            );

            return $response;
        }
    }

    function Grafica_filtrada($concepto, $desde, $hasta, $tipo)
    {
   
        $concepto = $concepto != "" ? $concepto : "*";
        $desde = $desde != "" ? $desde : "2022-05-01";
        $hasta = $hasta != "" ? $hasta : "2022-05-21";

        if ($concepto!= "*") {
            $sql = "SELECT * FROM `registros` WHERE concepto = '{$concepto}' AND fecha_Inserccion BETWEEN '{$desde}' AND '{$hasta}' ORDER BY fecha_Inserccion;";

        }else {
            $sql = "SELECT * FROM `registros` WHERE fecha_Inserccion BETWEEN '{$desde}' AND '{$hasta}' ORDER BY fecha_Inserccion;";

        }

        $result = $this->mysqli->query($sql);

        while ($row = $result->fetch_assoc()) {
            $datos[] = $row;
        }

        if (isset($datos)) {
            $cabeceras = array_column($datos, "concepto");
            $cabeceras_sin_repetir = array_unique($cabeceras);
            sort($cabeceras_sin_repetir);

            $Fechas = array_column($datos, "fecha_Inserccion");
            $Fechas_sin_repetir = array_unique($Fechas);
            sort($Fechas_sin_repetir);


            $response = array(
                "status" => "202",
                "cabeceras" => $cabeceras_sin_repetir,
                "datos" => $datos,
                "fecha" => $Fechas_sin_repetir,
                "tipo" => $tipo
            );

            return $response;
        } else {
            $response = array(
                "status" => "500",
                "msg" => "No se encontraron datos",
            );

            return $response;
        }



    }
}
