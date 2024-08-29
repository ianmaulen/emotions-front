@extends('layouts/layout')

@section('content')
    <!-- Header-->
    <header class="masthead text-center text-white">
        <div class="masthead-content">
            <div class="container px-5">
                <h5 class="masthead-heading mb-0 fs-2">Analicemos la Video Entrevista!</h5>
                <p class="text-center">Carga tu video, escribe una instrucción para el algoritmo y dale click en analizar<br> 
                    para ver la información obtenida.
                </p>
                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-md-6">
                        <input class="customBtnFile w-100 mt-3" type="file" id="videoInput" accept="video/*">
                        <textarea name="gpt-instruction" id="gpt-instruction" class="instruction-text text-white  mt-3" rows="5"
                        placeholder="Escribe una instrucción..."></textarea>
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
            <!-- <div class="row d-flex justify-content-center mb-5 text-center" id="clusters"></div> -->
            <div class="row d-flex justify-content-center mb-5 text-center" id="personalidades"></div>
            <div class="row d-flex justify-content-center mb-5 text-center">
                <button class="btn btn-dark btn-lrg col-10 col-md-4 rounded-pill" onclick="location.reload();">Volver a Analizar
                    <strong><i class="bi bi-arrow-clockwise ms-1 fw-bolder"></i></strong>
                </button>
            </div>
        </div>
    </section>
    
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        let trueIcon = '<i class="bi bi-check-circle-fill text-success fs-1"></i>';
        let falseIcon = '<i class="bi bi-x-circle-fill text-danger fs-1"></i>';

        let output_text = '';
        let formatedOutputMD = '';

        let analizarVideo = async() => {
            let formData = new FormData();
            let instruction = $('#gpt-instruction').val();
            let videoInput = $('#videoInput');
            let videoFile = videoInput[0].files[0];
            await formData.append('video', videoFile);
            await formData.append('instruction', instruction);
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
                    // showClusters(data.clusters);
                    showPersonalidades(data.output)
                    $('#scroll').removeClass('d-none');
                    $('#btnAnalizar').addClass('disabled');
                    $('html, body').animate({ scrollTop: $(document).height() }, 'slow');
                    Swal.close();
                },
                error: function(e) {  
                    console.log(e)
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: e.responseJSON.error,
                    });
                    
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

        let showPersonalidades = (texto) => {
            let markdownHtml = marked.parse(texto); // Convertir Markdown a HTML
            formatedOutputMD = markdownHtml;
            let personalidadHtml = `
                <div class="col-12">
                    <div class="card" style="border-radius: 10px;">
                        <div class="card-body">
                            
                            <div style="text-align: justify;">${markdownHtml}</div>
                            <div class="row mt-5 justify-content-center">
                                <div class="col-6 col-md-3">
                                    <button class="btn btn-danger rounded-pill" onclick="downloadOutput();">
                                    <i class="bi bi-filetype-txt me-1"></i> Descargar TXT </button>
                                </div>
                                <div class="col-6 col-md-3">
                                    <button class="btn btn-dark rounded-pill" onclick="downloadOutputPDF();">
                                    <i class="bi bi-filetype-pdf me-1"></i> Descargar PDF </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            output_text = texto;
            document.getElementById('personalidades').innerHTML = personalidadHtml;
        }

        let downloadOutput = () => {
            // Crear un blob con el texto
            const blob = new Blob([output_text], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'output.txt'; // Cambia la extensión según sea necesario
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }

        let downloadOutputPDF = () => {
            const { jsPDF } = window.jspdf; // Asegúrate de que jsPDF esté cargado

            const hiddenDiv = document.createElement('div');
            hiddenDiv.style.width = '210mm'; // Ancho de A4 en mm
            hiddenDiv.style.padding = '50px'; // Añadir algo de espacio alrededor
            hiddenDiv.style.position = 'absolute'; // Para evitar desplazamientos visuales
            hiddenDiv.style.left = '-9999px'; // Ocultar el div fuera de la pantalla
            hiddenDiv.innerHTML = formatedOutputMD;
            document.body.appendChild(hiddenDiv);

            // Convertir el contenido HTML a texto plano
            const textContent = hiddenDiv.innerText || hiddenDiv.textContent;

            const pdf = new jsPDF('p', 'mm', 'a4');
            const pageHeight = pdf.internal.pageSize.height; // Altura de la página
            const margin = 10; // Margen
            let y = margin; // Posición vertical inicial
            pdf.setFontSize(12);

            const lines = pdf.splitTextToSize(textContent, 190); 
            for (let i = 0; i < lines.length; i++) {
                if (y + 10 > pageHeight - margin) { 
                    pdf.addPage(); 
                    y = margin; 
                }
                pdf.text(lines[i], margin, y); 
                y += 10; 
            }

            pdf.save(`Informe-${new Date().toLocaleDateString('es-ES').replace(/\//g, '')}.pdf`);
            document.body.removeChild(hiddenDiv);
        }
    </script>
@endsection