# Espaço Máxima — Site em HTML

Versão estática em HTML/CSS/JS do site **Espaço Máxima — Estética, Pilates e Salão de Beleza**
(Alto da Lapa, São Paulo), reconstruída a partir do conteúdo do site original em WordPress
(espacomaxima.com.br).

## 📁 Estrutura

```
mudare/
├── index.html              # Home
├── quem-somos.html         # Quem Somos
├── servicos.html           # Visão geral dos serviços
├── salao-de-beleza.html    # Salão de Beleza
├── estetica-corporal.html  # Estética Corporal
├── estetica-facial.html    # Estética Facial
├── massagens-spa.html      # Massagens e Spa
├── pilates.html            # Pilates
├── galeria.html            # Galeria
├── blog.html               # Blog (posts reais do site)
├── contato.html            # Contato + mapa + formulário
├── css/style.css           # Design system (rosé, dourado e mauve)
└── js/main.js              # Menu mobile, animações e formulário → WhatsApp
```

## 🎨 Identidade

- **Cores:** rosé (`#b76e79`), mauve (`#5c3a4d`), dourado (`#c9a86a`), creme (`#faf5f2`)
- **Fontes:** Playfair Display (títulos) + Poppins (texto) — via Google Fonts
- **Estilo:** elegante e feminino, adequado a estética/spa/beleza

## 📍 Dados do negócio

- **Endereço:** R. Pio XI, 656 — Alto da Lapa, São Paulo/SP
- **WhatsApp/Telefone:** (11) 95021-8191
- **Instagram:** @espacomaxima

## ✅ Funcionalidades

- Totalmente responsivo (mobile, tablet, desktop)
- Menu hamburger e dropdown de serviços
- Botão flutuante de WhatsApp em todas as páginas
- Formulário de contato que abre o WhatsApp com a mensagem pronta
- Animações suaves ao rolar a página
- Mapa do Google incorporado na página de Contato

## 🖼️ Como adicionar fotos reais

As áreas coloridas com ícones (hero, cards de serviço, galeria) são placeholders.
Para usar fotos reais:

1. Coloque as imagens em uma pasta `images/` (ex.: `images/facial.jpg`).
2. Substitua o `<div class="thumb">💆‍♀️</div>` por `<img src="images/facial.jpg" alt="...">`
   ou aplique a foto como `background-image` na classe correspondente do `css/style.css`.
3. Tamanho recomendado: ~1200px de largura, otimizado para web (< 500 KB).

## 🚀 Como publicar

**GitHub Pages:** Settings → Pages → selecione a branch → o site fica em
`https://<usuario>.github.io/mudare/`.

**Hospedagem tradicional:** envie todos os arquivos por FTP com `index.html` na raiz.

## ⚠️ Observações

- O site ao vivo bloqueia acesso automatizado, então o layout **não** é um clone pixel-a-pixel:
  é uma reconstrução fiel do conteúdo, da estrutura de páginas e das informações reais do negócio.
- Os textos das páginas de serviço foram redigidos com base nos serviços que o Espaço Máxima
  oferece (extraídos do backup/WordPress). Revise e ajuste valores, horários e descrições
  conforme necessário.
- Confirme o usuário do Instagram e os links de redes sociais antes de publicar.

---

**Espaço Máxima** — Cuidar de você é a nossa máxima.
