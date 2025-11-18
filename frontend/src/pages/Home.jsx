import React, { useState, useEffect } from 'react';
import { Button } from '../components/ui/button';
import { Card, CardContent } from '../components/ui/card';
import { Badge } from '../components/ui/badge';
import { Separator } from '../components/ui/separator';
import { 
  ArrowRight, 
  Phone, 
  Mail, 
  MapPin, 
  Menu, 
  X,
  CheckCircle2,
  Star
} from 'lucide-react';
import { 
  companyInfo, 
  projects, 
  services, 
  stats, 
  teamMembers, 
  specializations,
  processSteps,
  testimonials,
  processImages
} from '../mockData';

const Home = () => {
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [activeProject, setActiveProject] = useState(0);
  const [scrollY, setScrollY] = useState(0);
  const [selectedCategory, setSelectedCategory] = useState('Todos');

  useEffect(() => {
    const handleScroll = () => setScrollY(window.scrollY);
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  // Auto-rotate hero images
  useEffect(() => {
    const interval = setInterval(() => {
      setActiveProject((prev) => (prev + 1) % projects.filter(p => p.featured).length);
    }, 5000);
    return () => clearInterval(interval);
  }, []);

  const featuredProjects = projects.filter(p => p.featured);
  const categories = ['Todos', 'Residencial', 'Comercial', 'Corporativo'];
  
  const filteredProjects = selectedCategory === 'Todos' 
    ? featuredProjects
    : featuredProjects.filter(p => p.category === selectedCategory);

  return (
    <div className="min-h-screen bg-white">
      {/* Header */}
      <header className={`fixed top-0 w-full z-50 transition-all duration-300 ${
        scrollY > 50 ? 'bg-white shadow-sm' : 'bg-transparent'
      }`}>
        <div className="container mx-auto px-6 py-5">
          <div className="flex items-center justify-between">
            <div>
              <h1 className={`text-2xl font-bold tracking-tight transition-colors ${
                scrollY > 50 ? 'text-gray-900' : 'text-white'
              }`}>
                {companyInfo.name}
              </h1>
              <p className={`text-xs transition-colors ${
                scrollY > 50 ? 'text-gray-600' : 'text-white/90'
              }`}>
                {companyInfo.tagline}
              </p>
            </div>
            <nav className="hidden md:flex items-center space-x-8">
              <a href="#sobre" className={`text-sm font-medium transition-colors ${
                scrollY > 50 ? 'text-gray-700 hover:text-[#C87533]' : 'text-white hover:text-white/80'
              }`}>Sobre</a>
              <a href="#projetos" className={`text-sm font-medium transition-colors ${
                scrollY > 50 ? 'text-gray-700 hover:text-[#C87533]' : 'text-white hover:text-white/80'
              }`}>Projetos</a>
              <a href="#servicos" className={`text-sm font-medium transition-colors ${
                scrollY > 50 ? 'text-gray-700 hover:text-[#C87533]' : 'text-white hover:text-white/80'
              }`}>Serviços</a>
              <a href="#equipe" className={`text-sm font-medium transition-colors ${
                scrollY > 50 ? 'text-gray-700 hover:text-[#C87533]' : 'text-white hover:text-white/80'
              }`}>Equipe</a>
              <Button className="bg-[#C87533] hover:bg-[#B06429] text-white">
                <a href="#contato">Contato</a>
              </Button>
            </nav>
            <button 
              className={`md:hidden transition-colors ${
                scrollY > 50 ? 'text-gray-900' : 'text-white'
              }`}
              onClick={() => setIsMenuOpen(!isMenuOpen)}
            >
              {isMenuOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
            </button>
          </div>
        </div>
      </header>

      {/* Mobile Menu */}
      {isMenuOpen && (
        <div className="fixed inset-0 z-40 bg-white md:hidden pt-24">
          <nav className="flex flex-col items-center space-y-8 py-12">
            <a href="#sobre" className="text-xl text-gray-900" onClick={() => setIsMenuOpen(false)}>Sobre</a>
            <a href="#projetos" className="text-xl text-gray-900" onClick={() => setIsMenuOpen(false)}>Projetos</a>
            <a href="#servicos" className="text-xl text-gray-900" onClick={() => setIsMenuOpen(false)}>Serviços</a>
            <a href="#equipe" className="text-xl text-gray-900" onClick={() => setIsMenuOpen(false)}>Equipe</a>
            <a href="#contato" className="text-xl text-gray-900" onClick={() => setIsMenuOpen(false)}>Contato</a>
          </nav>
        </div>
      )}

      {/* Hero Section */}
      <section className="relative h-screen flex items-center justify-center overflow-hidden">
        <div 
          className="absolute inset-0 bg-cover bg-center transition-all duration-1000"
          style={{
            backgroundImage: `url('${featuredProjects[activeProject].image}')`,
            transform: `scale(${1 + scrollY * 0.0003})`
          }}
        >
          <div className="absolute inset-0 bg-gradient-to-b from-black/60 via-black/50 to-black/70"></div>
        </div>
        
        <div className="relative z-10 text-center text-white px-6 max-w-5xl">
          <Badge className="mb-6 bg-[#C87533]/90 text-white hover:bg-[#C87533] border-none px-4 py-2">
            Fundada em {companyInfo.foundedYear}
          </Badge>
          <h1 className="text-5xl md:text-7xl font-bold mb-6 leading-tight">
            {companyInfo.hero.title}
          </h1>
          <p className="text-lg md:text-xl mb-10 max-w-3xl mx-auto leading-relaxed">
            {companyInfo.hero.description}
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Button 
              size="lg" 
              className="bg-[#C87533] hover:bg-[#B06429] text-white px-8"
            >
              <a href="#projetos" className="flex items-center gap-2">
                Ver Projetos <ArrowRight className="w-5 h-5" />
              </a>
            </Button>
            <Button 
              size="lg" 
              variant="outline" 
              className="border-white text-white hover:bg-white hover:text-gray-900 px-8"
            >
              <a href="#contato">Solicitar Orçamento</a>
            </Button>
          </div>
        </div>

        {/* Project Navigation Dots */}
        <div className="absolute bottom-12 left-1/2 transform -translate-x-1/2 flex gap-3 z-20">
          {featuredProjects.map((_, index) => (
            <button
              key={index}
              onClick={() => setActiveProject(index)}
              className={`h-2 rounded-full transition-all duration-300 ${
                activeProject === index ? 'bg-[#C87533] w-8' : 'bg-white/60 hover:bg-white/90 w-2'
              }`}
            />
          ))}
        </div>
      </section>

      {/* Stats */}
      <section className="border-y border-gray-200 bg-white">
        <div className="container mx-auto px-6 py-16">
          <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
            {stats.map((stat, index) => (
              <div key={index} className="text-center">
                <div className="text-5xl font-bold text-[#C87533] mb-2">{stat.value}</div>
                <div className="text-sm text-gray-600 uppercase tracking-wider">{stat.label}</div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Sobre Section */}
      <section id="sobre" className="py-24 bg-gray-50">
        <div className="container mx-auto px-6">
          <div className="max-w-6xl mx-auto">
            <div className="grid md:grid-cols-2 gap-16 items-center mb-20">
              <div>
                <Badge className="mb-4 bg-[#C87533]/10 text-[#C87533] hover:bg-[#C87533]/20 border-none">Quem Somos</Badge>
                <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                  Tradição e Inovação
                </h2>
                <p className="text-gray-600 mb-6 leading-relaxed text-lg">
                  {companyInfo.philosophy}
                </p>
                <p className="text-gray-600 leading-relaxed text-lg">
                  {companyInfo.approach}
                </p>
              </div>
              <div className="relative">
                <div className="aspect-[4/3] rounded-lg overflow-hidden shadow-xl">
                  <img 
                    src="https://images.unsplash.com/photo-1599995903128-531fc7fb694b"
                    alt="Construção"
                    className="w-full h-full object-cover"
                  />
                </div>
              </div>
            </div>

            {/* Especializações */}
            <div className="grid md:grid-cols-2 gap-6">
              {specializations.slice(0, 6).map((spec, index) => (
                <div key={index} className="flex items-start gap-3">
                  <CheckCircle2 className="w-5 h-5 text-[#C87533] flex-shrink-0 mt-1" />
                  <span className="text-gray-700">{spec}</span>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Excellence Section */}
      <section className="py-24 bg-white">
        <div className="container mx-auto px-6">
          <div className="max-w-4xl mx-auto text-center">
            <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
              {companyInfo.excellence.title}
            </h2>
            <p className="text-xl text-gray-600 leading-relaxed mb-8">
              {companyInfo.excellence.description}
            </p>
            <p className="text-lg text-gray-700 italic">
              {companyInfo.vision}
            </p>
          </div>
        </div>
      </section>

      {/* Projetos Section */}
      <section id="projetos" className="py-24 bg-gray-50">
        <div className="container mx-auto px-6">
          <div className="mb-16 text-center">
            <Badge className="mb-4 bg-[#C87533]/10 text-[#C87533] hover:bg-[#C87533]/20 border-none">Portfólio</Badge>
            <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Projetos em Destaque</h2>
            <p className="text-xl text-gray-600 max-w-2xl mx-auto">
              Obras com arquitetura autoral e alto padrão construtivo
            </p>
          </div>

          {/* Category Filter */}
          <div className="flex justify-center gap-3 mb-16 flex-wrap">
            {categories.map((category) => (
              <Button
                key={category}
                variant={selectedCategory === category ? "default" : "outline"}
                onClick={() => setSelectedCategory(category)}
                className={selectedCategory === category 
                  ? "bg-[#C87533] hover:bg-[#B06429] text-white" 
                  : "border-gray-300 hover:bg-gray-100"}
              >
                {category}
              </Button>
            ))}
          </div>

          <div className="max-w-7xl mx-auto space-y-20">
            {filteredProjects.map((project, index) => (
              <div key={project.id} className="grid md:grid-cols-2 gap-8 items-center">
                <div className={index % 2 === 0 ? 'order-1' : 'order-2'}>
                  <div className="relative aspect-[4/3] overflow-hidden rounded-lg shadow-xl">
                    <img 
                      src={project.image}
                      alt={project.title}
                      className="w-full h-full object-cover hover:scale-105 transition-transform duration-700"
                    />
                  </div>
                </div>
                <div className={index % 2 === 0 ? 'order-2' : 'order-1'}>
                  <Badge className="mb-3 bg-gray-100 text-gray-700 hover:bg-gray-200 border-none">
                    {project.category}
                  </Badge>
                  <h3 className="text-3xl font-bold text-gray-900 mb-4">{project.title}</h3>
                  <p className="text-gray-600 mb-6 leading-relaxed">{project.description}</p>
                  <div className="space-y-2 text-gray-700">
                    <div className="flex items-center gap-2">
                      <span className="font-medium text-sm">Arquiteto:</span>
                      <span>{project.architect}</span>
                    </div>
                    <div className="flex items-center gap-2">
                      <span className="font-medium text-sm">Localização:</span>
                      <span>{project.location}</span>
                    </div>
                    <div className="flex items-center gap-2">
                      <span className="font-medium text-sm">Área:</span>
                      <span>{project.area}</span>
                    </div>
                    <div className="flex items-center gap-2">
                      <span className="font-medium text-sm">Ano:</span>
                      <span>{project.year}</span>
                    </div>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Processo Section */}
      <section className="py-24 bg-white">
        <div className="container mx-auto px-6">
          <div className="max-w-5xl mx-auto">
            <div className="text-center mb-16">
              <Badge className="mb-4 bg-gray-100 text-gray-700 hover:bg-gray-200 border-none">Metodologia</Badge>
              <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Nosso Processo</h2>
              <p className="text-xl text-gray-600">
                {companyInfo.mission}
              </p>
            </div>

            <div className="grid md:grid-cols-2 gap-8">
              {processSteps.map((step) => (
                <Card key={step.id} className="border-none shadow-sm hover:shadow-md transition-shadow">
                  <CardContent className="p-8">
                    <div className="flex gap-4">
                      <div className="flex-shrink-0">
                        <div className="w-12 h-12 bg-[#C87533] text-white rounded-full flex items-center justify-center font-bold">
                          {step.number}
                        </div>
                      </div>
                      <div>
                        <h3 className="text-xl font-bold text-gray-900 mb-3">{step.title}</h3>
                        <p className="text-gray-600 leading-relaxed">{step.description}</p>
                      </div>
                    </div>
                  </CardContent>
                </Card>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Construction Process Images */}
      <section className="py-20 bg-gray-50">
        <div className="container mx-auto px-6">
          <div className="grid md:grid-cols-3 gap-4">
            {processImages.map((image, index) => (
              <div key={index} className="relative aspect-square overflow-hidden bg-gray-200 rounded-lg">
                <img 
                  src={image}
                  alt={`Processo ${index + 1}`}
                  className="w-full h-full object-cover hover:scale-105 transition-transform duration-700"
                />
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Serviços Section */}
      <section id="servicos" className="py-24 bg-white">
        <div className="container mx-auto px-6">
          <div className="max-w-6xl mx-auto">
            <div className="text-center mb-16">
              <Badge className="mb-4 bg-[#C87533]/10 text-[#C87533] hover:bg-[#C87533]/20 border-none">Serviços</Badge>
              <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-4">O Que Fazemos</h2>
            </div>

            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
              {services.map((service) => (
                <Card key={service.id} className="border-none shadow-sm hover:shadow-md transition-shadow bg-white">
                  <CardContent className="p-8">
                    <h3 className="text-xl font-bold text-gray-900 mb-3">{service.title}</h3>
                    <p className="text-gray-600 leading-relaxed">{service.description}</p>
                  </CardContent>
                </Card>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Equipe Section */}
      <section id="equipe" className="py-24 bg-gray-50">
        <div className="container mx-auto px-6">
          <div className="max-w-6xl mx-auto">
            <div className="text-center mb-16">
              <Badge className="mb-4 bg-gray-100 text-gray-700 hover:bg-gray-200 border-none">Equipe</Badge>
              <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Liderança</h2>
              <p className="text-xl text-gray-600">
                Engenheiros formados pela tradicional Faculdade de Engenharia de São Paulo
              </p>
            </div>

            <div className="grid md:grid-cols-2 gap-12">
              {teamMembers.map((member) => (
                <Card key={member.id} className="border-none shadow-md hover:shadow-lg transition-shadow">
                  <CardContent className="p-10 text-center">
                    <div className="w-32 h-32 mx-auto mb-6 rounded-full overflow-hidden border-4 border-[#C87533]/20">
                      <img 
                        src={member.image}
                        alt={member.name}
                        className="w-full h-full object-cover"
                      />
                    </div>
                    <h3 className="text-2xl font-bold text-gray-900 mb-2">{member.name}</h3>
                    <p className="text-[#C87533] font-medium mb-6">{member.role}</p>
                    <Separator className="my-6" />
                    <div className="text-left space-y-3">
                      {member.credentials.map((credential, index) => (
                        <div key={index} className="flex items-start gap-3">
                          <CheckCircle2 className="w-4 h-4 text-[#C87533] mt-1 flex-shrink-0" />
                          <span className="text-sm text-gray-600">{credential}</span>
                        </div>
                      ))}
                    </div>
                  </CardContent>
                </Card>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Depoimentos Section */}
      <section className="py-24 bg-white">
        <div className="container mx-auto px-6">
          <div className="max-w-6xl mx-auto">
            <div className="text-center mb-16">
              <Badge className="mb-4 bg-[#C87533]/10 text-[#C87533] hover:bg-[#C87533]/20 border-none">Depoimentos</Badge>
              <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-4">O Que Dizem</h2>
            </div>

            <div className="grid md:grid-cols-3 gap-8">
              {testimonials.map((testimonial) => (
                <Card key={testimonial.id} className="border-none shadow-sm hover:shadow-md transition-shadow bg-white">
                  <CardContent className="p-8">
                    <div className="flex gap-1 mb-4">
                      {[...Array(testimonial.rating)].map((_, i) => (
                        <Star key={i} className="w-5 h-5 fill-[#C87533] text-[#C87533]" />
                      ))}
                    </div>
                    <p className="text-gray-700 mb-6 italic leading-relaxed">"{testimonial.content}"</p>
                    <div>
                      <div className="font-bold text-gray-900">{testimonial.name}</div>
                      <div className="text-sm text-gray-600">{testimonial.role}</div>
                      <div className="text-sm text-[#C87533] mt-1">{testimonial.project}</div>
                    </div>
                  </CardContent>
                </Card>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-24 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white">
        <div className="container mx-auto px-6 text-center">
          <h2 className="text-4xl md:text-5xl font-bold mb-6">Pronto para Começar?</h2>
          <p className="text-xl text-gray-300 mb-10 max-w-2xl mx-auto">
            Entre em contato e descubra como podemos transformar seu projeto em patrimônio
          </p>
          <Button size="lg" className="bg-[#C87533] hover:bg-[#B06429] text-white px-8 py-6 text-base">
            <a href="#contato">Solicitar Orçamento</a>
          </Button>
        </div>
      </section>

      {/* Footer */}
      <footer id="contato" className="bg-gray-900 text-white py-16">
        <div className="container mx-auto px-6">
          <div className="grid md:grid-cols-3 gap-12 mb-12">
            <div>
              <h3 className="text-2xl font-bold mb-4">{companyInfo.name}</h3>
              <p className="text-gray-400 mb-4">{companyInfo.tagline}</p>
              <p className="text-gray-400 text-sm leading-relaxed">
                {companyInfo.hero.description}
              </p>
            </div>

            <div>
              <h4 className="text-lg font-bold mb-4">Links</h4>
              <ul className="space-y-2">
                <li><a href="#sobre" className="text-gray-400 hover:text-[#C87533] transition-colors">Sobre</a></li>
                <li><a href="#projetos" className="text-gray-400 hover:text-[#C87533] transition-colors">Projetos</a></li>
                <li><a href="#servicos" className="text-gray-400 hover:text-[#C87533] transition-colors">Serviços</a></li>
                <li><a href="#equipe" className="text-gray-400 hover:text-[#C87533] transition-colors">Equipe</a></li>
              </ul>
            </div>

            <div>
              <h4 className="text-lg font-bold mb-4">Contato</h4>
              <ul className="space-y-3">
                <li className="flex items-start gap-3">
                  <MapPin className="w-5 h-5 text-[#C87533] flex-shrink-0 mt-1" />
                  <span className="text-gray-400 text-sm">
                    {companyInfo.contact.address}<br />
                    {companyInfo.contact.neighborhood}<br />
                    {companyInfo.contact.city} - {companyInfo.contact.cep}
                  </span>
                </li>
                <li className="flex items-center gap-3">
                  <Phone className="w-5 h-5 text-[#C87533]" />
                  <a href={`tel:${companyInfo.contact.phone}`} className="text-gray-400 hover:text-[#C87533] transition-colors text-sm">
                    {companyInfo.contact.phone}
                  </a>
                </li>
                <li className="flex items-center gap-3">
                  <Mail className="w-5 h-5 text-[#C87533]" />
                  <a href={`mailto:${companyInfo.contact.email}`} className="text-gray-400 hover:text-[#C87533] transition-colors text-sm">
                    {companyInfo.contact.email}
                  </a>
                </li>
              </ul>
            </div>
          </div>

          <Separator className="bg-gray-800 mb-8" />

          <div className="text-center text-gray-400 text-sm">
            <p>© {new Date().getFullYear()} {companyInfo.name}. Todos os direitos reservados.</p>
          </div>
        </div>
      </footer>
    </div>
  );
};

export default Home;