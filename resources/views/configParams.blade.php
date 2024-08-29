@extends('layouts/layout')

@section('content')
    <!-- Header-->
    <header class="masthead text-center text-white py-5">
        <div class="masthead-content py-5">
            <div class="container px-2 px-md-4">
                <div class="card bg-params">
                    <div class="card-header">
                        <h5 class="my-3 fs-3">Cambiar parámetros de condicionales para determinación de Clusters</h5>
                    </div>
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-12 col-md-10">
                            <!-- Condiciones -->
                                <ul>
                                    <!-- Extrovertido -->
                                    <li class="mb-2 font-monospace text-justify"><strong>EXTROVERTIDO</strong>
                                        <ul>
                                            <li>ALTO:
                                                <ul>
                                                    <li>sólo si "happy" tiene <input type="number" min="0" max="100" class="customInputParam" id="ext_happy_alto_peak" value="{{$data['extrovertido']['alto']['HAPPY']['peak_limits']}}"> 
                                                    o más valores sobre <input type="number" min="0" max="100" class="customInputParam" id="ext_happy_alto_value" value="{{$data['extrovertido']['alto']['HAPPY']['value_limit']}}"> %.</li>
                                                </ul>
                                            </li>
                                            <li>MEDIO:
                                                <ul>
                                                    <li>sólo si "happy" tiene <input type="number" min="0" max="100" class="customInputParam" id="ext_happy_medio_peak" value="{{$data['extrovertido']['medio']['HAPPY']['peak_limits']}}">
                                                     o más valores sobre <input type="number" min="0" max="100" class="customInputParam" id="ext_happy_medio_value" value="{{$data['extrovertido']['medio']['HAPPY']['value_limit']}}"> %.</li>
                                                </ul>
                                            </li>
                                            <li>BAJO:
                                                <ul>
                                                    <li>sólo si "happy" no tiene valores sobre <strong>{{$data['extrovertido']['medio']['HAPPY']['value_limit']}}%</strong>.</li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <hr>
                                    <!-- Determinado -->
                                    <li class="mb-2 font-monospace text-justify"><strong>DETERMINADO</strong>
                                        <ul>
                                            <li>ALTO:
                                                <ul>
                                                    <li>sólo si "confused" no tiene más de <input type="number" min="0" max="100" class="customInputParam" id="det_confused_alto_peak" value="{{$data['determinado']['alto']['CONFUSED']['peak_limits']}}"> 
                                                    valores sobre <input type="number" min="0" max="100" class="customInputParam" id="det_confused_alto_value" value="{{$data['determinado']['alto']['CONFUSED']['value_limit']}}"> %. 
                                                    y "angry" debe tener <input type="number" min="0" max="100" class="customInputParam" id="det_angry_alto_peak" value="{{$data['determinado']['alto']['ANGRY']['peak_limits']}}"> 
                                                    o más valores sobre <input type="number" min="0" max="100" class="customInputParam" id="det_angry_alto_value" value="{{$data['determinado']['alto']['ANGRY']['value_limit']}}"> %. </li>
                                                </ul>
                                            </li>
                                            <li>MEDIO:
                                                <ul>
                                                    <li>sólo si "confused" no tiene más de <input type="number" min="0" max="100" class="customInputParam" id="det_confused_medio_peak" value="{{$data['determinado']['medio']['CONFUSED']['peak_limits']}}"> 
                                                    valores sobre <input type="number" min="0" max="100" class="customInputParam" id="det_confused_medio_value" value="{{$data['determinado']['medio']['CONFUSED']['value_limit']}}"> % 
                                                    o si "angry" tiene <input type="number" min="0" max="100" class="customInputParam" id="det_angry_medio_peak" value="{{$data['determinado']['medio']['ANGRY']['peak_limits']}}"> 
                                                    o más valores sobre <input type="number" min="0" max="100" class="customInputParam" id="det_angry_medio_value" value="{{$data['determinado']['medio']['ANGRY']['value_limit']}}"> %. </li>
                                                </ul>
                                            </li>
                                            <li>BAJO:
                                                <ul>
                                                    <li>sólo si "confused" tiene más de <strong>{{ $data['determinado']['medio']['CONFUSED']['peak_limits'] }}</strong> 
                                                    valores sobre <strong>{{ $data['determinado']['medio']['CONFUSED']['value_limit'] }}%</strong> 
                                                    o si "angry" no tiene <strong>{{ $data['determinado']['medio']['ANGRY']['peak_limits'] }}</strong> 
                                                    o más valores sobre <strong>{{ $data['determinado']['medio']['ANGRY']['value_limit'] }}%</strong> . </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <hr>
                                    <!-- Estructurado -->
                                    <li class="mb-2 font-monospace text-justify"><strong>ESTRUCTURADO</strong>
                                        <ul>
                                            <li>ALTO:
                                                <ul>
                                                    <li>sólo si "calm" tiene <input type="number" min="0" max="100" class="customInputParam" id="est_calm_alto_peak" value="{{$data['estructurado']['alto']['CALM']['peak_limits']}}"> 
                                                        o más valores sobre <input type="number" min="0" max="100" class="customInputParam" id="est_calm_alto_value" value="{{$data['estructurado']['alto']['CALM']['value_limit']}}"> % 
                                                        y "sad" tiene <input type="number" min="0" max="100" class="customInputParam" id="est_sad_alto_peak" value="{{$data['estructurado']['alto']['SAD']['peak_limits']}}"> 
                                                        o más valores sobre <input type="number" min="0" max="100" class="customInputParam" id="est_sad_alto_value" value="{{$data['estructurado']['alto']['SAD']['value_limit']}}"> %.</li>
                                                </ul>
                                            </li>
                                            <li>MEDIO:
                                                <ul>
                                                    <li>sólo si "calm" tiene <input type="number" min="0" max="100" class="customInputParam" id="est_calm_medio_peak" value="{{$data['estructurado']['medio']['CALM']['peak_limits']}}">
                                                         o más valores sobre <input type="number" min="0" max="100" class="customInputParam" id="est_calm_medio_value" value="{{$data['estructurado']['medio']['CALM']['value_limit']}}"> % 
                                                         o "sad" tiene <input type="number" min="0" max="100" class="customInputParam" id="est_sad_medio_peak" value="{{$data['estructurado']['medio']['SAD']['peak_limits']}}"> 
                                                         o más valores sobre <input type="number" min="0" max="100" class="customInputParam" id="est_sad_medio_value" value="{{$data['estructurado']['medio']['SAD']['value_limit']}}"> %.</li>
                                                </ul>
                                            </li>
                                            <li>BAJO:
                                                <ul>
                                                    <li>sólo si "calm" tiene <strong>{{$data['estructurado']['medio']['CALM']['peak_limits']}}</strong>
                                                         o menos valores sobre <strong>{{$data['estructurado']['medio']['CALM']['value_limit']}}%</strong>
                                                         y "sad" menos de <strong>{{$data['estructurado']['medio']['SAD']['peak_limits']}}</strong> 
                                                         valores sobre <strong>{{$data['estructurado']['medio']['SAD']['value_limit']}}%</strong>. </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <hr>
                                    <!-- Creativo -->
                                    <li class="mb-2 font-monospace text-justify"><strong>CREATIVO</strong>
                                        <ul>
                                            <li>ALTO:
                                                <ul>
                                                    <li>sólo si "surprised" tiene <input type="number" min="0" max="100" class="customInputParam" id="cre_surprised_alto_peak" value="{{$data['creativo']['alto']['SURPRISED']['peak_limits']}}">
                                                         o más valores sobre <input type="number" min="0" max="100" class="customInputParam" id="cre_surprised_alto_value" value="{{$data['creativo']['alto']['SURPRISED']['value_limit']}}"> %.</li>
                                                </ul>
                                            </li>
                                            <li>MEDIO:
                                                <ul>
                                                    <li>sólo si "surprised" tiene mas de <input type="number" min="0" max="100" class="customInputParam" id="cre_surprised_medio_peak" value="{{$data['creativo']['medio']['SURPRISED']['peak_limits']}}"> 
                                                        valores sobre <input type="number" min="0" max="100" class="customInputParam" id="cre_surprised_medio_value" value="{{$data['creativo']['medio']['SURPRISED']['value_limit']}}"> %.</li>
                                                </ul>
                                            </li>
                                            <li>BAJO:
                                                <ul>
                                                    <li>sólo si "surprised" no tiene valores sobre <strong>{{ $data['creativo']['medio']['SURPRISED']['value_limit'] }}%</strong>.</li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <hr>
                                    <!-- Racional -->
                                    <li class="mb-2 font-monospace text-justify"><strong>RACIONAL</strong>
                                        <ul>
                                            <li>ALTO:
                                                <ul>
                                                    <li>sólo si "calm" tiene <input type="number" min="0" max="100" class="customInputParam" id="rac_calm_alto_peak" value="{{$data['racional']['alto']['CALM']['peak_limits']}}"> 
                                                        o más valores sobre <input type="number" min="0" max="100" class="customInputParam" id="rac_calm_alto_value" value="{{$data['racional']['alto']['CALM']['value_limit']}}"> % 
                                                        y "sad" tiene <input type="number" min="0" max="100" class="customInputParam" id="rac_sad_alto_peak" value="{{$data['racional']['alto']['SAD']['peak_limits']}}"> 
                                                        o más valores sobre <input type="number" min="0" max="100" class="customInputParam" id="rac_sad_alto_value" value="{{$data['racional']['alto']['SAD']['value_limit']}}"> %. </li>
                                                </ul>
                                            </li>
                                            <li>MEDIO:
                                                <ul>
                                                    <li>sólo si "calm" tiene <input type="number" min="0" max="100" class="customInputParam" id="rac_calm_medio_peak" value="{{$data['racional']['medio']['CALM']['peak_limits']}}"> 
                                                        o más valores sobre <input type="number" min="0" max="100" class="customInputParam" id="rac_calm_medio_value" value="{{$data['racional']['medio']['CALM']['value_limit']}}"> %  
                                                        o "sad" tiene <input type="number" min="0" max="100" class="customInputParam" id="rac_sad_medio_peak" value="{{$data['racional']['medio']['SAD']['peak_limits']}}"> 
                                                        o más valores sobre <input type="number" min="0" max="100" class="customInputParam" id="rac_sad_medio_value" value="{{$data['racional']['medio']['SAD']['value_limit']}}"> %.</li>
                                                </ul>
                                            </li>
                                            <li>BAJO:
                                                <ul>
                                                    <li>sólo si "calm" tiene <strong>{{$data['racional']['medio']['CALM']['peak_limits']}}</strong> 
                                                        o menos valores sobre <strong>{{$data['racional']['medio']['CALM']['value_limit']}}%</strong>   
                                                        o "sad" tiene menos de <strong>{{$data['racional']['medio']['SAD']['peak_limits']}}</strong> 
                                                        valores sobre <strong>{{$data['racional']['medio']['SAD']['value_limit']}}%</strong>.</li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-dark btn-xl rounded-pill my-3" href="" onclick="saveParams(); event.preventDefault();">Guardar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-circle-1 bg-circle"></div>
        <div class="bg-circle-2 bg-circle"></div>
        <div class="bg-circle-3 bg-circle"></div>
        <div class="bg-circle-4 bg-circle"></div>
    </header>

    
