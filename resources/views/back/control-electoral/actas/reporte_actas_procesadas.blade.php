<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte</title>
</head>
<body>
    <table>
        <thead>
            @foreach ($actas_agrupados_recintos as $key=>$actas_agrupados_recinto)
                <tr>
                    <td colspan="16" style="text-align: center;">
                        <span style="font-weight: bold;">RECINTO:<span> {{$actas_agrupados_recinto[0]->junta->recinto->nombre}}
                        &nbsp;
                        PARROQUIA: {{$actas_agrupados_recinto[0]->junta->recinto->parroquia->nombre}}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center; font-weight: bold;">ACTA</td>
                    <td colspan="2"  style="text-align: center; font-weight: bold;">JUNTA</td>
                    <td colspan="2" style="text-align: center; font-weight: bold;">ESTADO</td>
                    <td colspan="2" style="text-align: center; font-weight: bold;">VOTANTES</td>
                    <td colspan="2" style="text-align: center; font-weight: bold;">BLANCOS</td>
                    <td colspan="2" style="text-align: center; font-weight: bold;">NULOS</td>
                    <td colspan="2" style="text-align: center; font-weight: bold;">CANDIDATOS</td>
                    <td colspan="2" style="text-align: center; font-weight: bold;">BNC</td>
                </tr>

                @foreach ($actas_agrupados_recinto as $key=>$acta)
                    <tr>
                        <td colspan="2"  style="text-align: center;">{{$acta->codigo}}</td>
                        <td colspan="2"  style="text-align: center;">{{$acta->junta->para_select}}</td>
                        <td colspan="2"  style="text-align: center;">{{$acta->inconsistente ? 'Inconsistente' : 'Válida' }}</td>
                        <td colspan="2"  style="text-align: center;">{{$acta->total_votantes}}</td>
                        <td colspan="2"  style="text-align: center;">{{$acta->votos_blancos}}</td>
                        <td colspan="2"  style="text-align: center;">{{$acta->votos_nulos}}</td>
                        <td colspan="2"  style="text-align: center;">{{$acta->totalVotosCandidatos}}</td>
                        <td colspan="2"  style="text-align: center;">{{$acta->totalBNC}}</td>
                    </tr>

                 
                        <tr>
                            @foreach ($acta->votosCandidatos as $key=>$voto_candidato)
                                <td colspan="3" style="text-align: center; font-weight: bold;">{{$voto_candidato->candidato->nombre}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            @foreach ($acta->votosCandidatos as $key=>$voto_candidato)
                                <td colspan="3" style="text-align: center; font-weight: bold;">{{$voto_candidato->votos}}</td>
                            @endforeach
                        </tr>
                        <tr></tr>
                   


                @endforeach



                <tr></tr>

            @endforeach
        </thead>
        <tbody>
          
        
        </tbody>

    </table>
</body>
</html>
