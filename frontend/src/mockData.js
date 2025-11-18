// Mock data para MUDARE Construtora

export const companyInfo = {
  name: "MUDARE",
  tagline: "Construtora de Alto Padrão",
  foundedYear: 2008,
  description: "A Mudare Construtora é uma construtora de alto padrão liderada por dois engenheiros formados na tradicional Faculdade de Engenharia de São Paulo.",
  mission: "Transformar projeto em patrimônio com método, precisão e responsabilidade.",
  values: ["Qualidade", "Rigor", "Precisão", "Eficiência", "Confiabilidade", "Sofisticação", "Inovação", "Transparência"],
  contact: {
    address: "Av. Diógenes Ribeiro de Lima, 1776 - conjunto 2",
    neighborhood: "Alto de Pinheiros",
    city: "São Paulo",
    cep: "05467",
    phone: "55 11 2476-9303",
    email: "contato@mudare.eng.br",
    website: "www.mudare.eng.br"
  }
};

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

export const projects = [
  {
    id: 1,
    title: "Casa Areia",
    category: "Residencial",
    location: "São Paulo",
    architect: "Studio MK27",
    year: 2022,
    description: "Residência de luxo com forte assinatura arquitetônica",
    image: "https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&h=600&fit=crop",
    featured: true
  },
  {
    id: 2,
    title: "Triplex Cidade Jardim",
    category: "Residencial",
    location: "São Paulo",
    architect: "Studio MK27",
    year: 2021,
    description: "Apartamento triplex de alto padrão",
    image: "https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=800&h=600&fit=crop",
    featured: true
  },
  {
    id: 3,
    title: "Fazenda Boa Vista",
    category: "Residencial",
    location: "Porto Feliz",
    architect: "Castello Branco Arquitetura & Interiores",
    year: 2020,
    description: "Casa sofisticada que une conforto, tecnologia e harmonia com o entorno natural",
    image: "https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=800&h=600&fit=crop",
    featured: true
  },
  {
    id: 4,
    title: "Quinta da Baronesa",
    category: "Residencial",
    location: "São Paulo",
    architect: "Candida Tabet Arquitetura",
    year: 2021,
    description: "Projeto residencial com arquitetura autoral",
    image: "https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&h=600&fit=crop",
    featured: false
  },
  {
    id: 5,
    title: "Cobertura Duplex",
    category: "Residencial",
    location: "São Paulo",
    architect: "Olegário de Sá",
    year: 2020,
    description: "Cobertura duplex com acabamento premium",
    image: "https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800&h=600&fit=crop",
    featured: false
  },
  {
    id: 6,
    title: "Casa do Lago",
    category: "Residencial",
    location: "São Paulo",
    architect: "Augusto Perez e Dado Comini",
    year: 2019,
    description: "Residência integrada ao paisagismo",
    image: "https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800&h=600&fit=crop",
    featured: false
  },
  {
    id: 7,
    title: "Triplex Panamby",
    category: "Residencial",
    location: "São Paulo",
    architect: "Cristina Casellato",
    year: 2021,
    description: "Triplex com design contemporâneo",
    image: "https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?w=800&h=600&fit=crop",
    featured: false
  },
  {
    id: 8,
    title: "Casa PK Baroneza",
    category: "Residencial",
    location: "São Paulo",
    architect: "David Bastos",
    year: 2020,
    description: "Casa de alto padrão construtivo",
    image: "https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=800&h=600&fit=crop",
    featured: false
  }
];

export const services = [
  {
    id: 1,
    title: "Construção Residencial",
    description: "Construção de residências de luxo com forte assinatura arquitetônica e alto padrão construtivo.",
    icon: "home"
  },
  {
    id: 2,
    title: "Projetos Comerciais",
    description: "Desenvolvimento de empreendimentos comerciais premiados nacional e internacionalmente.",
    icon: "building"
  },
  {
    id: 3,
    title: "Gestão Técnica",
    description: "Compatibilização de projetos, gestão técnica de obras e comissionamento completo.",
    icon: "clipboard-check"
  },
  {
    id: 4,
    title: "Perícia Judicial",
    description: "Atuação como peritos judiciais em varas estaduais e federais.",
    icon: "scale"
  },
  {
    id: 5,
    title: "Infraestrutura Urbana",
    description: "Obras de infraestrutura urbana e desenvolvimento de loteamentos.",
    icon: "map"
  },
  {
    id: 6,
    title: "Análise Estrutural",
    description: "Análise estrutural rigorosa e controle de qualidade com ensaios e amostras aprovadas.",
    icon: "wrench"
  }
];

export const testimonials = [
  {
    id: 1,
    name: "Carlos Mendes",
    role: "Proprietário",
    project: "Casa Areia",
    content: "A Mudare superou todas as expectativas. A atenção aos detalhes e o comprometimento com a qualidade são incomparáveis.",
    rating: 5
  },
  {
    id: 2,
    name: "Ana Paula Silva",
    role: "Arquiteta",
    project: "Triplex Cidade Jardim",
    content: "Trabalhar com a Mudare é ter a certeza de que cada especificação do projeto será executada com precisão e excelência.",
    rating: 5
  },
  {
    id: 3,
    name: "Roberto Oliveira",
    role: "Investidor",
    project: "Fazenda Boa Vista",
    content: "Profissionalismo, transparência e resultado excepcional. A Mudare transformou nosso projeto em realidade.",
    rating: 5
  }
];

export const processSteps = [
  {
    id: 1,
    title: "Diagnóstico",
    description: "Diagnóstico objetivo que define escopo, metas de desempenho e riscos."
  },
  {
    id: 2,
    title: "Compatibilização",
    description: "Compatibilização rigorosa para eliminar interferências e otimizar custo e prazo."
  },
  {
    id: 3,
    title: "Planejamento",
    description: "Planejamento do canteiro com cronograma físico financeiro e logística clara."
  },
  {
    id: 4,
    title: "Execução",
    description: "Especificações fundamentadas em normas ABNT e controle de qualidade rigoroso."
  },
  {
    id: 5,
    title: "Comissionamento",
    description: "Testes completos, documentação as built e manual do proprietário."
  },
  {
    id: 6,
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