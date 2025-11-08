@extends('layout')

@section('content')
<div class="container">
    <div class="error-page-container">
        <div class="error-content text-center">
            <!-- Animated 404 -->
            <div class="error-number">
                <span class="glitch" data-text="404">404</span>
            </div>
            
            <!-- Icon -->
            <div class="error-icon mb-4">
                <i class="fas fa-ghost fa-5x"></i>
            </div>
            
            <!-- Message -->
            <h2 class="error-title mb-3">Oops! Página não encontrada</h2>
            <p class="error-description mb-4">
                Parece que esta página foi zerada... Assim como aquele save que você esqueceu de salvar!
            </p>
            
            <!-- Actions -->
            <div class="error-actions">
                <a href="{{ route('index') }}" class="btn btn-custom me-2">
                    <i class="fas fa-home me-2"></i>Voltar para Home
                </a>
                <button onclick="history.back()" class="btn btn-custom-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Página Anterior
                </button>
            </div>
            
            <!-- Fun Fact -->
            <div class="fun-fact mt-5">
                <p class="text-secondary">
                    <i class="fas fa-lightbulb me-2"></i>
                    <strong>Dica de Gamer:</strong> Quando encontrar um erro 404, lembre-se de salvar seu progresso frequentemente!
                </p>
            </div>
        </div>
    </div>
</div>

<style>
.error-page-container {
    min-height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 0;
}

.error-number {
    font-size: 8rem;
    font-weight: 900;
    line-height: 1;
    margin-bottom: 2rem;
    position: relative;
}

.glitch {
    color: var(--btn-color);
    position: relative;
    display: inline-block;
    animation: glitch-skew 1s infinite;
}

.glitch::before,
.glitch::after {
    content: attr(data-text);
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.glitch::before {
    left: 2px;
    text-shadow: -2px 0 #ff00ff;
    clip: rect(44px, 450px, 56px, 0);
    animation: glitch-anim 5s infinite linear alternate-reverse;
}

.glitch::after {
    left: -2px;
    text-shadow: -2px 0 #00ffff, 2px 2px #ff00ff;
    animation: glitch-anim2 1s infinite linear alternate-reverse;
}

@keyframes glitch-anim {
    0% {
        clip: rect(31px, 9999px, 94px, 0);
        transform: skew(0.85deg);
    }
    5% {
        clip: rect(70px, 9999px, 71px, 0);
        transform: skew(0.03deg);
    }
    10% {
        clip: rect(78px, 9999px, 26px, 0);
        transform: skew(0.56deg);
    }
    100% {
        clip: rect(65px, 9999px, 79px, 0);
        transform: skew(0.21deg);
    }
}

@keyframes glitch-anim2 {
    0% {
        clip: rect(65px, 9999px, 119px, 0);
        transform: skew(0.41deg);
    }
    5% {
        clip: rect(79px, 9999px, 19px, 0);
        transform: skew(0.98deg);
    }
    10% {
        clip: rect(65px, 9999px, 85px, 0);
        transform: skew(0.78deg);
    }
    100% {
        clip: rect(14px, 9999px, 89px, 0);
        transform: skew(0.67deg);
    }
}

@keyframes glitch-skew {
    0% {
        transform: skew(0deg);
    }
    10% {
        transform: skew(-1deg);
    }
    20% {
        transform: skew(1deg);
    }
    30% {
        transform: skew(0deg);
    }
    100% {
        transform: skew(0deg);
    }
}

.error-icon i {
    color: var(--text-secondary);
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-20px);
    }
}

.error-title {
    color: var(--text-primary);
    font-size: 2rem;
    font-weight: 700;
}

.error-description {
    color: var(--text-secondary);
    font-size: 1.1rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.error-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.fun-fact {
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    padding: 1.5rem;
    background: var(--card-gradient);
    border-radius: 12px;
    border: 1px solid var(--border-color);
}

@media (max-width: 768px) {
    .error-number {
        font-size: 5rem;
    }
    
    .error-title {
        font-size: 1.5rem;
    }
    
    .error-actions {
        flex-direction: column;
        align-items: stretch;
    }
    
    .error-actions .btn {
        width: 100%;
        margin: 0 0 0.5rem 0 !important;
    }
}
</style>
@endsection

