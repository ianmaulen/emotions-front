@extends('layouts/layout')

@section('content')
    <!-- Header-->
    <header class="masthead text-center text-white">
        <div class="masthead-content">
            <div class="container px-5">
                <h5 class="masthead-heading mb-0 fs-2">Analicemos la Video Entrevista!</h5>
                <p class="text-center">Carga tu video y dale click en analizar para ver la información<br>
                    sobre las emociones y categorización mediante clusters
                </p>
                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-md-6">
                        <input class="customBtnFile w-100 mt-3" type="file" id="videoInput" accept="video/*">
                    </div>
                </div>
                <a id="btnAnalizar" class="btn btn-success btn-xl rounded-pill mt-5" href="#scroll" onclick="analizarVideo();"  event.preventDefault();">Analizar</a>
            </div>
        </div>
        <div class="bg-circle-1 bg-circle"></div>
        <div class="bg-circle-2 bg-circle"></div>
        <div class="bg-circle-3 bg-circle"></div>
        <div class="bg-circle-4 bg-circle"></div>
    </header>
    <!-- Content section 1-->
    <section id="scroll" class="d-none">
        <div class="container px-1 text-center mt-5">
            <h3>Resultado Análisis</h3>
            <div class="row w-100">
                <div class="col-12 d-flex justify-content-center mb-5 mt-sm-2" id="graphs">
                    <div class="card w-100">
                        <div class="card-body">
                            <div id="highcarts-container" class="mt-3" style="width:100%; max-height:500px;"></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row d-flex justify-content-center mb-5 text-center" id="clusters">
            </div>
            <div class="row d-flex justify-content-center mb-5 text-center">
                <button class="btn btn-dark btn-lrg col-10 col-md-4 rounded-pill" onclick="location.reload();">Volver a Analizar
                    <strong><i class="bi bi-arrow-clockwise ms-1 fw-bolder"></i></strong>
                </button>
            </div>
        </div>
    </section>
    
@endsection

@section('js')

    <script>
        let trueIcon = '<i class="bi bi-check-circle-fill text-success fs-1"></i>'
        let falseIcon = '<i class="bi bi-x-circle-fill text-danger fs-1"></i>'

        let analizarVideo = async() => {
            let formData = new FormData();
            let videoInput = $('#videoInput');
            let videoFile = videoInput[0].files[0];
            await formData.append('video', videoFile);
            $.ajax({
                url: '{{ route('analizarVideo') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    Swal.showLoading();
                },
                complete: function(){
                    Swal.close();
                },
                success: function(data) {
                    console.log('Video enviado y analizado con éxito');
                    console.log(data);
                    let seriesData = [];
                    let emotionsObj = data.emotion_results
                    // recorre la response para llenar las series que iran en el gráfico
                    for (let emotion in emotionsObj) {
                        if (emotionsObj.hasOwnProperty(emotion)) {
                            console.log(`Emotion: ${emotion}`);
                            let values = [];
                            for (let i = 0; i < emotionsObj[emotion].length; i++) {
                                const value = emotionsObj[emotion][i];
                                values.push(value);
                            }
                            seriesData.push({
                                name: emotion,
                                data: values
                            })
                        }
                    }
                    console.log(seriesData);
                    // Crear card para gráficos
                    showGraphs(seriesData);
                    showClusters(data.clusters);
                    $('#scroll').removeClass('d-none');
                    $('#btnAnalizar').addClass('disabled');
                    $('html, body').animate({ scrollTop: $(document).height() }, 'slow');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.close();
                    console.log('Error al enviar y analizar el video');
                    console.log('HTTP status code: ' + jqXHR.status + ' ' + textStatus);
                    console.log('Error message: ' + errorThrown);
                },
            });
        }

        let showGraphs = (seriesData) => {
            $('#graphs').html(`
                <div class="card w-100">
                    <div class="card-body">
                        <div id="highcarts-container" class="mt-3" style="width:100%; max-height:500px;"></div>
                    </div>
                </div>
            `);
            // Crear el gráfico con los datos de las series
            Highcharts.setOptions({
                accessibility: {
                    enabled: false
                },
                lang: {
                    downloadCSV: "Descargar CSV",
                    downloadJPEG: "Descargar JPEG",
                    downloadPDF: "Descargar PDF",
                    downloadPNG: "Descargar PNG",
                    downloadSVG: "Descargar SVG",
                    viewData: "Ver datos",
                    printChart: "Imprimir gráfico"
                },
                exporting: {
                    buttons: {
                        contextButton: {
                            menuItems: [
                                'downloadPNG',
                                'downloadJPEG',
                                'downloadPDF',
                                'downloadSVG',
                                'separator',
                                'downloadCSV',
                                'viewData',
                                'separator',
                                'printChart'
                            ]
                        }
                    },
                    csv: {
                        dateFormat: '%d/%m/%Y %H:%M:%S'
                    }
                }
            });
            Highcharts.chart('highcarts-container', {
                title: {
                    text: 'Emociones encontradas',
                    align: 'center'
                },
                yAxis: {
                    title: {
                        text: '% de coincidencia'
                    }
                },
                xAxis: {
                    accessibility: {
                        rangeDescription: 'Range: 1 to 30'
                    }
                },
                plotOptions: {
                    series: {
                        label: {
                            connectorAllowed: false
                        },
                        pointStart: 1
                    }
                },
                series: seriesData,
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                layout: 'horizontal',
                                align: 'center',
                                verticalAlign: 'bottom'
                            }
                        }
                    }]
                }
            });
        }

        let showClusters = (clusters) => {
            let clusterHtml = '';
            for (let cluster in clusters) {
                if (clusters.hasOwnProperty(cluster)) {
                    clusterHtml += `
                        <div class="col-5 col-md-2 text-center">
                            <h1 class="fs-4">${cluster.charAt(0).toUpperCase() + cluster.slice(1)}</h1>
                            ${clusters[cluster] === 1 ? trueIcon : falseIcon}
                        </div>
                    `;
                }
            }
            document.getElementById('clusters').innerHTML = clusterHtml;
        }

    </script>
@endsection