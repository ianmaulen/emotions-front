@extends('layouts/layout')

@section('content')
    <div class="row" >
        <div class="col-12 d-flex justify-content-center mt-5 mt-sm-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Analisis de Video</h5>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Carga tu video</label>
                        <input class="form-control" type="file" id="videoInput" accept="video/*">
                    </div>
                    <button type="button" class="btn btn-success" onclick="analizarVideo()">Analizar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row" >
        <div class="col-12 d-flex justify-content-center mt-5 mt-sm-2">
            <div class="card">
                <div class="card-body">
                    <div id="container" class="mt-3" style="width:100%; height:400px;"></div>
                </div>
            </div>
        </div>
    </div>
    
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
            success: function(data) {
                console.log('Video enviado y analizado con éxito');
                console.log(data);
                let seriesData = [];
                let emotionsObj = data.emotion_results
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
                // Crear el gráfico con los datos de las series
                Highcharts.chart('container', {
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
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error al enviar y analizar el video');
                console.log('HTTP status code: ' + jqXHR.status + ' ' + textStatus);
                console.log('Error message: ' + errorThrown);
            }
        });
    }
</script>
@endsection
