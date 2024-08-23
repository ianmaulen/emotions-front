@extends('layouts/layout')

@section('content')
<!-- Header-->
<header class="masthead text-center text-white py-5">
        <div class="masthead-content py-5">
            <div class="container px-2 px-md-4">
                <div class="card bg-params">
                    <div class="card-header">
                        <h5 class="my-3 fs-3">Cambiar outputs de clusterización</h5>
                    </div>
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-12">
                                <!-- ... código existente ... -->
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingExtrovertido">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExtrovertido" aria-expanded="false" aria-controls="collapseExtrovertido">
                                                EXTROVERTIDO
                                            </button>
                                        </h2>
                                        <div id="collapseExtrovertido" class="accordion-collapse collapse" aria-labelledby="headingExtrovertido" data-bs-parent="#accordionExample">
                                            <div class="accordion-body p-0">
                                                <div class="accordion sub-accordion" id="accordionExtrovertido">
                                                    @foreach(['alto', 'medio', 'bajo'] as $nivel)
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="heading{{ ucfirst($nivel) }}">
                                                                <button class="accordion-button px-5" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ ucfirst($nivel) }}" aria-expanded="false" aria-controls="collapse{{ ucfirst($nivel) }}">
                                                                    {{ ucfirst($nivel) }}
                                                                </button>
                                                            </h2>
                                                            <div id="collapse{{ ucfirst($nivel) }}" class="accordion-collapse collapse" aria-labelledby="heading{{ ucfirst($nivel) }}" data-bs-parent="#accordionExtrovertido">
                                                                <div class="accordion-body px-5">
                                                                    <table class="table">
                                                                        <tbody>
                                                                            @foreach($data['extrovertido'][$nivel] as $item)
                                                                                <tr>
                                                                                    <td class="text-justify">
                                                                                        <p id="text-{{$item['id']}}">{{ $item['text'] }}</p>
                                                                                        <div class="text-center">
                                                                                            <button class="btn btn-success" onclick="editText( '{{ $item['id'] }}', '{{ $item['text'] }}' )">Editar</button>
                                                                                            <button class="btn btn-danger" onclick="deleteText( '{{$item['id']}}' )">Eliminar</button>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingDeterminado">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDeterminado" aria-expanded="false" aria-controls="collapseDeterminado">
                                                DETERMINADO
                                            </button>
                                        </h2>
                                        <div id="collapseDeterminado" class="accordion-collapse collapse" aria-labelledby="headingDeterminado" data-bs-parent="#accordionExample">
                                            <div class="accordion-body p-0">
                                                <div class="accordion sub-accordion p-0">
                                                    @foreach(['alto', 'medio', 'bajo'] as $nivel)
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="heading{{ ucfirst($nivel) }}Determinado">
                                                                <button class="accordion-button px-5" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ ucfirst($nivel) }}Determinado" aria-expanded="false" aria-controls="collapse{{ ucfirst($nivel) }}Determinado">
                                                                    {{ ucfirst($nivel) }}
                                                                </button>
                                                            </h2>
                                                            <div id="collapse{{ ucfirst($nivel) }}Determinado" class="accordion-collapse collapse" aria-labelledby="heading{{ ucfirst($nivel) }}Determinado" data-bs-parent="#accordionDeterminado">
                                                                <div class="accordion-body px-5">
                                                                    <table class="table">
                                                                        <tbody>
                                                                            @foreach($data['determinado'][$nivel] as $item)
                                                                                <tr>
                                                                                    <td class="text-justify">
                                                                                        <p id="text-{{$item['id']}}">{{ $item['text'] }}</p>
                                                                                        <div class="text-center">
                                                                                            <button class="btn btn-success" onclick="editText( '{{ $item['id'] }}', '{{ $item['text'] }}' )">Editar</button>
                                                                                            <button class="btn btn-danger" onclick="deleteText( '{{$item['id']}}' )">Eliminar</button>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>          
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingEstructurado">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEstructurado" aria-expanded="false" aria-controls="collapseEstructurado">
                                                ESTRUCTURADO
                                            </button>
                                        </h2>
                                        <div id="collapseEstructurado" class="accordion-collapse collapse" aria-labelledby="headingEstructurado" data-bs-parent="#accordionExample">
                                            <div class="accordion-body p-0">
                                                <div class="accordion sub-accordion">
                                                    @foreach(['alto', 'medio', 'bajo'] as $nivel)
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="heading{{ ucfirst($nivel) }}Estructurado">
                                                                <button class="accordion-button px-5" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ ucfirst($nivel) }}Estructurado" aria-expanded="false" aria-controls="collapse{{ ucfirst($nivel) }}Estructurado">
                                                                    {{ ucfirst($nivel) }}
                                                                </button>
                                                            </h2>
                                                            <div id="collapse{{ ucfirst($nivel) }}Estructurado" class="accordion-collapse collapse" aria-labelledby="heading{{ ucfirst($nivel) }}Estructurado" data-bs-parent="#accordionEstructurado">
                                                                <div class="accordion-body px-5">
                                                                    <table class="table">
                                                                        <tbody>
                                                                            @foreach($data['estructurado'][$nivel] as $item)
                                                                                <tr>
                                                                                    <td class="text-justify">
                                                                                        <p id="text-{{$item['id']}}">{{ $item['text'] }}</p>
                                                                                        <div class="text-center">
                                                                                            <button class="btn btn-success" onclick="editText( '{{ $item['id'] }}', '{{ $item['text'] }}' )">Editar</button>
                                                                                            <button class="btn btn-danger" onclick="deleteText( '{{$item['id']}}' )">Eliminar</button>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingCreativo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCreativo" aria-expanded="false" aria-controls="collapseCreativo">
                                                CREATIVO
                                            </button>
                                        </h2>
                                        <div id="collapseCreativo" class="accordion-collapse collapse" aria-labelledby="headingCreativo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body p-0">
                                                <div class="accordion sub-accordion">
                                                    @foreach(['alto', 'medio', 'bajo'] as $nivel)
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="heading{{ ucfirst($nivel) }}Creativo">
                                                                <button class="accordion-button px-5" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ ucfirst($nivel) }}Creativo" aria-expanded="false" aria-controls="collapse{{ ucfirst($nivel) }}Creativo">
                                                                    {{ ucfirst($nivel) }}
                                                                </button>
                                                            </h2>
                                                            <div id="collapse{{ ucfirst($nivel) }}Creativo" class="accordion-collapse collapse" aria-labelledby="heading{{ ucfirst($nivel) }}Creativo" data-bs-parent="#accordionCreativo">
                                                                <div class="accordion-body px-5">
                                                                    <table class="table">
                                                                        <tbody>
                                                                            @foreach($data['creativo'][$nivel] as $item)
                                                                                <tr>
                                                                                    <td class="text-justify">
                                                                                        <p id="text-{{$item['id']}}">{{ $item['text'] }}</p>
                                                                                        <div class="text-center">
                                                                                            <button class="btn btn-success" onclick="editText( '{{ $item['id'] }}', '{{ $item['text'] }}' )">Editar</button>
                                                                                            <button class="btn btn-danger" onclick="deleteText( '{{$item['id']}}' )">Eliminar</button>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingRacional">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRacional" aria-expanded="false" aria-controls="collapseRacional">
                                                RACIONAL
                                            </button>
                                        </h2>
                                        <div id="collapseRacional" class="accordion-collapse collapse" aria-labelledby="headingRacional" data-bs-parent="#accordionExample">
                                            <div class="accordion-body p-0">
                                                <div class="accordion sub-accordion">
                                                    @foreach(['alto', 'medio', 'bajo'] as $nivel)
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="heading{{ ucfirst($nivel) }}Racional">
                                                                <button class="accordion-button px-5" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ ucfirst($nivel) }}Racional" aria-expanded="false" aria-controls="collapse{{ ucfirst($nivel) }}Racional">
                                                                    {{ ucfirst($nivel) }}
                                                                </button>
                                                            </h2>
                                                            <div id="collapse{{ ucfirst($nivel) }}Racional" class="accordion-collapse collapse" aria-labelledby="heading{{ ucfirst($nivel) }}Racional" data-bs-parent="#accordionRacional">
                                                                <div class="accordion-body px-5">
                                                                    <table class="table">
                                                                        <tbody>
                                                                            @foreach($data['racional'][$nivel] as $item)
                                                                                <tr>
                                                                                    <td class="text-justify">
                                                                                        <p id="text-{{$item['id']}}">{{ $item['text'] }}</p>
                                                                                        <div class="text-center">
                                                                                            <button class="btn btn-success" onclick="editText( '{{ $item['id'] }}', '{{ $item['text'] }}' )">Editar</button>
                                                                                            <button class="btn btn-danger" onclick="deleteText( '{{$item['id']}}' )">Eliminar</button>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- ... código existente ... -->
                            
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-success btn-xl rounded-pill my-3" href="" onclick="newOutput(), event.preventDefault();"><i class="bi bi-plus-circle me-2"></i> Agregar Outputs</a>
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
         * Levanta un alert con un textarea para editar el texto
         */
        let editText = (id, text) => {
            console.log(`${id}: ${text}`)
            Swal.fire({
                title: 'Editar texto',
                input: 'textarea',
                inputValue: text,
                inputAttributes: {
                    style: 'height: 90%; width: 90%',
                    rows: "10"
                },
                showCancelButton: true,
                confirmButtonText: 'Guardar',
                cancelButtonText: 'Cancelar',
                preConfirm: (newText) => {
                    if (!newText) {
                        Swal.showValidationMessage('El texto no puede estar vacío.')
                    }
                    return newText
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(`ID: ${id}, Nuevo texto: ${result.value}`);
                    saveText(id, result.value);
                }
            });
        } 

        /**
         * Guarda el nuevo texto
         */
        let saveText = (id, text) => {
            let formData = new FormData();
            formData.append('id', id);
            formData.append('text', text);

            $.ajax({
                url: '{{ route('saveOutput') }}',
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
                    console.log(data)
                    if (data.status === false) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.msg
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: data.msg
                        }).then(function() {
                            document.querySelector(`#text-${id}`).innerText = data.newText;
                        });
                    }
                },
                error: function(e) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al guardar los datos.'
                    });
                    console.log(e);
                },
            });
        }

        /**
         * Levanta un alert con un textarea y selects
         */
        let newOutput = () => {
            Swal.fire({
                title: 'Crear nuevo output',
                html: `
                    <div class="row">
                        <div class="col-6 text-start">
                            <label for="select-cluster" class="form-label">Cluster:</label>
                            <select id="select-cluster" class="form-select col-12 col-md-6">
                                <option value="" disabled selected>Seleccione un cluster</option>
                                <option value="extrovertido">Extrovertido</option>
                                <option value="determinado">Determinado</option>
                                <option value="estructurado">Estructurado</option>
                                <option value="creativo">Creativo</option>
                                <option value="racional">Racional</option>
                            </select>
                        </div>
                        <div class="col-6 text-start">
                            <label for="select-cluster" class="form-label">Nivel:</label>
                            <select id="select-level" class="form-select col-12 col-md-6">
                                <option value="" disabled selected>Seleccione un nivel</option>
                                <option value="alto">Alto</option>
                                <option value="medio">Medio</option>
                                <option value="bajo">Bajo</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-2 text-start">
                        <label for="textarea-text" class="form-label">Output:</label>
                        <textarea id="textarea-text" rows="10" class="form-control " placeholder="Ingrese el texto"></textarea>
                    </div>
                    
                `,
                confirmButtonText: 'Crear',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    const cluster = document.getElementById('select-cluster').value;
                    const level = document.getElementById('select-level').value;
                    const text = document.getElementById('textarea-text').value;
                    if (!cluster || !level || !text) {
                        Swal.showValidationMessage(`Por favor, complete todos los campos.`);
                    } else {
                        saveNewText(cluster, level, text);
                    }
                }
            });

        }

        /**
         * Crea un nuevo input o texto
         */
        let saveNewText = (cluster, level, text) => {
            let formData = new FormData();
            formData.append('cluster', cluster);
            formData.append('level', level);
            formData.append('text', text);

            $.ajax({
                url: '{{ route('newOutput') }}',
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
                    console.log('Datos guardados correctamente.');
                    console.log(data)
                    if (data.status === false) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.msg
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: data.msg
                        }).then(function() {
                            window.location.href = '{{ route('configOutputs') }}';
                        });
                    }
                },
                error: function(e) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al guardar los datos.'
                    });
                    console.log(e);
                },
            });
        }

        /**
         * Levanta un alert con un textarea para editar el texto
         */
        let deleteText = (id) => {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esto.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    saveDeleteText(id);
                }
            });
        } 

        /**
         * elimina el texto
         */
        let saveDeleteText = (id) => {
            let formData = new FormData();
            formData.append('id', id);

            $.ajax({
                url: '{{ route('deleteOutput') }}',
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
                    if (data.status === false) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.msg
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: data.msg
                        }).then(function() {
                            window.location.href = '{{ route('configOutputs') }}';
                        });
                    }
                },
                error: function(e) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al guardar los datos.'
                    });
                    console.log(e);
                },
            });
        }

    </script>
@endsection