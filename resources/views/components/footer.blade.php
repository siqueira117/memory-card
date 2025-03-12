<footer class="bg-dark-custom text-light py-4 mt-5">
    <div class="container">
        <div class="row">
            <!-- Logo e Sobre -->
            <div class="col-md-12 text-center">
                {{-- <h5>memorycard</h5> --}}
                <p><i class="fa-solid fa-heart heartIcon"></i> Feito por gamers, para gamers <i class="fa-solid fa-heart heartIcon"></i></p>
            </div>

            <!-- Links Úteis -->
            <div class="col-md-12 text-center">
                <p class="text-center">
                    <a href="{{ route('index') }}" class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Inicio</a>
                    |
                    <a href="{{ route('suggestion.index') }}" class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Sugestões</a>
                    |
                    <a href="{{ route('faqs.index') }}" class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">FAQs</a>
                    |
                    <a href="{{ route('about.us') }}" class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Sobre</a>
                </p>
            </div>
        </div>

        <!-- Copyright -->
        <div class="text-center mt-3">
            <p class="mb-0">&copy; {{ date('Y') }} memorycard - powered by <a class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="https://www.igdb.com/"><strong>IGDB</strong></a></p>
        </div>
    </div>
</footer>