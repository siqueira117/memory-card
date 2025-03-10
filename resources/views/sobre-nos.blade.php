@extends('layout')

@section('content')
<div class="container mt-5 w-80 rounded-1 bg-dark-custom p-5">
    <div class="row">
        <!-- Imagem Ilustrativa -->
        {{-- <div class="col-md-6 d-flex align-items-center">
            <img src="{{ asset('images/about-us.jpg') }}" class="img-fluid rounded shadow" alt="Sobre o MemoryCard">
        </div> --}}

        <!-- Texto Sobre Nós -->
        <div class="col-md-12">
            <h2 class="fw-bold text-center title">Sobre o MemoryCard</h2>
            <p class="subtitle">Preservando a história dos jogos, um título por vez.</p>
            <p class="text-left">
                O <strong>MemoryCard</strong> nasceu da paixão pelos videogames e da preocupação com o desaparecimento de títulos icônicos da história dos jogos.  
                Com o passar dos anos, muitos jogos foram descontinuados, deixaram de ser comercializados e nunca receberam versões atualizadas  
                para novas plataformas. Isso faz com que grandes clássicos e até mesmo títulos menos conhecidos corram o risco de serem perdidos  
                para sempre.  
            </p>
            <p class="text-left">
                Nosso objetivo é reunir e disponibilizar <strong>ROMs de jogos descontinuados e criações independentes da comunidade</strong>, garantindo que essas  
                experiências não se tornem inacessíveis para futuras gerações.  
            </p>
        </div>
    </div>

    <hr class="my-5">

    <!-- Nossa Missão -->
    <div class="row">
        <div class="col-md-12">
            <h2 class="fw-bold text-center title">Nossa Missão</h2>
            <p class="subtitle">Manter viva a memória dos jogos esquecidos e independentes.</p>
            <p class="text-left">
                O mundo dos videogames evolui rapidamente, e enquanto novos lançamentos chegam ao mercado, muitos jogos antigos são deixados para trás.  
                Sem esforços de preservação, esses títulos podem desaparecer completamente, tornando-se inacessíveis para jogadores e pesquisadores  
                que desejam explorar a história dos games.  
            </p>
            <p class="text-left">
                O <strong>MemoryCard</strong> tem como missão <strong>resgatar, preservar e compartilhar jogos que foram descontinuados</strong>, garantindo que essa parte importante  
                da cultura digital não seja perdida. Nossa plataforma permite que os jogadores tenham acesso a títulos clássicos que moldaram a indústria  
                e que ainda possuem valor histórico e emocional para muitos.  
            </p>
            <p class="text-left">
                Além disso, apoiamos a <strong>comunidade de desenvolvedores independentes</strong>, que muitas vezes não encontram espaço para divulgar seus trabalhos.  
                No MemoryCard, oferecemos visibilidade para novos projetos que respeitam a essência dos games clássicos, dando oportunidade para que  
                jogadores descubram e apreciem essas criações.  
            </p>
        </div>
    </div>

    <hr class="my-5">

    <!-- Preservação e Cultura -->
    <div class="row">
        <div class="col-md-12">
            <h2 class="fw-bold text-center title">A Importância da Preservação</h2>
            <p class="subtitle">Resgatando jogos que marcaram gerações.</p>
            <p class="text-left">
                Os videogames fazem parte da cultura global e são uma forma de arte interativa que impactou milhões de pessoas ao longo das décadas.  
                No entanto, diferentemente de outras mídias como filmes e livros, muitos jogos correm o risco de serem esquecidos para sempre devido  
                à falta de preservação.  
            </p>
            <p class="text-left">
                Com o avanço da tecnologia, hardwares antigos se tornam obsoletos e muitas empresas deixam de oferecer suporte para seus títulos mais velhos.  
                Isso significa que muitos jogos deixam de estar disponíveis, restando apenas cópias físicas que podem ser raras ou inacessíveis.  
            </p>
            <p class="text-left">
                O MemoryCard busca preservar essa parte da história digital, garantindo que jogos que marcaram gerações possam ser redescobertos,  
                estudados e apreciados por jogadores de todas as idades.  
            </p>
        </div>

        <!-- Imagem Ilustrativa -->
        {{-- <div class="col-md-6 d-flex align-items-center">
            <img src="{{ asset('images/preservation.jpg') }}" class="img-fluid rounded shadow" alt="Preservação de jogos">
        </div> --}}
    </div>
</div>
@endsection