@extends('layout')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/faqs.css') }}">
@endsection

@section('content')
<div class="container mt-5 w-80 rounded-1 bg-dark-custom p-5">
    <h2 class="fw-bold text-center mb-4 title">Perguntas Frequentes (FAQs)</h2>
    <p class="text-center mb-5 subtitle">Aqui estão as respostas para as perguntas mais comuns sobre o MemoryCard.</p>

    <div class="accordion" id="faqAccordion">

        <!-- Pergunta 1 -->
        <div class="accordion-item container-item-faq">
            <h2 class="accordion-header" id="faq1">
                <button class="accordion-button btn-faq" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1">
                    O que é o MemoryCard?
                </button>
            </h2>
            <div id="faqCollapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    O MemoryCard é um site dedicado à preservação de jogos antigos e descontinuados, além de ROMs criadas pela comunidade.
                </div>
            </div>
        </div>

        {{-- <!-- Pergunta 2 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="faq2">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2">
                    Os downloads são legais?
                </button>
            </h2>
            <div id="faqCollapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Nosso foco é preservar jogos que não são mais vendidos ou disponibilizados oficialmente. Apenas ROMs de domínio público ou com permissão dos criadores são hospedadas.
                </div>
            </div>
        </div> --}}

        <!-- Pergunta 3 -->
        <div class="accordion-item container-item-faq">
            <h2 class="accordion-header" id="faq3">
                <button class="accordion-button btn-faq collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3">
                    Como posso sugerir um jogo para ser adicionado?
                </button>
            </h2>
            <div id="faqCollapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Você pode sugerir um jogo através da nossa página de <a href="{{ route('suggestion.index') }}">Sugestões e Pedidos</a>. Estamos sempre abertos a novas adições!
                </div>
            </div>
        </div>

        <!-- Pergunta 4 -->
        <div class="accordion-item container-item-faq">
            <h2 class="accordion-header" id="faq4">
                <button class="accordion-button btn-faq collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse4">
                    Posso contribuir com ROMs criadas pela comunidade?
                </button>
            </h2>
            <div id="faqCollapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Sim! Se você desenvolveu uma ROM e deseja compartilhá-la, entre em contato conosco através da nossa página de sugestões.
                </div>
            </div>
        </div>

        <!-- Pergunta 5 -->
        <div class="accordion-item container-item-faq">
            <h2 class="accordion-header" id="faq5">
                <button class="accordion-button btn-faq collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse5">
                    Preciso criar uma conta para baixar ROMs?
                </button>
            </h2>
            <div id="faqCollapse5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Não! Todos os downloads estão disponíveis gratuitamente sem a necessidade de cadastro.
                </div>
            </div>
        </div>

        <!-- Pergunta 6 -->
        <div class="accordion-item container-item-faq">
            <h2 class="accordion-header" id="faq6">
                <button class="accordion-button btn-faq collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse6">
                    Como os jogos são escolhidos para serem adicionados?
                </button>
            </h2>
            <div id="faqCollapse6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Os jogos são escolhidos com base no seu status de descontinuidade e na demanda da comunidade. Damos prioridade a títulos que não podem mais ser adquiridos legalmente.
                </div>
            </div>
        </div>

        <!-- Pergunta 7 -->
        <div class="accordion-item container-item-faq">
            <h2 class="accordion-header" id="faq7">
                <button class="accordion-button btn-faq collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse7">
                    Os jogos são testados antes de serem adicionados?
                </button>
            </h2>
            <div id="faqCollapse7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Sim! Antes de disponibilizarmos uma ROM, testamos sua compatibilidade com emuladores populares para garantir que funciona corretamente.
                </div>
            </div>
        </div>

        <!-- Pergunta 8 -->
        <div class="accordion-item container-item-faq">
            <h2 class="accordion-header" id="faq8">
                <button class="accordion-button btn-faq collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse8">
                    Posso baixar jogos diretamente para meu console?
                </button>
            </h2>
            <div id="faqCollapse8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Alguns consoles permitem rodar ROMs via cartões SD ou dispositivos de flash, mas recomendamos verificar a compatibilidade do seu console antes de tentar rodar qualquer jogo.
                </div>
            </div>
        </div>

        <!-- Pergunta 9 -->
        <div class="accordion-item container-item-faq">
            <h2 class="accordion-header" id="faq9">
                <button class="accordion-button btn-faq collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse9">
                    Como posso ajudar na preservação dos jogos?
                </button>
            </h2>
            <div id="faqCollapse9" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Você pode ajudar de várias formas, como compartilhando ROMs feitas pela comunidade, enviando sugestões de jogos raros ou ajudando na documentação de títulos esquecidos.
                </div>
            </div>
        </div>

        <!-- Pergunta 10 -->
        <div class="accordion-item container-item-faq">
            <h2 class="accordion-header" id="faq10">
                <button class="accordion-button btn-faq collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse10">
                    O MemoryCard aceita doações?
                </button>
            </h2>
            <div id="faqCollapse10" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    No momento, não aceitamos doações financeiras. No entanto, você pode contribuir sugerindo jogos, enviando ROMs ou ajudando a divulgar o projeto!
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
