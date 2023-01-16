let myChart

$(document).ready(function () {

    var data = { "service": "GraficaBase" };
    var url = "./Controller/GraficasController.php";

    $.ajax({
        type: "POST",
        url: url,
        data: data,
        dataType: "JSON",
        success: function (response) {

            let cabeceras = response.cabeceras;
            let datos = response.datos;
            let fechas = response.fecha;
            let datasetValue = [];


            for (let i = 0; i < 3; i++) {
                var color = getRandomColor();
                datasetValue[i] = {
                    label: cabeceras[i],
                    backgroundColor: color,
                    borderColor: color,
                    data: []
                }

                datos.forEach(element => {
                     if (cabeceras[i] == element["concepto"]) {
                        datasetValue[i]["data"].push(element["valor"])
                     }
                });
            }

            const labels = fechas;
            const data_grafica = {
                labels: labels,
                datasets: datasetValue,
            }

            const config = {
                type: 'line',
                data: data_grafica,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Ventas'
                        }
                    }
                },
            };
        
            myChart = new Chart(
                document.getElementById('grafica'),
                config
            );
        }
    });

    $("#form_filtro").submit(function (e) { 
        e.preventDefault();
        let form = $("#form_filtro").serializeArray();
        form = form.concat({ name: "service", value: "filtro" });

        $.ajax({
            data: form,
            type: "POST",
            url: url,
            async: false,
            dataType: "JSON",
      
            success: function (response) {
                if (response.status == 202) {

                    let cabeceras = response.cabeceras;
                    let datos = response.datos;
                    let fechas = response.fecha;
                    let datasetValue = [];
                    let size = cabeceras.length;
                    let tipo = response.tipo;

        
                    for (let i = 0; i < size; i++) {
                        var color = getRandomColor();
                        datasetValue[i] = {
                            label: cabeceras[i],
                            backgroundColor: color,
                            borderColor: color,
                            data: []
                        }
        
                        datos.forEach(element => {
                             if (cabeceras[i] == element["concepto"]) {
                                datasetValue[i]["data"].push(element["valor"])
                             }
                        });
                    }
        
                    let labels = fechas;
                    let data_grafica = {
                        labels: labels,
                        datasets: datasetValue,
                    }
        
                    let config;

                    if (tipo == "Barra") {
                        
                        config = {
                            type: 'bar',
                            data: data_grafica,
                            options: {
                              scales: {
                                y: {
                                  beginAtZero: true
                                }
                              }
                            },
                          };
                    } else {
                        config = {
                            type: 'line',
                            data: data_grafica,
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    title: {
                                        display: true,
                                        text: 'Ventas'
                                    }
                                }
                            },
                        };
                    }


                    
                
                    myChart.destroy();
                    myChart = new Chart(
                        document.getElementById('grafica'),
                        config
                    );

                } else {
                    alert("No se Encontraron Datos");
                }
              
            },
          });
    });

    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

});