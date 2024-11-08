@extends('layouts/layout')

@section('content')
    <!-- Header-->
    <header class="masthead text-center text-white py-5">
        <div class="masthead-content py-5">
            <div class="container px-2 px-md-4">
                <div class="card bg-params">
                    <div class="card-header">
                        <h5 class="my-3 fs-3">Mantenedor de operaciones y valores</h5>
                    </div>
                    <div class="card-body">
                        <div class="row d-flex justify-content-center" id="content-data">
                            <div class="col-12 col-md-10">
                            <!-- Condiciones -->
                                <ul>
                                    @foreach($data as $item)
                                        <li class="mb-2 font-monospace text-justify"><strong class="fs-5">{{ $item['nombre'] }}</strong>
                                            <ul class="row">
                                                <textarea class="col-12 py-2 mt-2" type="text" rows="2"
                                                id="operation_{{$item['nombre']}}">{{ $item['operacion'] }}</textarea>
                                            </ul>
                                            <br>
                                            <ul> 
                                                <li class="mb-1">
                                                    <strong>Alto:</strong> mayor o igual a 
                                                    <input type="number" id="alto_{{$item['nombre']}}" class="" value="{{$item['alto']}}">
                                                </li>
                                                <li class="mb-1">
                                                    <strong>Medio:</strong> valores entre <strong>{{$item['alto']}}</strong> y <strong>{{$item['bajo']}}</strong>
                                                </li>
                                                <li class="mb-1">
                                                    <strong>Bajo:</strong> menor o igual a 
                                                    <input type="number" id="bajo_{{$item['nombre']}}" class="" value="{{$item['bajo']}}">
                                                </li>
                                            </ul>
                                        </li>
                                        <hr>
                                    @endforeach
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-dark btn-xl rounded-pill my-3" href="" onclick="validateAndSaveOperations(); event.preventDefault();">Guardar</a>
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
    <style>
        .error-border {
            border: 2px solid red;
        }
    </style>
    <script>
        let data = @json($data);

        /**
         * Guarda las modificaciones que existan en las operaciones
         */
        let saveOperations = () => {
            console.log('guardando...');
            let formData = new FormData();
            
            data.forEach(item => {
                let operationValue = $(`#operation_${item.nombre}`).val();
                let altoValue = $(`#alto_${item.nombre}`).val()
                let bajoValue = $(`#bajo_${item.nombre}`).val()
                formData.append(`${item.nombre}[operationValue]`, operationValue);
                formData.append(`${item.nombre}[altoValue]`, altoValue);
                formData.append(`${item.nombre}[bajoValue]`, bajoValue);
            });

            $.ajax({
                url: '{{ route('saveOperations') }}',
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

        let validateAndSaveOperations = () => {
            let isValid = true;
            let regex = /^\s*(CALM|HAPPY|SURPRISED|ANGRY|CONFUSED|SAD|FEAR|DISGUSTED|\d+|\+|\-|\*|\/|\^\d+|\(|\)|\s)+\s*$/; // Regex para operaciones con emociones, números y potencias

            $('textarea[id^="operation_"]').each(function() {
                if (!regex.test($(this).val())) {
                    isValid = false;
                    $(this).addClass('error-border'); // Añadir clase de error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de Validación',
                        text: 'Por favor, ingresa solo operaciones matemáticas válidas.'
                    });
                    showAlert();
                } else {
                    $(this).removeClass('error-border'); // Quitar clase de error si es válido
                }
            });

            data.forEach(item => {
                let altoInput = $(`#alto_${item.nombre}`);
                let bajoInput = $(`#bajo_${item.nombre}`);
                let altoValue = altoInput.val();
                let bajoValue = bajoInput.val();

                // Remover clase de error antes de la validación
                altoInput.removeClass('error-border');
                bajoInput.removeClass('error-border');

                if (altoValue === '' || bajoValue === '') {
                    isValid = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de Validación',
                        text: 'Los campos Alto y Bajo no pueden estar vacíos.'
                    });
                    if (altoValue === '') altoInput.addClass('error-border');
                    if (bajoValue === '') bajoInput.addClass('error-border');
                } else if (parseFloat(altoValue) <= parseFloat(bajoValue)) {
                    isValid = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de Validación',
                        text: 'El valor de Alto debe ser mayor que el valor de Bajo.'
                    });
                    altoInput.addClass('error-border');
                    bajoInput.addClass('error-border');
                }
            });

            if (isValid) {
                saveOperations();
            }
        }

        let showAlert = () => {
            let alertHtml = `
                <div class="alert alert-secondary col-10" role="alert">
                    <p>Las emociones permitidas son: <strong>CALM, HAPPY, SURPRISED, ANGRY, CONFUSED, SAD, FEAR, DISGUSTED</strong></p>
                    <p>En cuanto a las operaciones permitidas: <strong>'+', '-', '*', '/', '()', '^'</strong></p>
                </div>
            `;
            $('#content-data').append(alertHtml); // Insertar al final del div con id 'content-data'
        };
    </script>
@endsection