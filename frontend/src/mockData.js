// Mock data MUDARE - Com fotos reais dos projetos

export const companyInfo = {
  name: "MUDARE",
  tagline: "Construtora de Alto Padrão",
  subtitle: "A engenharia como arte",
  foundedYear: 2008,
  hero: {
    title: "A Engenharia como Arte",
    description: "A Mudare Construtora é uma construtora de alto padrão liderada por dois engenheiros formados na tradicional Faculdade de Engenharia de São Paulo."
  },
  philosophy: "Somos uma construtora de engenharia de alto padrão que nasce da convergência entre tradição técnica consolidada e a visão contemporânea da construção. Unimos conhecimento clássico a práticas atualizadas de engenharia, garantindo especificações corretas, controle de qualidade rigoroso e desempenho estrutural duradouro.",
  approach: "A Mudare adota tecnologia avançada e processos construtivos modernos: planejamento detalhado, rastreabilidade de insumos e medições precisas. Nossa atuação abrange desde análise estrutural rigorosa até a entrega de soluções integradas — com compatibilização de projetos, gestão técnica de obras e comissionamento.",
  mission: "Transformar projeto em patrimônio com método, precisão e responsabilidade.",
  excellence: {
    title: "A excelência que se traduz em cada detalhe",
    description: "Na Mudare, a curadoria minuciosa de materiais e a atenção aos detalhes definem nossa forma de trabalhar. Buscamos criar experiências arquitetônicas que unem estética, funcionalidade e durabilidade — sempre com transparência na relação com clientes e arquitetos, precisão, respeitando prazos e diretrizes, sem abrir mão da sofisticação dos detalhes e da busca contínua por inovação."
  },
  vision: "Acreditamos no aperfeiçoamento constante e estamos preparados para superar desafios. A cada entrega, reinventamos o prazer de construir.",
  contact: {
    address: "Av. Diógenes Ribeiro de Lima, 1776 - conjunto 2",
    neighborhood: "Alto de Pinheiros",
    city: "São Paulo",
    cep: "05467-002",
    phone: "+55 11 2476-9303",
    email: "contato@mudare.eng.br",
    website: "www.mudare.eng.br"
  }
};

export const specializations = [
  "Construção residencial de alto padrão em São Paulo",
  "Projetos residenciais, comerciais e corporativos",
  "Administração de Empresas",
  "Construções Civis com foco em Excelência Construtiva e Anomalias",
  "Peritos judiciais em varas estaduais e federais",
  "Obras de infraestrutura urbana e loteamentos",
  "Residências de luxo com forte assinatura arquitetônica",
  "Empreendimentos premiados nacional e internacionalmente",
  "Obras com arquitetura autoral e alto padrão construtivo"
];

export const processSteps = [
  {
    id: 1,
    number: "01",
    title: "Diagnóstico",
    description: "Diagnóstico objetivo que define escopo, metas de desempenho e riscos."
  },
  {
    id: 2,
    number: "02",
    title: "Compatibilização",
    description: "Compatibilização rigorosa para eliminar interferências e otimizar custo e prazo."
  },
  {
    id: 3,
    number: "03",
    title: "Planejamento",
    description: "Planejamos o canteiro com cronograma físico financeiro, caminho crítico e logística clara."
  },
  {
    id: 4,
    number: "04",
    title: "Execução",
    description: "Especificações fundamentadas em normas ABNT, rastreabilidade de decisões e controle de qualidade com registros, ensaios e amostras aprovadas."
  },
  {
    id: 5,
    number: "05",
    title: "Finalização",
    description: "Proteção de interfaces, tolerâncias controladas e comissionamento completo com testes, documentação as built, manual do proprietário e treinamento do usuário."
  },
  {
    id: 6,
    number: "06",
    title: "Pós-Obra",
    description: "Plano de manutenção e atendimento em garantia."
  }
];

export const stats = [
  { label: "Anos de Experiência", value: "15+" },
  { label: "Projetos Concluídos", value: "100+" },
  { label: "Arquitetos Parceiros", value: "30+" },
  { label: "Prêmios", value: "15+" }
];

export const teamMembers = [
  {
    id: 1,
    name: "Walter Kovatch",
    role: "Diretor Administrativo",
    credentials: [
      "Engenheiro Civil",
      "Especialista em Construção Civil",
      "Membro IBAPE/SP",
      "Perito Federal"
    ],
    image: "https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400&h=400&fit=crop"
  },
  {
    id: 2,
    name: "Sergio Ramos",
    role: "Diretor Técnico",
    credentials: [
      "Engenheiro Civil",
      "Técnico em Edificações - ETESP CREA",
      "Especialista em Administração de Engenharia"
    ],
    image: "https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=400&h=400&fit=crop"
  }
];

