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
                @php
                    $total_votos_candidato_1 = 0;
                    $total_votos_candidato_2 = 0;
                    $total_votos_candidato_3 = 0;
                    $total_votos_candidato_4 = 0;
                    $total_votos_candidato_5 = 0;
                    $total_votos_candidato_6 = 0;
                    $total_votos_candidato_7 = 0;
                    $total_votos_candidato_8 = 0;
                    $total_votos_candidato_9 = 0;
                @endphp

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

                @php
                    $total_votantes_recinto = 0;
                    $total_blancos_recinto = 0;
                    $total_nulos_recinto = 0;
                    $total_votos_candidatos_recinto = 0;
                    $total_bnc_recinto = 0;
                @endphp

                @foreach ($actas_agrupados_recinto as $key=>$acta)
                    
                    @php
                        $total_votantes_recinto +=  $acta->total_votantes;
                        $total_blancos_recinto +=  $acta->votos_blancos;
                        $total_nulos_recinto +=  $acta->votos_nulos;
                        $total_votos_candidatos_recinto +=  $acta->totalVotosCandidatos;
                        $total_bnc_recinto +=  $acta->totalBNC;
                    @endphp

    
                  
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


                            @if ($voto_candidato->candidato_id == 1)
                                @php
                                    $total_votos_candidato_1 +=  $voto_candidato->votos;
                                @endphp

                            @elseif( $voto_candidato->candidato_id == 2 )
                                @php
                                    $total_votos_candidato_2 +=  $voto_candidato->votos;
                                @endphp
                            
                            @elseif( $voto_candidato->candidato_id == 3 )
                                @php
                                    $total_votos_candidato_3 +=  $voto_candidato->votos;
                                @endphp
                            
                            @elseif( $voto_candidato->candidato_id == 4 )
                                @php
                                    $total_votos_candidato_4 +=  $voto_candidato->votos;
                                @endphp
                              
                            @elseif( $voto_candidato->candidato_id == 5 )
                              @php
                                  $total_votos_candidato_5 +=  $voto_candidato->votos;
                              @endphp
                               
                            @elseif( $voto_candidato->candidato_id == 6 )
                               @php
                                   $total_votos_candidato_6 +=  $voto_candidato->votos;
                               @endphp
                            
                            @elseif( $voto_candidato->candidato_id == 7 )
                                @php
                                    $total_votos_candidato_7 +=  $voto_candidato->votos;
                                @endphp
                                 
                            @elseif( $voto_candidato->candidato_id == 8 )
                                @php
                                    $total_votos_candidato_8 +=  $voto_candidato->votos;
                                @endphp

                                       
                            @elseif( $voto_candidato->candidato_id == 9 )
                                @php
                                    $total_votos_candidato_9 +=  $voto_candidato->votos;
                                @endphp
                            @endif
                                

                            <td colspan="2" style="text-align: center">{{$voto_candidato->votos}}</td>
                        @endforeach
                    </tr>
                @endforeach


              

                <tr>
                    <td colspan="6" style="text-align: center; font-weight: bold;">TOTAL</td>
                    <td colspan="2"  style="text-align: center;">{{$total_votantes_recinto}}</td>
                    <td colspan="2"  style="text-align: center;">{{$total_blancos_recinto}}</td>
                    <td colspan="2"  style="text-align: center;">{{$total_nulos_recinto}}</td>
                     <td colspan="2"  style="text-align: center;">{{$total_votos_candidatos_recinto}}</td>
                    <td colspan="2"  style="text-align: center;">{{$total_bnc_recinto}}</td>
                    <td colspan="2" style="text-align: center">{{$total_votos_candidato_1}}</td>
                    <td colspan="2" style="text-align: center">{{$total_votos_candidato_2}}</td>
                    <td colspan="2" style="text-align: center">{{$total_votos_candidato_3}}</td>
                    <td colspan="2" style="text-align: center">{{$total_votos_candidato_4}}</td>
                    <td colspan="2" style="text-align: center">{{$total_votos_candidato_5}}</td>
                    <td colspan="2" style="text-align: center">{{$total_votos_candidato_6}}</td>
                    <td colspan="2" style="text-align: center">{{$total_votos_candidato_7}}</td>
                    <td colspan="2" style="text-align: center">{{$total_votos_candidato_8}}</td>
                    <td colspan="2" style="text-align: center;  background-color: #B2DFDB">{{$total_votos_candidato_9}}</td>
                 
                </tr>


            @endforeach

      
        </thead>
        <tbody>
          
        
        </tbody>

    </table>
</body>
</html>