@endsection

@section('js')
    <script>
        /**
         * Toma todos los parámetros (inputs) editables para los niveles 
         * alto y medio por cluster. Bajo dependerá de medio, es decir si no
         * se cumple la condicion para medio, será si o si 'bajo'
         */
        let saveParams = () => {
            console.log('guardando...');
            let formData = new FormData();
            // EXTROVERTIDO
            formData.append('ext_happy_alto', JSON.stringify({ 'emotion' : 'HAPPY', 'cluster' : 'extrovertido', 'level' : 'alto',
                'peaks': $('#ext_happy_alto_peak').val(), 'limit': $('#ext_happy_alto_value').val() }));
            formData.append('ext_happy_medio', JSON.stringify({  'emotion' : 'HAPPY', 'cluster' : 'extrovertido', 'level' : 'medio',
                'peaks': $('#ext_happy_medio_peak').val(), 'limit': $('#ext_happy_medio_value').val() }));

            // DETERMINADO
            formData.append('det_confused_alto', JSON.stringify({  'emotion' : 'CONFUSED', 'cluster' : 'determinado', 'level' : 'alto',
                'peaks': $('#det_confused_alto_peak').val(), 'limit': $('#det_confused_alto_value').val() }));
            formData.append('det_angry_alto', JSON.stringify({  'emotion' : 'ANGRY', 'cluster' : 'determinado', 'level' : 'alto',
                'peaks' : $('#det_angry_alto_peak').val(), 'limit': $('#det_angry_alto_value').val() }));
            formData.append('det_confused_medio', JSON.stringify({  'emotion' : 'CONFUSED', 'cluster' : 'determinado', 'level' : 'medio',
                'peaks' : $('#det_confused_medio_peak').val(), 'limit': $('#det_confused_medio_value').val() }));
            formData.append('det_angry_medio', JSON.stringify({  'emotion' : 'ANGRY', 'cluster' : 'determinado', 'level' : 'medio',
                'peaks' : $('#det_angry_medio_peak').val(), 'limit': $('#det_angry_medio_value').val() }));

            // ESTRUCTURADO
            formData.append('est_calm_alto', JSON.stringify({  'emotion' : 'CALM', 'cluster' : 'estructurado', 'level' : 'alto',
                'peaks': $('#est_calm_alto_peak').val(), 'limit': $('#est_calm_alto_value').val() })); 
            formData.append('est_sad_alto', JSON.stringify({  'emotion' : 'SAD', 'cluster' : 'estructurado', 'level' : 'alto',
                'peaks' : $('#est_sad_alto_peak').val(), 'limit': $('#est_sad_alto_value').val() }));
            formData.append('est_calm_medio', JSON.stringify({  'emotion' : 'CALM', 'cluster' : 'estructurado', 'level' : 'medio',
                'peaks' : $('#est_calm_medio_peak').val(), 'limit': $('#est_calm_medio_value').val() }));
            formData.append('est_sad_medio', JSON.stringify({  'emotion' : 'SAD', 'cluster' : 'estructurado', 'level' : 'medio',
                'peaks' : $('#est_sad_medio_peak').val(), 'limit': $('#est_sad_medio_value').val() }));

            // CREATIVO
            formData.append('cre_surprised_alto', JSON.stringify({  'emotion' : 'SURPRISED', 'cluster' : 'creativo', 'level' : 'alto',
                'peaks': $('#cre_surprised_alto_peak').val(), 'limit': $('#cre_surprised_alto_value').val() }));
            formData.append('cre_surprised_medio', JSON.stringify({  'emotion' : 'SURPRISED', 'cluster' : 'creativo', 'level' : 'medio',
                'peaks': $('#cre_surprised_medio_peak').val(), 'limit': $('#cre_surprised_medio_value').val() }));

            // RACIONAL
            formData.append('rac_calm_alto', JSON.stringify({  'emotion' : 'CALM', 'cluster' : 'racional', 'level' : 'alto',
                'peaks': $('#rac_calm_alto_peak').val(), 'limit': $('#rac_calm_alto_value').val() }));
            formData.append('rac_sad_alto', JSON.stringify({  'emotion' : 'SAD', 'cluster' : 'racional', 'level' : 'alto',
                'peaks': $('#rac_sad_alto_peak').val(), 'limit': $('#rac_sad_alto_value').val() }));
            formData.append('rac_calm_medio', JSON.stringify({  'emotion' : 'CALM', 'cluster' : 'racional', 'level' : 'medio',
                'peaks': $('#rac_calm_medio_peak').val(), 'limit': $('#rac_calm_medio_value').val() }));
            formData.append('rac_sad_medio', JSON.stringify({  'emotion' : 'SAD', 'cluster' : 'racional', 'level' : 'medio',
                'peaks': $('#rac_sad_medio_peak').val(), 'limit': $('#rac_sad_medio_value').val() }));

            $.ajax({
                url: '{{ route('saveParams') }}',
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
                success: function(data) {
                    console.log('Datos guardados correctamente...');
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: data.msg
                    }).then(function() {
                        window.location.href = '{{ route('home') }}';
                    });
                },
                error: function(e) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al guardar los datos.'
                    });
                   console.log(e)
                },
            });
        }
    </script>
@endsection