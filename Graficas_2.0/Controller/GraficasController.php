<?php
require_once "../Model/GraficasModel.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['service'])) {

        $Grafica = new Grafica();

        if (isset($Grafica->fail_conexion)) {
            $response = $Grafica->fail_conexion;

            try {
                echo json_encode($response, JSON_THROW_ON_ERROR);
            } catch (\JsonException $exception) {
                echo $exception->getMessage();
            }
            exit;
        }

        switch ($_POST['service']) {
            case 'GraficaBase':
                $response = $Grafica->Grafica_base();

                try {
                    echo json_encode($response, JSON_THROW_ON_ERROR);
                } catch (\JsonException $exception) {
                    echo $exception->getMessage();
                }
                break;

            case 'filtro':
                $response = $Grafica->Grafica_filtrada($_POST["filtro_concepto"],$_POST["filtro_desde"],$_POST["filtro_hasta"],$_POST["filtro_tipo"]);

                try {
                    echo json_encode($response, JSON_THROW_ON_ERROR);
                } catch (\JsonException $exception) {
                    echo $exception->getMessage();
                }
                break;

            default:
                $response = array(
                    'status' => "404",
                    'msg' => "'Service' not found"
                );
                try {
                    echo json_encode($response, JSON_THROW_ON_ERROR);
                } catch (\JsonException $exception) {
                    echo $exception->getMessage();
                }
                break;
        }
    }
} else {
    header('Location: http://localhost/Graficas_2.0/ ');
}
