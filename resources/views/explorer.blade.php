@extends('layouts.base')

@section('title','Legisla Brasil - Home')
@section('content')
    <section id="topo_interna">

        <div class="central-topo">
            <h1 class="{{!empty($filterActive)?'title-filter-page':''}}">
                {!!$title!!}
            </h1>
        </div>
    </section><!-- topo -->
    <!-- <br clear="all"> -->

    <section id="explorador-pages">

    @include('layouts.explorerPanel')
    </section>

    <!-- <br clear="all"> -->

    <section id="dados">
        <div class="central">

            <div class="box_top_title">
                <h3><strong>{{$title}}</strong></h3>

                <br clear="all">
                @if(@isset($sort))
                <p>RESULTADO EM ORDEM DE PONTUAÇÃO</p>
                @else
                <p>RESULTADO EM ORDEM ALFABÉTICA</p>
                @endif
            </div>

            <div class="box_top_select">

                @include('layouts.site_components.more-info')
               
                <form>
                @if(@!isset($sort))
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none">
                        <path d="M12 0.360107H0L6 7.36011L12 0.360107Z" fill="white"/>
                    </svg>
                    <select id="UF"
                            name="UF"
                            data-params="{{$uri??''}}"
                            class="{{ !empty($filterActive)?'filterSelectState':'explorerSelectState'}}">
                        <option value="">{{empty($selectedState)?'Alterar Estado':'Brasil'}}</option>
                        @foreach($states as $state)
                            <option value="{{$state->acronym}}"
                                {{(!empty($selectedState) && $selectedState === $state->acronym?'selected':'' )}}>
                                {{$state->name}}
                            </option>
                        @endforeach
                    </select>
                @elseif($sort == 'state')
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none">
                        <path d="M12 0.360107H0L6 7.36011L12 0.360107Z" fill="white"/>
                    </svg>
                    <select id="topnUF"
                            name="topnUF"
                            data-params="{{$uri??''}}"
                            class="{{ !empty($filterActive)?'filterSelectState':'explorerTopState'}}">
                        @foreach($states as $state)
                            <option value="{{$state->acronym}}"
                                {{(!empty($selectedState) && $selectedState === $state->acronym?'selected':'' )}}>
                                {{$state->name}}
                            </option>
                        @endforeach
                    </select>
                @elseif($sort == 'party')
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none">
                        <path d="M12 0.360107H0L6 7.36011L12 0.360107Z" fill="white"/>
                    </svg>
                    <select id="topnparty"
                            name="topnparty"
                            data-params="{{$uri??''}}"
                            class="{{ !empty($filterActive)?'filterSelectState':'explorerTopParty'}}">
                        @foreach($partiesNotEmpty as $party)
                            <option value="{{$party->acronym}}"
                                {{(!empty($selectedParty) && $selectedParty === $party->acronym?'selected':'' )}}>
                                {{$party->acronym}}
                            </option>
                        @endforeach
                    </select>

                @elseif($sort == 'axis')
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none">
                        <path d="M12 0.360107H0L6 7.36011L12 0.360107Z" fill="white"/>
                    </svg>
                    <select id="topnaxis"
                            name="topnaxis"
                            data-params="{{$uri??''}}"
                            class="{{ !empty($filterActive)?'filterSelectState':'explorerTopAxis'}}">
                        @foreach($axes  as $slug => $name)
                            <option value="{{$slug}}"
                                {{(!empty($selectedAxis) && $selectedAxis === $slug?'selected':'' )}}>
                                {{$name}}
                            </option>
                        @endforeach
                    </select>


                @endif                    
                    <!-- <select id="classificacao"
                            name="classificacao"
                            class="{{!empty($filterActive)?'filterSelectRate':'explorerSelectRate'}}">
                        <option value="">{{empty($stars)?'Alterar Classificação':'Limpar Classificação'}}</option>
                        <option value="cinco-estrelas" {{!empty($stars) && $stars === 5 ?'selected':''}}>5 estrelas
                        </option>
                        <option value="quatro-estrelas" {{!empty($stars) && $stars === 4 ?'selected':''}}>4 estrelas
                        </option>
                        <option value="tres-estrelas" {{!empty($stars) && $stars === 3 ?'selected':''}}>3 estrelas
                        </option>
                        <option value="duas-estrelas" {{!empty($stars) && $stars === 2 ?'selected':''}}>2 estrelas
                        </option>
                        <option value="uma-estrela" {{!empty($stars) && $stars === 1 ?'selected':''}}>1 estrela</option>
                    </select> -->
                </form>
                

            </div>

            <!-- MODAL EXPLICATIVO -->
            <div id="myModal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true"
                 role="dialog">

                <div class="col_12">

                    <p>
                        A pontuação final dos parlamentares é obtida pela média em todos os indicadores. Dessa forma, as
                        estrelas são dadas a partir da faixa em que a nota do parlamentar se encontra. A classificação
                        varia de uma estrela (nota 0 a 4) a cinco estrelas (notas iguais ou maiores que 7,5). Para mais
                        detalhes, consulte a página Metodologia.
                    </p>

                </div>

                <a class="close-reveal-modal" aria-label="Close">&#215;</a>
            </div><!-- MODAL EXPLICATIVO -->

            <!-- <br clear="all"> -->

            <div class="lista_resultados">

                @if($congresspeople->isEmpty())
                    <div class="text-center">
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <p>Nenhum parlamentar encontrado</p>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    </div>
                @endif
                <!-- LISTA REPETIÇÃO -->
                @foreach( $congresspeople as $congressperson )

                    <div class="box_dep"> <!-- col_2 box_dep -->
                        <a href="{{route('deputado',['id'=>$congressperson->external_id])}}"
                           title="Nome do Deputado">
                            <img src="{{$congressperson->uri_photo}}" style="max-height: 152px" alt="">
                        </a>

                        <strong>{{$congressperson->name}}</strong>
                        <p>
                            {{$congressperson->state_acronym}}<br>
                            {{$congressperson->party_acronym ?? "Sem partido"}}<br>
                        </p>

                        <div class="ranking">
                        @if($congressperson->stars == 5)
                            <i class="fa fa-star font_ativo"></i>
                            <i class="fa fa-star font_ativo"></i>
                            <i class="fa fa-star font_ativo"></i>
                            <i class="fa fa-star font_ativo"></i>
                            <i class="fa fa-star font_ativo"></i>
                        @endif
                        </div>

                    </div>
                    <!-- col_2 box_dep -->

                @endforeach

            </div>

        </div>
    </section><!-- dados -->
    <!-- <br clear="all"> -->
@endsection
