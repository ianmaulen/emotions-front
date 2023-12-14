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
                                <ul>
                                    <li class="mb-2 font-monospace text-justify"><strong>Extrovertido = 1:</strong> sólo si "HAPPY" tiene <input type="number" min="0" max="100" class="customInputParam" id="HappyExtrovertidoPeaks" value="{{$data['HAPPY']['extrovertido']['peaks']}}"> o más valores sobre 
                                        <input type="number" min="0" max="100" class="customInputParam" id="HappyExtrovertidoLimit" value="{{$data['HAPPY']['extrovertido']['limit']}}"> %. Si no se cumple esta condición, entonces "extrovertido" = 0.</li>
                                    <hr>
                                    <li class="mb-2 font-monospace text-justify"><strong>Determinado = 1:</strong> sólo si "CONFUSED" no tiene más de <input type="number" min="0" max="100" class="customInputParam" id="CofusedDeterminadoPeaks" value="{{$data['CONFUSED']['determinado']['peaks']}}"> valores sobre 
                                        <input type="number" min="0" max="100" class="customInputParam" id="CofusedDeterminadoLimit" value="{{$data['CONFUSED']['determinado']['limit']}}"> %. Además, "ANGRY" debe tener <input type="number" min="0" max="100" class="customInputParam" id="AngryDeterminadoPeaks" value="{{$data['ANGRY']['determinado']['peaks']}}"> o más valores sobre 
                                        <input type="number" min="0" max="100"" class="customInputParam" id="AngryDeterminadoLimit" value="{{$data['ANGRY']['determinado']['limit']}}"> %. Si no se cumple esta condición, entonces "determinado" = 0.</li>
                                    <hr>
                                    <li class="mb-2 font-monospace text-justify"><strong>Estructurado = 1:</strong> sólo si "CALM" tiene <input type="number" min="0" max="100" class="customInputParam" id="CalmEstructuradoPeaks" value="{{$data['CALM']['estructurado']['peaks']}}"> o más valores sobre 
                                        <input type="number" min="0" max="100" class="customInputParam" id="CalmEstructuradoLimit" value="{{$data['CALM']['estructurado']['limit']}}"> % y "SAD" tiene <input type="number" min="0" max="100" class="customInputParam" id="SadEstructuradoPeaks" value="{{$data['SAD']['estructurado']['peaks']}}"> o más valores sobre 
                                        <input type="number" min="0" max="100" class="customInputParam" id="SadEstructuradoLimit" value="{{$data['SAD']['estructurado']['limit']}}"> %. Si no se cumple esta condición, entonces "estructurado" = 0.</li>
                                    <hr>
                                    <li class="mb-2 font-monospace text-justify"><strong>Creativo = 1:</strong> sólo si "SURPRISED" tiene <input type="number" min="0" max="100" class="customInputParam" id="SurprisedCreativoPeaks" value="{{$data['SURPRISED']['creativo']['peaks']}}"> o más valores sobre 
                                        <input type="number" min="0" max="100" class="customInputParam" id="SurprisedCreativoLimits" value="{{$data['SURPRISED']['creativo']['limit']}}"> %. Si no se cumple esta condición, entonces "creativo" = 0.</li>
                                    <hr>
                                    <li class="font-monospace text-justify"><strong>Racional = 1:</strong> sólo si "CALM" tiene <input type="number" min="0" max="100" class="customInputParam" id="CalmRacionalPeaks" value="{{$data['CALM']['racional']['peaks']}}"> o más valores sobre 
                                        <input type="number" min="0" max="100" class="customInputParam" id="CalmRacionalLimit"  value="{{$data['CALM']['racional']['limit']}}"> % y "SAD" tiene <input type="number" min="0" max="100" class="customInputParam" id="SadRacionalPeaks" value="{{$data['SAD']['racional']['peaks']}}"> o más valores sobre 
                                        <input type="number" min="0" max="100" class="customInputParam" id="SadRacionalLimit" value="{{$data['SAD']['racional']['limit']}}"> %. Si no se cumple esta condición, entonces "estructurado" = 0.</li>
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
        let saveParams = () => {
            console.log('guardando...');
            let formData = new FormData();
            formData.append('HappyExtrovertido', JSON.stringify({ 'emotion' : 'HAPPY', 'cluster' : 'extrovertido',
                'peaks': $('#HappyExtrovertidoPeaks').val(), 'limit': $('#HappyExtrovertidoLimit').val() }));
            formData.append('CofusedDeterminado', JSON.stringify({  'emotion' : 'CONFUSED', 'cluster' : 'determinado',
                'peaks': $('#CofusedDeterminadoPeaks').val(), 'limit': $('#CofusedDeterminadoLimit').val() }));
            formData.append('AngryDeterminado', JSON.stringify({  'emotion' : 'ANGRY', 'cluster' : 'determinado',
                'peaks': $('#AngryDeterminadoPeaks').val(), 'limit': $('#AngryDeterminadoLimit').val() }));
            formData.append('CalmEstructurado', JSON.stringify({  'emotion' : 'CALM', 'cluster' : 'estructurado',
                'peaks' : $('#CalmEstructuradoPeaks').val(), 'limit': $('#CalmEstructuradoLimit').val() }));
            formData.append('SadEstructurado', JSON.stringify({  'emotion' : 'SAD', 'cluster' : 'estructurado',
                'peaks' : $('#SadEstructuradoPeaks').val(), 'limit': $('#SadEstructuradoLimit').val() }));
            formData.append('SurprisedCreativo', JSON.stringify({  'emotion' : 'SURPRISED', 'cluster' : 'creativo',
                'peaks' : $('#SurprisedCreativoPeaks').val(), 'limit': $('#SurprisedCreativoLimits').val() }));
            formData.append('CalmRacional', JSON.stringify({  'emotion' : 'CALM', 'cluster' : 'racional',
                'peaks' : $('#CalmRacionalPeaks').val(), 'limit': $('#CalmRacionalLimit').val() }));
            formData.append('SadRacional', JSON.stringify({  'emotion' : 'SAD', 'cluster' : 'racional',
                'peaks' : $('#SadRacionalPeaks').val(), 'limit': $('#SadRacionalLimit').val() }));

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
                        setTimeout(function() {
                            window.location.href = '{{ route('home') }}';
                        }, 2000);
                    });
                },
                error: function(e) {
                   console.log(e)
                },
            });
        }
    </script>
@endsection