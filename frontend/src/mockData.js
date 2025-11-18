// Mock data MUDARE - Premium & Minimalista (Curadoria Nizan Guanaes)

export const companyInfo = {
  name: "MUDARE",
  slogan: "Mudar para melhor. Sempre",
  tagline: "Construtora de Alto Padrão",
  foundedYear: 2008,
  hero: {
    title: "Construímos Mais Que Obras.",
    subtitle: "Realizamos Sonhos.",
    description: "Há 15 anos transformando projetos de arquitetura autoral em obras de referência. Parceiros dos principais arquitetos do Brasil."
  },
  manifesto: "Acreditamos que construir é uma arte que exige técnica, precisão e paixão. Não somos apenas executores - somos parceiros de arquitetos que transformam visão em realidade, onde cada detalhe importa e cada projeto é tratado como único.",
  philosophy: "Nascemos da convergência entre excelência técnica e sensibilidade estética. Trabalhamos lado a lado com os melhores arquitetos do país, respeitando cada linha do projeto, cada escolha de material, cada intenção arquitetônica.",
  approach: "Nossa abordagem é baseada em três pilares: precisão técnica absoluta, respeito incondicional ao projeto arquitetônico e transparência total com clientes e arquitetos. Não fazemos concessões.",
  excellence: {
    title: "Excelência Não É Um Diferencial.",
    subtitle: "É Nossa Natureza.",
    description: "Parceiros de arquitetos como Studio MK27, Candida Tabet, Olegário de Sá e Castello Branco. Cada projeto é executado com a precisão que a arquitetura autoral exige. Sem improvisações, sem atalhos, sem meio termo."
  },
  values: [
    "Precisão Técnica",
    "Respeito ao Projeto",
    "Transparência",
    "Paixão pela Excelência"
  ],
  vision: "A cada entrega, celebramos a realização de uma visão arquitetônica transformada em edificação impecável.",
  mission: "Transformar projeto em patrimônio. Transformar visão em realidade. Mudar para melhor. Sempre.",
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

export const stats = [
  { label: "Anos", value: "15+" },
  { label: "Projetos", value: "100+" },
  { label: "Arquitetos", value: "30+" },
  { label: "Prêmios", value: "15+" }
];

export const architects = [
  "Studio MK27",
  "Candida Tabet Arquitetura",
  "Olegário de Sá",
  "Castello Branco Arquitetura",
  "Mauricio Nobrega",
  "Augusto Perez",
  "David Bastos",
  "Cristina Casellato"
];

export const teamMembers = [
  {
    id: 1,
    name: "Walter Kovatch",
    role: "Diretor Administrativo",
    bio: "Engenheiro civil com especialização em gestão de obras complexas.",
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
    bio: "Engenheiro civil especializado em arquitetura de alto padrão.",
    credentials: [
      "Engenheiro Civil",
      "Técnico em Edificações - ETESP CREA",
      "Especialista em Administração de Engenharia"
    ],
    image: "https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=400&h=400&fit=crop"
  }
];

export const projects = [
  {
    id: 1,
    title: "Residência Morumbi",
    category: "Residencial",
    location: "São Paulo",
    architect: "Studio MK27",
    year: 2022,
    area: "850m²",
    description: "Arquitetura contemporânea onde cada detalhe foi executado com precisão milimétrica.",
    story: "Parceria com o Studio MK27 resultou em uma obra de referência que respeita cada linha do projeto original.",
    image: "https://customer-assets.emergentagent.com/job_portfolio-upgrade-19/artifacts/ewheq3u2_Residencia_Morumbi_02.jpg",
    featured: true,
    seoAlt: "Casa de alto padrão Morumbi - Construção residencial de luxo São Paulo"
  },
  {
    id: 2,
    title: "Restaurante Kinoshita",
    category: "Comercial",
    location: "São Paulo",
    architect: "Studio de Arquitetura",
    year: 2021,
    area: "320m²",
    description: "Projeto comercial que une estética refinada e funcionalidade operacional.",
    story: "Execução técnica impecável que respeitou os prazos sem comprometer a qualidade.",
    image: "https://customer-assets.emergentagent.com/job_portfolio-upgrade-19/artifacts/6qeg3nnv_Rest_Kinoshita_03.jpg",
    featured: true,
    seoAlt: "Reforma comercial alto padrão - Construção loja luxo São Paulo"
  },
  {
    id: 3,
    title: "Instituto Ayrton Senna",
    category: "Corporativo",
    location: "São Paulo",
    architect: "Candida Tabet Arquitetura",
    year: 2020,
    area: "1200m²",
    description: "Projeto institucional premiado que alia arquitetura contemporânea e funcionalidade.",
    story: "Obra complexa executada em parceria com Candida Tabet, reconhecida nacional e internacionalmente.",
    image: "https://customer-assets.emergentagent.com/job_portfolio-upgrade-19/artifacts/xb03c03u_Ayrton_Senna_Instituto%2002.jpg",
    featured: true,
    seoAlt: "Reforma escritório corporativo São Paulo - Obra comercial alto padrão"
  },
  {
    id: 4,
    title: "Kross Atelier",
    category: "Comercial",
    location: "São Paulo",
    architect: "Olegário de Sá",
    year: 2021,
    area: "450m²",
    description: "Espaço comercial com design autoral e acabamentos premium.",
    story: "Projeto executado em parceria com Olegário de Sá, respeitando cada especificação técnica.",
    image: "https://customer-assets.emergentagent.com/job_portfolio-upgrade-19/artifacts/tg3db9if_Kross_Atelier_IMG_9696.jpg",
    featured: true,
    seoAlt: "Fit out comercial São Paulo - Construção loja de luxo"
  },
  {
    id: 5,
    title: "Electrolux",
    category: "Corporativo",
    location: "São Paulo",
    architect: "Castello Branco Arquitetura",
    year: 2020,
    area: "2800m²",
    description: "Infraestrutura corporativa de grande porte com complexidade técnica elevada.",
    story: "Projeto que exigiu coordenação precisa de múltiplas especialidades técnicas.",
    image: "https://customer-assets.emergentagent.com/job_portfolio-upgrade-19/artifacts/u6pzs149_Eletrolux_03.jpg",
    featured: true,
    seoAlt: "Fit out escritório corporativo SP - Reforma comercial grande porte"
  },
  {
    id: 6,
    title: "Casa do Lago",
    category: "Residencial",
    location: "São Paulo",
    architect: "Augusto Perez e Dado Comini",
    year: 2019,
    area: "920m²",
    description: "Arquitetura que dialoga com a natureza, executada com precisão técnica.",
    story: "Obra que exigiu soluções técnicas customizadas para preservar o entorno natural.",
    image: "https://images.unsplash.com/photo-1628012209120-d9db7abf7eab",
    featured: true,
    seoAlt: "Casa contemporânea alto padrão - Arquitetura moderna São Paulo"
  }
];

export const services = [
  {
    id: 1,
    title: "Construção Residencial",
    description: "Execução de projetos residenciais de arquitetura autoral com precisão técnica absoluta.",
    technical: "Gestão completa de obra, coordenação de especialidades, controle de qualidade rigoroso."
  },
  {
    id: 2,
    title: "Obras Comerciais",
    description: "Projetos comerciais que aliam estética contemporânea e funcionalidade operacional.",
    technical: "Fit out completo, coordenação com arquitetura de interiores, gestão de prazos."
  },
  {
    id: 3,
    title: "Infraestrutura Corporativa",
    description: "Obras corporativas de alta complexidade técnica e grande porte.",
    technical: "Gestão de múltiplas especialidades, coordenação BIM, comissionamento."
  },
  {
    id: 4,
    title: "Administração Técnica",
    description: "Gestão técnica completa para projetos de arquitetos.",
    technical: "Compatibilização de projetos, controle de custos, coordenação de equipes."
  }
];

export const processSteps = [
  {
    id: 1,
    number: "01",
    title: "Análise",
    description: "Estudo aprofundado do projeto arquitetônico e levantamento de complexidades técnicas."
  },
  {
    id: 2,
    number: "02",
    title: "Compatibilização",
    description: "Coordenação de todas as especialidades técnicas para eliminar interferências."
  },
  {
    id: 3,
    number: "03",
    title: "Planejamento",
    description: "Cronograma detalhado, logística de obra e planejamento financeiro."
  },
  {
    id: 4,
    number: "04",
    title: "Execução",
    description: "Construção com controle de qualidade rigoroso e respeito absoluto ao projeto."
  },
  {
    id: 5,
    number: "05",
    title: "Comissionamento",
    description: "Testes, verificações finais e documentação as built completa."
  },
  {
    id: 6,
    number: "06",
    title: "Garantia",
    description: "Suporte técnico pós-obra e manutenção preventiva."
  }
];

export const testimonials = [
  {
    id: 1,
    name: "Carlos Mendes",
    role: "Proprietário",
    project: "Residência Morumbi",
    content: "A MUDARE executou nosso projeto com uma precisão que superou expectativas. Cada detalhe foi tratado com o cuidado que uma obra de arquitetura autoral exige.",
    rating: 5
  },
  {
    id: 2,
    name: "Ana Paula Silva",
    role: "Arquiteta",
    project: "Instituto Ayrton Senna",
    content: "Parceria verdadeira. A MUDARE não apenas executa - compreende e respeita cada decisão de projeto. Profissionalismo raro no mercado.",
    rating: 5
  },
  {
    id: 3,
    name: "Roberto Oliveira",
    role: "Diretor",
    project: "Electrolux",
    content: "Gestão técnica impecável em uma obra de grande complexidade. Transparência e compromisso com qualidade do início ao fim.",
    rating: 5
  }
];

export const processImages = [
  "https://customer-assets.emergentagent.com/job_portfolio-upgrade-19/artifacts/ewheq3u2_Residencia_Morumbi_02.jpg",
  "https://customer-assets.emergentagent.com/job_portfolio-upgrade-19/artifacts/6qeg3nnv_Rest_Kinoshita_03.jpg",
  "https://customer-assets.emergentagent.com/job_portfolio-upgrade-19/artifacts/tg3db9if_Kross_Atelier_IMG_9696.jpg"
];

export const whyMudare = [
  {
    title: "Precisão Técnica",
    description: "Excelência na execução de projetos complexos."
  },
  {
    title: "Parceria",
    description: "Trabalhamos lado a lado com os melhores arquitetos."
  },
  {
    title: "Transparência",
    description: "Comunicação clara em todas as etapas do projeto."
  },
  {
    title: "Compromisso",
    description: "Prazo e qualidade são inegociáveis."
  }
];

export const faq = [
  {
    id: 1,
    question: "A MUDARE trabalha com projetos de arquitetos?",
    answer: "Sim. Nossa especialidade é executar projetos de arquitetura autoral. Trabalhamos em parceria com arquitetos como Studio MK27, Candida Tabet, Olegário de Sá, Castello Branco e outros renomados profissionais, respeitando cada decisão de projeto e garantindo execução técnica impecável."
  },
  {
    id: 2,
    question: "Qual o diferencial da MUDARE?",
    answer: "Nossa abordagem é baseada em três pilares: precisão técnica absoluta, respeito incondicional ao projeto arquitetônico e transparência total. Não somos apenas executores - somos parceiros que compreendem a importância de cada detalhe em uma obra de arquitetura autoral."
  },
  {
    id: 3,
    question: "Como funciona a administração técnica de obras?",
    answer: "Oferecemos gestão técnica completa: compatibilização de projetos, coordenação de especialidades, controle de qualidade, gestão de prazos e custos. O arquiteto mantém controle criativo enquanto garantimos a execução técnica perfeita."
  },
  {
    id: 4,
    question: "Quais tipos de projeto a MUDARE executa?",
    answer: "Executamos projetos residenciais, comerciais e corporativos de alto padrão. Nossa expertise está em obras que exigem precisão técnica elevada e atenção a detalhes, desde residências de arquitetura contemporânea até infraestruturas corporativas complexas."
  },
  {
    id: 5,
    question: "Como solicitar um orçamento?",
    answer: "Entre em contato pelo telefone +55 11 2476-9303 ou email contato@mudare.eng.br. Analisamos o projeto arquitetônico e fornecemos orçamento detalhado com cronograma e especificações técnicas."
  }
];