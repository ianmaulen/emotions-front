@extends('layouts/layout')

@section('content')
    <!-- Header-->
    <header class="masthead text-center text-white">
        <div class="masthead-content">
            <div class="container px-5">
                <h5 class="masthead-heading mb-0 fs-2">Analicemos la Video Entrevista!</h5>
                <p class="text-center">Carga tu video, y dale click en analizar para ver la información</p>
                <div class="row d-flex justify-content-center">
                    <input class="form-control w-50 w-md-50 mt-3" type="file" id="videoInput" accept="video/*">
                </div>
                <a class="btn btn-success btn-xl rounded-pill mt-5" href="#scroll" onclick="analizarVideo(); event.preventDefault();">Analizar</a>
            </div>
        </div>
        <div class="bg-circle-1 bg-circle"></div>
        <div class="bg-circle-2 bg-circle"></div>
        <div class="bg-circle-3 bg-circle"></div>
        <div class="bg-circle-4 bg-circle"></div>
    </header>
    <!-- Content section 1-->
    <section id="scroll">
        <div class="container px-5">
            <div class="row" >
                <div class="col-12 d-flex justify-content-center mt-5 mt-sm-2" id="graphs">
                </div>
            </div>
        </div>
    </section>
    <!-- Content section 2-->
    <section>
        <div class="container px-5">
            <div class="row gx-5 align-items-center">
                <div class="col-lg-6">
                    <div class="p-5"><img class="img-fluid rounded-circle" src="assets/img/02.jpg" alt="..." /></div>
                </div>
                <div class="col-lg-6">
                    <div class="p-5">
                        <h2 class="display-4">We salute you!</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod aliquid, mollitia odio veniam sit iste esse assumenda amet aperiam exercitationem, ea animi blanditiis recusandae! Ratione voluptatum molestiae adipisci, beatae obcaecati.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer-->
    <footer class="py-5 bg-black">
        <div class="container px-5"><p class="m-0 text-center text-white small">Copyright &copy; Your Website 2023</p></div>
    </footer>
    
@endsection

@section('js')
    <script>
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
                    // TODO: añadir un título
                    $('#graphs').html(`
                        <div class="card">
                            <div class="card-body">
                                <div id="highcarts-container" class="mt-3" style="width:100%; max-height:500px;"></div>
                            </div>
                        </div>
                    `);
                    // Crear el gráfico con los datos de las series
                    Highcharts.setOptions({
                        lang: {
                            downloadCSV: "Descargar CSV",
                            downloadJPEG: "Descargar JPEG",
                            downloadPDF: "Descargar PDF",
                            downloadPNG: "Descargar PNG",
                            downloadSVG: "Descargar SVG",
                            downloadXLS: "Descargar XLS",
                            viewData: "Ver datos",
                            printChart: "Imprimir gráfico"
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
                    window.location.href = window.location.href + '#scroll';
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.close();
                    console.log('Error al enviar y analizar el video');
                    console.log('HTTP status code: ' + jqXHR.status + ' ' + textStatus);
                    console.log('Error message: ' + errorThrown);
                },
            });
        }
    </script>
@endsection