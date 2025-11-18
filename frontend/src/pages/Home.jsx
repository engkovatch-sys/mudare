import React, { useState } from 'react';
import { Link } from 'react-router-dom';
import { Button } from '../components/ui/button';
import { Card, CardContent } from '../components/ui/card';
import { Badge } from '../components/ui/badge';
import { Separator } from '../components/ui/separator';
import { 
  Building2, 
  Award, 
  Users, 
  ArrowRight, 
  Home as HomeIcon,
  Building,
  ClipboardCheck,
  Scale,
  Map,
  Wrench,
  Star,
  Phone,
  Mail,
  MapPin,
  CheckCircle2
} from 'lucide-react';
import { companyInfo, projects, services, testimonials, stats, teamMembers, processSteps } from '../mockData';

const Home = () => {
  const [selectedCategory, setSelectedCategory] = useState('Todos');
  const categories = ['Todos', 'Residencial', 'Comercial', 'Corporativo'];

  const filteredProjects = selectedCategory === 'Todos' 
    ? projects.filter(p => p.featured)
    : projects.filter(p => p.category === selectedCategory && p.featured);

  const getServiceIcon = (iconName) => {
    const icons = {
      'home': HomeIcon,
      'building': Building,
      'clipboard-check': ClipboardCheck,
      'scale': Scale,
      'map': Map,
      'wrench': Wrench
    };
    const Icon = icons[iconName] || Building2;
    return <Icon className="w-8 h-8" />;
  };

  return (
    <div className="min-h-screen">
      {/* Header */}
      <header className="fixed top-0 w-full bg-white/95 backdrop-blur-sm border-b border-gray-200 z-50">
        <div className="container mx-auto px-6 py-4">
          <div className="flex items-center justify-between">
            <div className="flex items-center space-x-2">
              <Building2 className="w-8 h-8 text-[#D85F00]" />
              <div>
                <h1 className="text-2xl font-bold text-gray-900">{companyInfo.name}</h1>
                <p className="text-xs text-gray-600">{companyInfo.tagline}</p>
              </div>
            </div>
            <nav className="hidden md:flex items-center space-x-8">
              <a href="#sobre" className="text-gray-700 hover:text-[#D85F00] transition-colors font-medium">Sobre</a>
              <a href="#projetos" className="text-gray-700 hover:text-[#D85F00] transition-colors font-medium">Projetos</a>
              <a href="#servicos" className="text-gray-700 hover:text-[#D85F00] transition-colors font-medium">Serviços</a>
              <a href="#equipe" className="text-gray-700 hover:text-[#D85F00] transition-colors font-medium">Equipe</a>
              <Button className="bg-[#D85F00] hover:bg-[#B84F00] text-white">
                <a href="#contato">Contato</a>
              </Button>
            </nav>
          </div>
        </div>
      </header>

      {/* Hero Section */}
      <section className="pt-32 pb-20 bg-gradient-to-b from-gray-50 to-white">
        <div className="container mx-auto px-6">
          <div className="max-w-4xl mx-auto text-center">
            <Badge className="mb-6 bg-[#D85F00]/10 text-[#D85F00] hover:bg-[#D85F00]/20 border-none px-4 py-2">
              Desde {companyInfo.foundedYear}
            </Badge>
            <h2 className="text-5xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
              A Engenharia como Arte
            </h2>
            <p className="text-xl text-gray-600 mb-8 leading-relaxed">
              {companyInfo.description}
            </p>
            <p className="text-lg text-gray-700 mb-10 font-medium italic">
              "{companyInfo.mission}"
            </p>
            <div className="flex flex-col sm:flex-row gap-4 justify-center">
              <Button size="lg" className="bg-[#D85F00] hover:bg-[#B84F00] text-white px-8">
                <a href="#projetos" className="flex items-center gap-2">
                  Ver Projetos <ArrowRight className="w-4 h-4" />
                </a>
              </Button>
              <Button size="lg" variant="outline" className="border-gray-300 hover:bg-gray-50 px-8">
                <a href="#contato">Solicitar Orçamento</a>
              </Button>
            </div>
          </div>

          {/* Stats */}
          <div className="grid grid-cols-2 md:grid-cols-4 gap-6 mt-20 max-w-5xl mx-auto">
            {stats.map((stat, index) => (
              <Card key={index} className="border-none shadow-sm bg-white">
                <CardContent className="p-6 text-center">
                  <div className="text-4xl font-bold text-[#D85F00] mb-2">{stat.value}</div>
                  <div className="text-sm text-gray-600">{stat.label}</div>
                </CardContent>
              </Card>
            ))}
          </div>
        </div>
      </section>

      {/* Sobre Section */}
      <section id="sobre" className="py-20 bg-white">
        <div className="container mx-auto px-6">
          <div className="max-w-6xl mx-auto">
            <div className="grid md:grid-cols-2 gap-12 items-center">
              <div>
                <Badge className="mb-4 bg-gray-100 text-gray-700 hover:bg-gray-200 border-none">Sobre Nós</Badge>
                <h2 className="text-4xl font-bold text-gray-900 mb-6">
                  Excelência em Cada Detalhe
                </h2>
                <p className="text-gray-600 mb-6 leading-relaxed">
                  Unimos conhecimento clássico a práticas atualizadas de engenharia, garantindo especificações corretas, 
                  controle de qualidade rigoroso e desempenho estrutural duradouro.
                </p>
                <p className="text-gray-600 mb-6 leading-relaxed">
                  Adotamos tecnologia avançada e processos construtivos modernos com planejamento detalhado, 
                  rastreabilidade de insumos e medições precisas.
                </p>
                <div className="space-y-3">
                  {companyInfo.values.slice(0, 4).map((value, index) => (
                    <div key={index} className="flex items-center gap-3">
                      <CheckCircle2 className="w-5 h-5 text-[#D85F00]" />
                      <span className="text-gray-700 font-medium">{value}</span>
                    </div>
                  ))}
                </div>
              </div>
              <div className="relative">
                <div className="aspect-square rounded-lg overflow-hidden shadow-xl">
                  <img 
                    src="https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=600&h=600&fit=crop" 
                    alt="Construção"
                    className="w-full h-full object-cover"
                  />
                </div>
                <div className="absolute -bottom-6 -left-6 bg-[#D85F00] text-white p-6 rounded-lg shadow-lg">
                  <Award className="w-8 h-8 mb-2" />
                  <div className="text-2xl font-bold">15+</div>
                  <div className="text-sm">Prêmios Nacionais</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Projetos Section */}
      <section id="projetos" className="py-20 bg-gray-50">
        <div className="container mx-auto px-6">
          <div className="text-center mb-12">
            <Badge className="mb-4 bg-[#D85F00]/10 text-[#D85F00] hover:bg-[#D85F00]/20 border-none">Portfólio</Badge>
            <h2 className="text-4xl font-bold text-gray-900 mb-4">Projetos em Destaque</h2>
            <p className="text-gray-600 max-w-2xl mx-auto">
              Obras com arquitetura autoral e alto padrão construtivo
            </p>
          </div>

          {/* Category Filter */}
          <div className="flex justify-center gap-3 mb-12 flex-wrap">
            {categories.map((category) => (
              <Button
                key={category}
                variant={selectedCategory === category ? "default" : "outline"}
                onClick={() => setSelectedCategory(category)}
                className={selectedCategory === category 
                  ? "bg-[#D85F00] hover:bg-[#B84F00] text-white" 
                  : "border-gray-300 hover:bg-gray-100"}
              >
                {category}
              </Button>
            ))}
          </div>

          {/* Projects Grid */}
          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
            {filteredProjects.map((project) => (
              <Card key={project.id} className="group overflow-hidden border-none shadow-md hover:shadow-xl transition-all duration-300">
                <div className="relative h-64 overflow-hidden">
                  <img 
                    src={project.image} 
                    alt={project.title}
                    className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                  />
                  <div className="absolute top-4 right-4">
                    <Badge className="bg-white/90 text-gray-900 hover:bg-white">{project.category}</Badge>
                  </div>
                </div>
                <CardContent className="p-6">
                  <h3 className="text-xl font-bold text-gray-900 mb-2">{project.title}</h3>
                  <p className="text-sm text-gray-600 mb-3">{project.description}</p>
                  <div className="flex items-center justify-between text-sm">
                    <span className="text-gray-500">{project.architect}</span>
                    <span className="text-[#D85F00] font-medium">{project.year}</span>
                  </div>
                </CardContent>
              </Card>
            ))}
          </div>

          <div className="text-center mt-12">
            <Button variant="outline" size="lg" className="border-gray-300 hover:bg-gray-100">
              Ver Todos os Projetos <ArrowRight className="w-4 h-4 ml-2" />
            </Button>
          </div>
        </div>
      </section>

      {/* Serviços Section */}
      <section id="servicos" className="py-20 bg-white">
        <div className="container mx-auto px-6">
          <div className="text-center mb-12">
            <Badge className="mb-4 bg-gray-100 text-gray-700 hover:bg-gray-200 border-none">Serviços</Badge>
            <h2 className="text-4xl font-bold text-gray-900 mb-4">O Que Fazemos</h2>
            <p className="text-gray-600 max-w-2xl mx-auto">
              Soluções completas em engenharia e construção
            </p>
          </div>

          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            {services.map((service) => (
              <Card key={service.id} className="border-none shadow-sm hover:shadow-md transition-shadow">
                <CardContent className="p-8">
                  <div className="w-16 h-16 bg-[#D85F00]/10 rounded-lg flex items-center justify-center mb-4 text-[#D85F00]">
                    {getServiceIcon(service.icon)}
                  </div>
                  <h3 className="text-xl font-bold text-gray-900 mb-3">{service.title}</h3>
                  <p className="text-gray-600 leading-relaxed">{service.description}</p>
                </CardContent>
              </Card>
            ))}
          </div>
        </div>
      </section>

      {/* Processo Section */}
      <section className="py-20 bg-gray-50">
        <div className="container mx-auto px-6">
          <div className="text-center mb-12">
            <Badge className="mb-4 bg-[#D85F00]/10 text-[#D85F00] hover:bg-[#D85F00]/20 border-none">Metodologia</Badge>
            <h2 className="text-4xl font-bold text-gray-900 mb-4">Nosso Processo</h2>
            <p className="text-gray-600 max-w-2xl mx-auto">
              Método, precisão e responsabilidade em cada etapa
            </p>
          </div>

          <div className="max-w-4xl mx-auto">
            <div className="space-y-6">
              {processSteps.map((step, index) => (
                <div key={step.id}>
                  <Card className="border-none shadow-sm hover:shadow-md transition-shadow">
                    <CardContent className="p-6">
                      <div className="flex gap-6">
                        <div className="flex-shrink-0">
                          <div className="w-12 h-12 bg-[#D85F00] text-white rounded-full flex items-center justify-center text-xl font-bold">
                            {step.id}
                          </div>
                        </div>
                        <div className="flex-1">
                          <h3 className="text-xl font-bold text-gray-900 mb-2">{step.title}</h3>
                          <p className="text-gray-600">{step.description}</p>
                        </div>
                      </div>
                    </CardContent>
                  </Card>
                  {index < processSteps.length - 1 && (
                    <div className="flex justify-center my-2">
                      <div className="w-0.5 h-6 bg-gray-300"></div>
                    </div>
                  )}
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Equipe Section */}
      <section id="equipe" className="py-20 bg-white">
        <div className="container mx-auto px-6">
          <div className="text-center mb-12">
            <Badge className="mb-4 bg-gray-100 text-gray-700 hover:bg-gray-200 border-none">Equipe</Badge>
            <h2 className="text-4xl font-bold text-gray-900 mb-4">Liderança Experiente</h2>
            <p className="text-gray-600 max-w-2xl mx-auto">
              Engenheiros formados pela tradicional Faculdade de Engenharia de São Paulo
            </p>
          </div>

          <div className="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            {teamMembers.map((member) => (
              <Card key={member.id} className="border-none shadow-md hover:shadow-lg transition-shadow">
                <CardContent className="p-8 text-center">
                  <div className="w-32 h-32 mx-auto mb-6 rounded-full overflow-hidden border-4 border-gray-100">
                    <img 
                      src={member.image} 
                      alt={member.name}
                      className="w-full h-full object-cover"
                    />
                  </div>
                  <h3 className="text-2xl font-bold text-gray-900 mb-2">{member.name}</h3>
                  <p className="text-[#D85F00] font-medium mb-4">{member.role}</p>
                  <Separator className="my-4" />
                  <div className="text-left space-y-2">
                    {member.credentials.map((credential, index) => (
                      <div key={index} className="flex items-start gap-2">
                        <CheckCircle2 className="w-4 h-4 text-[#D85F00] mt-1 flex-shrink-0" />
                        <span className="text-sm text-gray-600">{credential}</span>
                      </div>
                    ))}
                  </div>
                </CardContent>
              </Card>
            ))}
          </div>
        </div>
      </section>

      {/* Depoimentos Section */}
      <section className="py-20 bg-gray-50">
        <div className="container mx-auto px-6">
          <div className="text-center mb-12">
            <Badge className="mb-4 bg-[#D85F00]/10 text-[#D85F00] hover:bg-[#D85F00]/20 border-none">Depoimentos</Badge>
            <h2 className="text-4xl font-bold text-gray-900 mb-4">O Que Dizem Nossos Clientes</h2>
          </div>

          <div className="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            {testimonials.map((testimonial) => (
              <Card key={testimonial.id} className="border-none shadow-sm hover:shadow-md transition-shadow">
                <CardContent className="p-8">
                  <div className="flex gap-1 mb-4">
                    {[...Array(testimonial.rating)].map((_, i) => (
                      <Star key={i} className="w-5 h-5 fill-[#D85F00] text-[#D85F00]" />
                    ))}
                  </div>
                  <p className="text-gray-700 mb-6 italic leading-relaxed">"{testimonial.content}"</p>
                  <div>
                    <div className="font-bold text-gray-900">{testimonial.name}</div>
                    <div className="text-sm text-gray-600">{testimonial.role}</div>
                    <div className="text-sm text-[#D85F00] mt-1">{testimonial.project}</div>
                  </div>
                </CardContent>
              </Card>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20 bg-gradient-to-br from-gray-900 to-gray-800 text-white">
        <div className="container mx-auto px-6 text-center">
          <h2 className="text-4xl font-bold mb-6">Pronto para Começar seu Projeto?</h2>
          <p className="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
            Entre em contato e descubra como podemos transformar seu projeto em patrimônio
          </p>
          <Button size="lg" className="bg-[#D85F00] hover:bg-[#B84F00] text-white px-8">
            <a href="#contato">Solicitar Orçamento</a>
          </Button>
        </div>
      </section>

      {/* Contato/Footer Section */}
      <footer id="contato" className="bg-gray-900 text-white py-16">
        <div className="container mx-auto px-6">
          <div className="grid md:grid-cols-3 gap-12 mb-12">
            <div>
              <div className="flex items-center space-x-2 mb-4">
                <Building2 className="w-8 h-8 text-[#D85F00]" />
                <div>
                  <h3 className="text-xl font-bold">{companyInfo.name}</h3>
                  <p className="text-sm text-gray-400">{companyInfo.tagline}</p>
                </div>
              </div>
              <p className="text-gray-400 leading-relaxed">
                {companyInfo.description}
              </p>
            </div>

            <div>
              <h4 className="text-lg font-bold mb-4">Links Rápidos</h4>
              <ul className="space-y-2">
                <li><a href="#sobre" className="text-gray-400 hover:text-[#D85F00] transition-colors">Sobre</a></li>
                <li><a href="#projetos" className="text-gray-400 hover:text-[#D85F00] transition-colors">Projetos</a></li>
                <li><a href="#servicos" className="text-gray-400 hover:text-[#D85F00] transition-colors">Serviços</a></li>
                <li><a href="#equipe" className="text-gray-400 hover:text-[#D85F00] transition-colors">Equipe</a></li>
              </ul>
            </div>

            <div>
              <h4 className="text-lg font-bold mb-4">Contato</h4>
              <ul className="space-y-3">
                <li className="flex items-start gap-3">
                  <MapPin className="w-5 h-5 text-[#D85F00] flex-shrink-0 mt-1" />
                  <span className="text-gray-400">
                    {companyInfo.contact.address}<br />
                    {companyInfo.contact.neighborhood}<br />
                    {companyInfo.contact.city} - CEP {companyInfo.contact.cep}
                  </span>
                </li>
                <li className="flex items-center gap-3">
                  <Phone className="w-5 h-5 text-[#D85F00]" />
                  <a href={`tel:${companyInfo.contact.phone}`} className="text-gray-400 hover:text-[#D85F00] transition-colors">
                    {companyInfo.contact.phone}
                  </a>
                </li>
                <li className="flex items-center gap-3">
                  <Mail className="w-5 h-5 text-[#D85F00]" />
                  <a href={`mailto:${companyInfo.contact.email}`} className="text-gray-400 hover:text-[#D85F00] transition-colors">
                    {companyInfo.contact.email}
                  </a>
                </li>
              </ul>
            </div>
          </div>

          <Separator className="bg-gray-800 mb-8" />

          <div className="text-center text-gray-400 text-sm">
            <p>© {new Date().getFullYear()} {companyInfo.name}. Todos os direitos reservados.</p>
            <p className="mt-2">Construtora de Alto Padrão | São Paulo, Brasil</p>
          </div>
        </div>
      </footer>
    </div>
  );
};

export default Home;