<footer class="bg-dark text-light py-4 mt-5">
    <div class="container">
        <div class="row">
            <!-- Logo e Sobre -->
            <div class="col-md-4">
                <h5>memorycard</h5>
                <p>Seu portal para baixar os melhores jogos de todas as plataformas.</p>
            </div>

            <!-- Links Úteis -->
            <div class="col-md-4">
                <h5>Links Úteis</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/') }}" class="text-light text-decoration-none">Início</a></li>
                    <li><a href="{{ url('/sobre') }}" class="text-light text-decoration-none">Sobre</a></li>
                    <li><a href="{{ url('/contato') }}" class="text-light text-decoration-none">Sugestões</a></li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="text-center mt-3">
            <p class="mb-0">&copy; {{ date('Y') }} memorycard. Todos os direitos reservados.</p>
        </div>
    </div>
</footer>