# Mudare Engenharia - Website

Site institucional da Mudare Engenharia com design clean e moderno.

## 🎨 Estrutura do Projeto

```
mudare/
├── index.html          # Página inicial
├── sobre.html          # Sobre a empresa
├── servicos.html       # Serviços oferecidos
├── portfolio.html      # Portfólio com carrossel de obras
├── contato.html        # Página de contato
├── css/
│   └── style.css       # Estilos principais
├── js/
│   └── main.js         # JavaScript (carrossel, menu mobile, etc)
└── images/
    └── portfolio/      # Imagens das obras (obra1.jpg a obra6.jpg)
```

## 📋 Funcionalidades

- ✅ Design clean e moderno
- ✅ Totalmente responsivo (mobile, tablet, desktop)
- ✅ Carrossel de obras no portfólio com:
  - Navegação por botões
  - Indicadores
  - Auto-play
  - Suporte a swipe em dispositivos móveis
- ✅ Menu hamburger para mobile
- ✅ Formulário de contato validado
- ✅ Animações suaves ao scroll
- ✅ SEO otimizado

## 🖼️ Como Adicionar Imagens ao Portfólio

1. Adicione suas fotos de obras na pasta `images/portfolio/`
2. Nomeie os arquivos como: `obra1.jpg`, `obra2.jpg`, `obra3.jpg`, etc.
3. Tamanho recomendado: 1200x800px (proporção 3:2)
4. Formato: JPG ou PNG
5. Otimize as imagens para web (máximo 500KB por imagem)

### Para adicionar mais slides ao carrossel:

Edite o arquivo `portfolio.html` e adicione novos blocos dentro de `.carousel-container`:

```html
<div class="carousel-item">
    <img src="images/portfolio/obra7.jpg" alt="Descrição da Obra">
    <div class="carousel-caption">
        <h3>Título da Obra</h3>
        <p>Descrição detalhada do projeto executado.</p>
    </div>
</div>
```

## ✏️ Personalizações Importantes

### 1. Informações de Contato

Edite em TODAS as páginas (rodapé e página de contato):

- Email: `contato@mudare.eng.br`
- Telefone: `(XX) XXXX-XXXX`
- Endereço completo
- Redes sociais (links no rodapé)

### 2. Cores do Site

Para alterar as cores, edite as variáveis no arquivo `css/style.css`:

```css
:root {
    --primary-color: #2c3e50;      /* Cor principal */
    --secondary-color: #3498db;    /* Cor secundária */
    --accent-color: #e74c3c;       /* Cor de destaque */
}
```

### 3. Logo

Substitua o texto "Mudare." por uma imagem de logo editando em todas as páginas:

```html
<!-- De: -->
<a href="index.html" class="logo">Mudare<span>.</span></a>

<!-- Para: -->
<a href="index.html" class="logo">
    <img src="images/logo.png" alt="Mudare Engenharia" style="height: 40px;">
</a>
```

### 4. Google Maps

Na página `contato.html`, substitua o placeholder do mapa:

1. Acesse [Google Maps](https://www.google.com/maps)
2. Encontre seu endereço
3. Clique em "Compartilhar" → "Incorporar um mapa"
4. Copie o código iframe
5. Substitua a div placeholder pelo iframe

### 5. Formulário de Contato

O formulário atualmente mostra apenas um alerta. Para funcionar de verdade, você pode:

**Opção 1 - Formspree (gratuito):**
```html
<form class="contact-form" action="https://formspree.io/f/SEU_ID" method="POST">
```

**Opção 2 - EmailJS (gratuito):**
Adicione o script do EmailJS no `main.js`

**Opção 3 - Backend próprio:**
Configure um servidor PHP/Node.js para processar o formulário

## 🚀 Como Publicar o Site

### GitHub Pages (Gratuito):

1. Faça commit das alterações
2. Push para o repositório
3. Vá em Settings → Pages
4. Selecione a branch main
5. Seu site estará em: `https://seu-usuario.github.io/mudare/`

### Hospedagem Tradicional:

1. Faça upload de todos os arquivos via FTP
2. Certifique-se de que o `index.html` está na raiz
3. Configure o domínio `www.mudare.eng.br` no seu provedor

## 📱 Responsividade

O site é totalmente responsivo e funciona perfeitamente em:
- 📱 Smartphones (320px+)
- 📱 Tablets (768px+)
- 💻 Desktops (1024px+)
- 🖥️ Telas grandes (1920px+)

## 🎯 SEO

Cada página possui:
- Meta description
- Meta keywords
- Título otimizado
- Estrutura semântica HTML5
- Alt text em imagens

## 📞 Suporte

Para dúvidas ou ajustes, entre em contato através do email cadastrado.

---

**Desenvolvido para Mudare Engenharia** - Design clean e profissional
