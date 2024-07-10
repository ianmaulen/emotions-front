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
                    // showClusters(data.clusters);
                    showPersonalidades(data.clusters)
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

        let showPersonalidades = (clusters) => {
            let personalidadHtml = '';
            for (let cluster in clusters) {
                if (clusters.hasOwnProperty(cluster)) {
                    let texto = textos[cluster][clusters[cluster]];
                    personalidadHtml += `
                        <div class="col-12">
                            <div class="card" style="border-radius: 0px;">
                                <div class="card-body">
                                    <p style="text-align: justify;">${texto}</p>
                                </div>
                            </div>
                        </div>
                    `;
                }
            }
            document.getElementById('personalidades').innerHTML = personalidadHtml;
        }

        let textos = {
            creativo: {
                1: 'Según el análisis que hice de tus emociones, es muy posible que seas una persona esencialmente curiosa, que le gusta averiguar e investigar por cuenta propia. Tienes esa "tensión" por querer saber más: desde un simple chisme, hasta los secretos mejor guardados de tu familia. También podrías sentir curiosidad por los últimos descubrimientos del telescopio James Webb. Te gusta la exploración y la aventura. Eres una persona que se deja sorprender.',
                0: 'Según el análisis que hice de tus emociones, es muy posible que te sientas a gusto en ambientes estables y predecibles. Prefieres aquellas labores o trabajos donde los lineamientos están claramente establecidos; te agrada la rutina y no tienes problemas con adecuarte a los horarios. Aunque por lo general, prefieres los ambientes corporativos, no sería raro que en algún momento de tu vida pensaras en emprender: si fuera el caso, lo harías todo "by the book" y tratarías de llevar todo a un plano concreto en el menor tiempo posible.'
            },
            determinado: {
                1: 'Puedo observar que eres una persona de carácter fuerte, aunque muchas veces lo trates de controlar o contener. Sueles enamorarte de tus propias ideas, las que podrás llevar a cabo con determinación y ahínco. Cuando te pones un objetivo, los persigues y te obstinas en buscar todos los caminos posibles, explorando y evaluando opciones, hasta lograr ver los resultados. Me atrevería a decir que tienes potencial para ser un buen emprendedor.',
                0: 'Puedo observar que eres una persona reflexiva, que suele explorar distintos ángulos antes de tomar una decisión. Para aquellas cosas importantes, tu máxima sería "todo es relativo y depende del contexto". Muchas veces, esta filosofía de vida, te llevaría a dejarte asesorar por personas expertas en algún tema o en tus seres queridos antes de tomar decisiones en el trabajo o en tu vida diaria. Si me aventuro un poco más, podría decir que te agrada manifestar disciplina hacia la autoridad: no eres de aquellos que andan objetando o contradiciendo lo establecido.'
            },
            estructurado: {
                1: 'Diría también que eres una persona que crea y busca estructuras para desempeñarse en el trabajo y en la vida. Para ti, no es necesario "inventar la rueda" cada día. Basta con buscar esos métodos preestablecidos o que ya han sido largamente probados. Cuando te enfrentas a nuevos escenarios donde simplemente hay que "hacer camino al andar", evitas improvisaciones o decisiones aleatorias: prefieres observar, medir, probar y planificar antes de lanzarte a la acción. ',
                0: 'Diría también que eres esencialmente un "alma libre". Por definición, no te sientes a gusto con un exceso de métodos o estructuras que podrían obstaculizar la creatividad. Si bien buscas la disciplina en tu trabajo y sueles ser leal hacia la autoridad, no es raro verte objetando aquellos aspectos normativos que no te hacen del todo sentido. Tu espíritu de naturaleza libre, a veces te juega malas pasadas: con frecuencia se te olvidan cosas del diario vivir y pierdes con facilidad la atención, especialmente cuando estás frente a un tema que no es de tu interés. '
            },
            extrovertido: {
                1: 'Casi con certeza absoluta, me atrevo a decir que eres una persona estructuralmente extrovertida, ¿Qué implica ésto? En esencia que se te darían fácil las relaciones interpersonales. Parece que eres una persona socialmente espontánea, que se acerca con naturalidad a conocer a otras personas. Puede que seas de muchos amigos y amigas y que mantengas grupos del colegio, de la universidad y de trabajos anteriores. Para ti, el apoyo social y la red es la base de todo: te gusta compartir buenos momentos y dar a conocer las buenas noticias. Y de la misma manera, cuando tienes un problema, sientes la necesidad de llamar a ese amigo o amiga que sabes que te prestará oído. Lo que te voy a decir a continuación, podría no acomodarte mucho y en primera instancia, me dirás que no es así, pero también me da la sensación que no te gusta mucho estar contigo y evitarás cualquier instancia de soledad.',
                0: 'Casi con certeza absoluta, me atrevo a decir que eres estructuralmente introvertido, ¿Qué implica esto? En esencia ves con mucho interés las relaciones interpersonales, pero las tomas con cautela, eres de aquellas personas que cuando llega a un nuevo lugar -desde una fiesta, hasta un lugar de trabajo-, observas, analizas y luego te acercas de a poco, para luego soltarte un algo más. No eres de darte a conocer con facilidad, te sientes mejor escuchando -en primera instancia-, antes de empezar a contar algo sobre tí. Pero ¡ojo!, cuando ya entras en confianza, podrías hablar en demasía sobre tu visión o sobre tus experiencias, acaparando la atención y llegando a tener roles protagónicos. Si este fuera el caso, diría también que ésta es tu tensión vital, o tu modo estructural de relación con la sociedad: pasarías de momentos de ensimismamiento, introspección y reflexión en soledad -o con tu música favorita-, a episodios de mucha extroversión y expansividad social. Puede que lo anterior también haya marcado algún episodio de tu vida, y que ahora ya estés experimentando más tranquilidad social: ya no quieres exponerte tanto. Hoy conservas unos pocos pero buenos amigos y mostrarás interés por generar nuevos vínculos, siempre y cuando consideres que hay algo interesante en esa otra persona.'
            },
            racional: {
                1: 'Por último, creo que eres una persona que toma decisiones principalmente basadas en la racionalidad. Esto significa que para tí el análisis, la deducción y la inducción, serían la base para moverse en este mundo. Independiente a que existan temas "blandos" o asuntos "políticos" de por medio, para tí sería casi descabellado lanzarse a una aventura -desde un viaje, hasta un emprendimiento, pasando por las decisiones del mundo corporativo-, sin haber inventariado el contexto, el riesgo, el costo y los beneficios, etc. Sólo ten cuidado con sobreanalizar o pensar en demasía: eso podría ralentizar o derechamente, tirar por la borda proyectos importantes o cosas que le podrían haber agregado algo más de emoción a tu vida. ',
                0: 'Por último, creo que eres una persona que toma decisiones principalmente basadas en la emocionalidad. Esto significa que después de haber ponderado variables o de haber observado alguna situación, es tu intuición o la "corazonada" la que te lleva a decir que si o que no. Esto sería incluso, un modo de relacionarte con el mundo: eres una persona muy conectada con las emociones de los demás. Sabes que detrás del lenguaje no verbal, estaría la base de lo que el otro te está tratando de comunicar más allá de los argumentos que dé o de las evidencias que ponga sobre la mesa. Si bien esto te habría entregado gratas sorpresas y buenos resultados en tu vida, ten ojo, porque esta misma manera de relacionarte, te llevaría a sobre cargarte de las emociones de los demás, y -lo sabes- no siempre son buenas. En este punto, me transformaré en una IA muy atrevida y te daré un consejo sin que me lo hayas pedido: cuando tengas muchas emociones negativas dando vueltas, busca tu espacio de aislamiento y toma distancia antes de decidir cosas importantes. La calma y la introspección te ayudará a analizar con mesura. '
            }
        };

    </script>
@endsection