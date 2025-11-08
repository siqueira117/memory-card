# 🎮 MemoryCard - Preservação de Jogos Clássicos

<p align="center">
  <img src="public/img/logo_green.png" alt="MemoryCard Logo" width="300">
</p>

<p align="center">
  <strong>Para gamers de coração</strong><br>
  Preservando a história dos jogos, um título por vez
</p>

---

## 📖 Sobre o Projeto

O **MemoryCard** é uma plataforma dedicada à preservação de jogos antigos e descontinuados, além de ROMs criadas pela comunidade. Nossa missão é garantir que os clássicos dos videogames não sejam perdidos no tempo, mantendo-os acessíveis para futuras gerações de jogadores.

### 🎯 Objetivos

- 🕹️ Preservar jogos descontinuados e raros
- 📚 Criar uma biblioteca completa com informações detalhadas
- 🤝 Apoiar desenvolvedores independentes
- 🌍 Manter viva a cultura dos videogames

---

## ✨ Funcionalidades

### 🎮 Para Usuários
- ✅ **Busca e Filtros Avançados** - Encontre jogos por nome, gênero, plataforma e data de lançamento
- ✅ **Sistema de Status** - Organize seus jogos em: Played, Playing, Backlog e Wishlist
- ✅ **Reviews e Avaliações** - Compartilhe sua opinião sobre os jogos
- ✅ **Perfil Personalizado** - Acompanhe suas estatísticas e coleção
- ✅ **Downloads de ROMs** - Acesso a jogos organizados por plataforma
- ✅ **Manuais dos Jogos** - Download de manuais originais quando disponíveis
- ✅ **Sistema de Notificações** - Fique por dentro das novidades
- ✅ **Sugestões** - Sugira jogos para serem adicionados

### 🛠️ Para Administradores
- ✅ **Adicionar Jogos** - Integração com IGDB API
- ✅ **Upload de Manuais** - Adicione manuais em múltiplos idiomas
- ✅ **Gerenciamento de Conteúdo** - Controle total sobre a biblioteca

---

## 🚀 Tecnologias Utilizadas

### Backend
- **Laravel 12** - Framework PHP
- **Livewire 3** - Componentes reativos
- **MySQL** - Banco de dados

### Frontend
- **TailwindCSS 4** - Framework CSS
- **Bootstrap 5** - Componentes UI
- **Font Awesome** - Ícones
- **Swiper.js** - Carousels

### APIs & Integrações
- **IGDB API** - Dados de jogos (marcreichel/igdb-laravel)

---

## 📦 Instalação

### Pré-requisitos
- PHP 8.2 ou superior
- Composer
- Node.js e NPM
- MySQL

### Passo a Passo

1. **Clone o repositório**
```bash
git clone https://github.com/seu-usuario/memory-card.git
cd memory-card
```

2. **Instale as dependências PHP**
```bash
composer install
```

3. **Instale as dependências JavaScript**
```bash
npm install
```

4. **Configure o ambiente**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure o banco de dados no `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=memorycard
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

6. **Configure a API do IGDB no `.env`**
```env
IGDB_CLIENT_ID=seu_client_id
IGDB_CLIENT_SECRET=seu_client_secret
```

7. **Execute as migrations e seeders**
```bash
php artisan migrate --seed
```

8. **Inicie o servidor de desenvolvimento**
```bash
composer run dev
```

Ou execute separadamente:
```bash
php artisan serve
npm run dev
```

O projeto estará disponível em `http://localhost:8000`

---

## 🎨 Melhorias Visuais Implementadas

### Design Moderno
- ✨ **Gradientes e Sombras** - Visual mais sofisticado
- 🎭 **Animações Suaves** - Transições e efeitos modernos
- 📱 **Responsivo** - Otimizado para todos os dispositivos
- 🎯 **Skeleton Loaders** - Feedback visual durante carregamentos
- 🌈 **Badges Animados** - Destaque para jogos novos
- 💫 **Efeitos Hover** - Interações visuais aprimoradas

### Componentes
- 🎴 **Cards Aprimorados** - Design mais atraente com efeitos 3D
- 🔘 **Botões Modernos** - Gradientes e animações
- 📝 **Inputs Estilizados** - Melhor UX em formulários
- 🖼️ **Página 404 Criativa** - Erro com estilo gamer

---

## 📂 Estrutura do Projeto

```
memory-card/
├── app/
│   ├── Http/Controllers/     # Controladores
│   ├── Livewire/             # Componentes Livewire
│   ├── Models/               # Models Eloquent
│   └── View/Components/      # Blade Components
├── database/
│   ├── migrations/           # Migrações do banco
│   └── seeders/              # Seeders
├── public/
│   ├── css/                  # Estilos customizados
│   └── img/                  # Imagens e logos
├── resources/
│   ├── views/                # Views Blade
│   │   ├── components/       # Componentes Blade
│   │   ├── livewire/         # Views Livewire
│   │   └── errors/           # Páginas de erro
│   └── css/                  # CSS fonte
└── routes/
    └── web.php               # Rotas da aplicação
```

---

## 🎯 Funcionalidades em Desenvolvimento

- [ ] Sistema de coleções personalizadas
- [ ] Integração com mais APIs de jogos
- [ ] Sistema de conquistas
- [ ] Comparação de bibliotecas entre usuários
- [ ] Modo escuro (dark mode toggle)
- [ ] Export/Import de listas

---

## 📝 Changelog

### v1.6.0 - Atual
- ✨ Interface visual completamente reformulada
- ✨ Página de perfil do usuário
- ✨ Skeleton loaders para melhor UX
- ✨ Página 404 personalizada
- 🎨 Novos gradientes e animações
- 🎨 Cards com efeitos modernos
- 📱 Melhorias na responsividade

### v1.5.1 - 20/03/2025
- ✨ Carousel de jogos relacionados

### v1.5.0 - 20/03/2025
- ✨ Sistema de status para jogos
- ✨ Adição de empresas envolvidas

### v1.4.0 - 18/03/2025
- ✨ Sistema de notificações
- ⚡ Otimização de performance

### v1.3.0 - 15/03/2025
- ✨ Visualização de screenshots e artworks
- ✨ Download de manuais

### v1.2.0 - 12/03/2025
- ✨ Sistema de reviews

### v1.1.0 - 05/03/2025
- ✨ Sistema de filtros

### v1.0.0 - 28/02/2025
- 🎉 Lançamento oficial

---

## 🤝 Como Contribuir

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/MinhaFeature`)
3. Commit suas mudanças (`git commit -m 'Adiciona MinhaFeature'`)
4. Push para a branch (`git push origin feature/MinhaFeature`)
5. Abra um Pull Request

---

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

---

## 🙏 Agradecimentos

- **IGDB** - Por fornecer os dados dos jogos
- **Comunidade Laravel** - Pelo framework incrível
- **Comunidade Gaming** - Por manter viva a preservação de jogos

---

## 📧 Contato

Para sugestões, dúvidas ou contribuições, utilize a página de [Sugestões](./sugestoes) ou abra uma issue no GitHub.

---

<p align="center">
  <strong>❤️ Feito por gamers, para gamers ❤️</strong>
</p>

<p align="center">
  Powered by <a href="https://www.igdb.com/">IGDB</a>
</p>
