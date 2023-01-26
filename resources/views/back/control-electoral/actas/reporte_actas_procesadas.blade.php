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
                    <td colspan="34" style="background-color: #CFD8DC">
                        RECINTO: {{ $actas_agrupados_recinto[0]->junta->recinto->nombre}}, PARROQUIA: {{$actas_agrupados_recinto[0]->junta->recinto->parroquia->nombre}}
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
                            @foreach ($actas_agrupados_recinto[0]->votosCandidatos as $key=>$voto_candidato)
                                <td colspan="2" style="text-align: center; font-weight: bold;">{{$voto_candidato->candidato->nombreCorto}}</td>
                            @endforeach
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
                            @foreach ($acta->votosCandidatos as $key=>$voto_candidato)
                                <td colspan="2" style="text-align: center">{{$voto_candidato->votos}}</td>
                            @endforeach
                        </tr>
                    @endforeach

            @endforeach

      
        </thead>
        <tbody>
          
        
        </tbody>

    </table>
</body>
</html>