// Projetos com fotos reais da MUDARE
export const projects = [
  {
    id: 1,
    title: "Residência Morumbi",
    category: "Residencial",
    location: "São Paulo - Morumbi",
    architect: "Studio MK27",
    year: 2022,
    area: "850m²",
    description: "Residência de luxo com forte assinatura arquitetônica e acabamentos premium",
    image: "https://customer-assets.emergentagent.com/job_portfolio-upgrade-19/artifacts/ewheq3u2_Residencia_Morumbi_02.jpg",
    featured: true
  },
  {
    id: 2,
    title: "Restaurante Kinoshita",
    category: "Comercial",
    location: "São Paulo",
    architect: "Studio de Arquitetura",
    year: 2021,
    area: "320m²",
    description: "Restaurante japonês de alto padrão com design sofisticado",
    image: "https://customer-assets.emergentagent.com/job_portfolio-upgrade-19/artifacts/6qeg3nnv_Rest_Kinoshita_03.jpg",
    featured: true
  },
  {
    id: 3,
    title: "Instituto Ayrton Senna",
    category: "Corporativo",
    location: "São Paulo",
    architect: "Candida Tabet Arquitetura",
    year: 2020,
    area: "1200m²",
    description: "Projeto institucional premiado com arquitetura contemporânea",
    image: "https://customer-assets.emergentagent.com/job_portfolio-upgrade-19/artifacts/xb03c03u_Ayrton_Senna_Instituto%2002.jpg",
    featured: true
  },
  {
    id: 4,
    title: "Kross Atelier",
    category: "Comercial",
    location: "São Paulo",
    architect: "Olegário de Sá",
    year: 2021,
    area: "450m²",
    description: "Espaço comercial premium com design autoral",
    image: "https://customer-assets.emergentagent.com/job_portfolio-upgrade-19/artifacts/tg3db9if_Kross_Atelier_IMG_9696.jpg",
    featured: true
  },
  {
    id: 5,
    title: "Electrolux",
    category: "Corporativo",
    location: "São Paulo",
    architect: "Castello Branco Arquitetura",
    year: 2020,
    area: "2800m²",
    description: "Projeto corporativo de grande porte com infraestrutura completa",
    image: "https://customer-assets.emergentagent.com/job_portfolio-upgrade-19/artifacts/u6pzs149_Eletrolux_03.jpg",
    featured: true
  },
  {
    id: 6,
    title: "Casa do Lago",
    category: "Residencial",
    location: "São Paulo",
    architect: "Augusto Perez e Dado Comini",
    year: 2019,
    area: "920m²",
    description: "Residência integrada ao paisagismo",
    image: "https://images.unsplash.com/photo-1628012209120-d9db7abf7eab",
    featured: true
  },
  {
    id: 7,
    title: "Casa Vista Trancoso",
    category: "Residencial",
    location: "Trancoso",
    architect: "Studio MK27",
    year: 2020,
    area: "680m²",
    description: "Casa de praia com vista privilegiada",
    image: "https://images.unsplash.com/photo-1531971589569-0d9370cbe1e5",
    featured: false
  },
  {
    id: 8,
    title: "Triplex Panamby",
    category: "Residencial",
    location: "São Paulo",
    architect: "Cristina Casellato",
    year: 2021,
    area: "540m²",
    description: "Triplex com design contemporâneo",
    image: "https://images.pexels.com/photos/1732414/pexels-photo-1732414.jpeg",
    featured: false
  }
];

export const services = [
  {
    id: 1,
    title: "Construção Residencial de Alto Padrão",
    description: "Residências de luxo com forte assinatura arquitetônica e alto padrão construtivo."
  },
  {
    id: 2,
    title: "Projetos Comerciais e Corporativos",
    description: "Empreendimentos premiados nacional e internacionalmente com arquitetura autoral."
  },
  {
    id: 3,
    title: "Gestão Técnica de Obras",
    description: "Compatibilização de projetos, gestão técnica completa e comissionamento."
  },
  {
    id: 4,
    title: "Perícia Judicial",
    description: "Atuação como peritos judiciais em varas estaduais e federais."
  },
  {
    id: 5,
    title: "Infraestrutura Urbana",
    description: "Obras de infraestrutura urbana e desenvolvimento de loteamentos."
  },
  {
    id: 6,
    title: "Análise Estrutural",
    description: "Análise estrutural rigorosa com controle de qualidade e ensaios técnicos."
  }
];

export const testimonials = [
  {
    id: 1,
    name: "Carlos Mendes",
    role: "Proprietário",
    project: "Residência Morumbi",
    content: "A Mudare superou todas as expectativas. A atenção aos detalhes e o comprometimento com a qualidade são incomparáveis.",
    rating: 5
  },
  {
    id: 2,
    name: "Ana Paula Silva",
    role: "Arquiteta",
    project: "Instituto Ayrton Senna",
    content: "Trabalhar com a Mudare é ter a certeza de que cada especificação do projeto será executada com precisão e excelência.",
    rating: 5
  },
  {
    id: 3,
    name: "Roberto Oliveira",
    role: "Investidor",
    project: "Electrolux",
    content: "Profissionalismo, transparência e resultado excepcional. A Mudare transformou nosso projeto em realidade.",
    rating: 5
  }
];

// Imagens para seção de processo (usando fotos reais)
export const processImages = [
  "https://customer-assets.emergentagent.com/job_portfolio-upgrade-19/artifacts/ewheq3u2_Residencia_Morumbi_02.jpg",
  "https://customer-assets.emergentagent.com/job_portfolio-upgrade-19/artifacts/6qeg3nnv_Rest_Kinoshita_03.jpg",
  "https://customer-assets.emergentagent.com/job_portfolio-upgrade-19/artifacts/tg3db9if_Kross_Atelier_IMG_9696.jpg"
];