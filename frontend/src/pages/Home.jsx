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
  Heart,
  Star,
  Sparkles,
  ChevronDown,
  ChevronUp
} from 'lucide-react';
import { 
  companyInfo, 
  projects, 
  services, 
  stats, 
  teamMembers,
  processSteps,
  testimonials,
  processImages,
  whyMudare,
  faq
} from '../mockData';

const Home = () => {
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [activeProject, setActiveProject] = useState(0);
  const [scrollY, setScrollY] = useState(0);
  const [selectedCategory, setSelectedCategory] = useState('Todos');
  const [openFaqId, setOpenFaqId] = useState(null);

  useEffect(() => {
    const handleScroll = () => setScrollY(window.scrollY);
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  useEffect(() => {
    const interval = setInterval(() => {
      setActiveProject((prev) => (prev + 1) % projects.filter(p => p.featured).length);
    }, 6000);
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
        <div className="container mx-auto px-6 py-4">
          <div className="flex items-center justify-between">
            <div className="flex items-center">
              <img 
                src="/logo-mudare.png" 
                alt="MUDARE Construtora de Alto Padrão São Paulo" 
                className="h-12 w-auto"
              />
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
              <a href="#faq" className={`text-sm font-medium transition-colors ${
                scrollY > 50 ? 'text-gray-700 hover:text-[#C87533]' : 'text-white hover:text-white/80'
              }`}>FAQ</a>
              <Button className="bg-[#C87533] hover:bg-[#B06429] text-white">
                <a href="#contato">Vamos Conversar</a>
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
            <a href="#faq" className="text-xl text-gray-900" onClick={() => setIsMenuOpen(false)}>FAQ</a>
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
          <div className="absolute inset-0 bg-gradient-to-b from-black/70 via-black/60 to-black/80"></div>
        </div>
        
        <div className="relative z-10 text-center text-white px-6 max-w-5xl">
          <Badge className="mb-6 bg-[#C87533]/90 text-white hover:bg-[#C87533] border-none px-4 py-2 text-sm">
            Construtora de Alto Padrão São Paulo - Desde {companyInfo.foundedYear}
          </Badge>
          <h1 className="text-5xl md:text-7xl font-bold mb-4 leading-tight">
            {companyInfo.hero.title}
          </h1>
          <h2 className="text-4xl md:text-5xl font-bold mb-6 text-[#C87533]">
            {companyInfo.hero.subtitle}
          </h2>
          <p className="text-lg md:text-xl mb-8 max-w-3xl mx-auto leading-relaxed">
            {companyInfo.hero.description}
          </p>
          <p className="text-2xl md:text-3xl font-light italic mb-12 text-[#C87533]">
            {companyInfo.slogan}
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Button 
              size="lg" 
              className="bg-[#C87533] hover:bg-[#B06429] text-white px-8 py-6 text-base"
            >
              <a href="#projetos" className="flex items-center gap-2">
                Ver Nossos Projetos <ArrowRight className="w-5 h-5" />
              </a>
            </Button>
            <Button 
              size="lg" 
              variant="outline" 
              className="border-white text-white hover:bg-white hover:text-gray-900 px-8 py-6 text-base"
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
              aria-label={`Ver projeto ${index + 1}`}
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
                <div className="text-sm text-gray-600">{stat.label}</div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Service Areas */}
      <section className="py-12 bg-gray-50">
        <div className="container mx-auto px-6">
          <div className="text-center">
            <p className="text-gray-600 mb-3">Atendemos as principais regiões de São Paulo:</p>
            <div className="flex flex-wrap justify-center gap-3">
              {companyInfo.serviceAreas.map((area, index) => (
                <Badge key={index} variant="outline" className="border-[#C87533] text-[#C87533]">
                  {area}
                </Badge>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Manifesto Section */}
      <section className="py-24 bg-white">
        <div className="container mx-auto px-6">
          <div className="max-w-4xl mx-auto text-center">
            <Sparkles className="w-12 h-12 text-[#C87533] mx-auto mb-6" />
            <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-8">
              O Que Nos Move
            </h2>
            <p className="text-xl text-gray-700 leading-relaxed mb-8">
              {companyInfo.manifesto}
            </p>
            <p className="text-2xl font-bold text-[#C87533] italic">
              {companyInfo.slogan}
            </p>
          </div>
        </div>
      </section>

      {/* Sobre Section */}
      <section id="sobre" className="py-24 bg-gray-50">
        <div className="container mx-auto px-6">
          <div className="max-w-6xl mx-auto">
            <div className="grid md:grid-cols-2 gap-16 items-center mb-20">
              <div>
                <Badge className="mb-4 bg-[#C87533]/10 text-[#C87533] hover:bg-[#C87533]/20 border-none">Nossa História</Badge>
                <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                  Tradição Que Inova.
                  <br />
                  Inovação Que Respeita.
                </h2>
                <p className="text-gray-600 mb-6 leading-relaxed text-lg">
                  {companyInfo.philosophy}
                </p>
                <p className="text-gray-600 mb-8 leading-relaxed text-lg">
                  {companyInfo.approach}
                </p>
                <div className="grid grid-cols-2 gap-4">
                  {whyMudare.map((item, index) => (
                    <div key={index} className="p-4 bg-white rounded-lg shadow-sm">
                      <h4 className="font-bold text-[#C87533] mb-2">{item.title}</h4>
                      <p className="text-sm text-gray-600">{item.description}</p>
                    </div>
                  ))}
                </div>
              </div>
              <div className="relative">
                <div className="aspect-[4/3] rounded-lg overflow-hidden shadow-xl">
                  <img 
                    src="https://images.unsplash.com/photo-1599995903128-531fc7fb694b"
                    alt="Obra de alto padrão MUDARE Construtora São Paulo"
                    className="w-full h-full object-cover"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Excellence Section */}
      <section className="py-24 bg-gradient-to-br from-gray-900 to-gray-800 text-white">
        <div className="container mx-auto px-6">
          <div className="max-w-4xl mx-auto text-center">
            <h2 className="text-4xl md:text-5xl font-bold mb-3">
              {companyInfo.excellence.title}
            </h2>
            <h3 className="text-3xl md:text-4xl font-light text-[#C87533] mb-8">
              {companyInfo.excellence.subtitle}
            </h3>
            <p className="text-xl leading-relaxed mb-8">
              {companyInfo.excellence.description}
            </p>
            <p className="text-lg italic text-gray-300">
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
              Obras residenciais, comerciais e corporativas de alto padrão em São Paulo
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
                  <div className="relative aspect-[4/3] overflow-hidden rounded-lg shadow-xl group">
                    <img 
                      src={project.image}
                      alt={project.seoAlt}
                      className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                      loading="lazy"
                    />
                    <div className="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300" />
                  </div>
                </div>
                <div className={index % 2 === 0 ? 'order-2' : 'order-1'}>
                  <Badge className="mb-3 bg-gray-100 text-gray-700 hover:bg-gray-200 border-none">
                    {project.category}
                  </Badge>
                  <h3 className="text-3xl font-bold text-gray-900 mb-4">{project.title}</h3>
                  <p className="text-gray-600 mb-4 leading-relaxed text-lg">{project.description}</p>
                  <p className="text-gray-500 mb-6 italic leading-relaxed">{project.story}</p>
                  <div className="space-y-2 text-gray-700 text-sm">
                    <div className="flex items-center gap-2">
                      <span className="font-medium">Arquiteto:</span>
                      <span>{project.architect}</span>
                    </div>
                    <div className="flex items-center gap-2">
                      <span className="font-medium">Localização:</span>
                      <span>{project.location}</span>
                    </div>
                    <div className="flex items-center gap-2">
                      <span className="font-medium">Área:</span>
                      <span>{project.area}</span>
                    </div>
                    <div className="flex items-center gap-2">
                      <span className="font-medium">Ano:</span>
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
              <Badge className="mb-4 bg-gray-100 text-gray-700 hover:bg-gray-200 border-none">Nosso Processo</Badge>
              <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Do Sonho à Realidade</h2>
              <p className="text-xl text-gray-600">
                {companyInfo.mission}
              </p>
            </div>

            <div className="space-y-8">
              {processSteps.map((step, index) => (
                <div key={step.id}>
                  <Card className="border-none shadow-sm hover:shadow-lg transition-all duration-300">
                    <CardContent className="p-8">
                      <div className="flex gap-6">
                        <div className="flex-shrink-0">
                          <div className="w-16 h-16 bg-[#C87533] text-white rounded-full flex items-center justify-center text-xl font-bold">
                            {step.number}
                          </div>
                        </div>
                        <div className="flex-1">
                          <h3 className="text-2xl font-bold text-gray-900 mb-1">{step.title}</h3>
                          <p className="text-[#C87533] font-medium mb-3">{step.subtitle}</p>
                          <p className="text-gray-700 leading-relaxed mb-2">{step.description}</p>
                          <p className="text-sm text-gray-500 italic">{step.technical}</p>
                        </div>
                      </div>
                    </CardContent>
                  </Card>
                  {index < processSteps.length - 1 && (
                    <div className="flex justify-center my-4">
                      <ArrowRight className="w-6 h-6 text-[#C87533] rotate-90" />
                    </div>
                  )}
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Process Images */}
      <section className="py-20 bg-gray-50">
        <div className="container mx-auto px-6">
          <div className="grid md:grid-cols-3 gap-4">
            {processImages.map((image, index) => (
              <div key={index} className="relative aspect-square overflow-hidden bg-gray-200 rounded-lg group">
                <img 
                  src={image}
                  alt={`Obra de alto padrão MUDARE - Processo ${index + 1}`}
                  className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                  loading="lazy"
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
              <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Como Podemos Ajudar</h2>
              <p className="text-xl text-gray-600">Soluções completas em construção de alto padrão</p>
            </div>

            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
              {services.map((service) => (
                <Card key={service.id} className="border-none shadow-sm hover:shadow-lg transition-all duration-300 group">
                  <CardContent className="p-8">
                    <h3 className="text-xl font-bold text-gray-900 mb-2">{service.title}</h3>
                    <p className="text-[#C87533] font-medium text-sm mb-4">{service.tagline}</p>
                    <p className="text-gray-600 leading-relaxed mb-4">{service.description}</p>
                    <p className="text-sm text-gray-500 italic">{service.emotional}</p>
                  </CardContent>
                </Card>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* FAQ Section */}
      <section id="faq" className="py-24 bg-gray-50">
        <div className="container mx-auto px-6">
          <div className="max-w-4xl mx-auto">
            <div className="text-center mb-16">
              <Badge className="mb-4 bg-[#C87533]/10 text-[#C87533] hover:bg-[#C87533]/20 border-none">Dúvidas Frequentes</Badge>
              <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Perguntas e Respostas</h2>
              <p className="text-xl text-gray-600">Tudo o que você precisa saber sobre construção de alto padrão</p>
            </div>

            <div className="space-y-4">
              {faq.map((item) => (
                <Card key={item.id} className="border-none shadow-sm hover:shadow-md transition-shadow">
                  <CardContent className="p-0">
                    <button
                      onClick={() => setOpenFaqId(openFaqId === item.id ? null : item.id)}
                      className="w-full p-6 text-left flex items-center justify-between gap-4 hover:bg-gray-50 transition-colors"
                    >
                      <h3 className="text-lg font-bold text-gray-900">{item.question}</h3>
                      {openFaqId === item.id ? (
                        <ChevronUp className="w-5 h-5 text-[#C87533] flex-shrink-0" />
                      ) : (
                        <ChevronDown className="w-5 h-5 text-gray-400 flex-shrink-0" />
                      )}
                    </button>
                    {openFaqId === item.id && (
                      <div className="px-6 pb-6">
                        <p className="text-gray-600 leading-relaxed">{item.answer}</p>
                      </div>
                    )}
                  </CardContent>
                </Card>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Equipe Section */}
      <section id="equipe" className="py-24 bg-white">
        <div className="container mx-auto px-6">
          <div className="max-w-6xl mx-auto">
            <div className="text-center mb-16">
              <Badge className="mb-4 bg-gray-100 text-gray-700 hover:bg-gray-200 border-none">Liderança</Badge>
              <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Quem Faz Acontecer</h2>
              <p className="text-xl text-gray-600">
                Engenheiros apaixonados pela arte de construir
              </p>
            </div>

            <div className="grid md:grid-cols-2 gap-12">
              {teamMembers.map((member) => (
                <Card key={member.id} className="border-none shadow-md hover:shadow-xl transition-all duration-300">
                  <CardContent className="p-10 text-center">
                    <div className="w-32 h-32 mx-auto mb-6 rounded-full overflow-hidden border-4 border-[#C87533]/20">
                      <img 
                        src={member.image}
                        alt={`${member.name} - ${member.role} MUDARE Construtora`}
                        className="w-full h-full object-cover"
                        loading="lazy"
                      />
                    </div>
                    <h3 className="text-2xl font-bold text-gray-900 mb-2">{member.name}</h3>
                    <p className="text-[#C87533] font-medium mb-4">{member.role}</p>
                    <p className="text-gray-600 italic mb-6">{member.bio}</p>
                    <Separator className="my-6" />
                    <div className="text-left space-y-3">
                      {member.credentials.map((credential, index) => (
                        <div key={index} className="flex items-start gap-3">
                          <Heart className="w-4 h-4 text-[#C87533] mt-1 flex-shrink-0" />
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
      <section className="py-24 bg-gray-50">
        <div className="container mx-auto px-6">
          <div className="max-w-6xl mx-auto">
            <div className="text-center mb-16">
              <Badge className="mb-4 bg-[#C87533]/10 text-[#C87533] hover:bg-[#C87533]/20 border-none">Depoimentos</Badge>
              <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Quem Confia, Recomenda</h2>
              <p className="text-xl text-gray-600">Construtora recomendada por arquitetos e clientes exigentes</p>
            </div>

            <div className="grid md:grid-cols-3 gap-8">
              {testimonials.map((testimonial) => (
                <Card key={testimonial.id} className="border-none shadow-md hover:shadow-xl transition-all duration-300">
                  <CardContent className="p-8">
                    <div className="flex gap-1 mb-4">
                      {[...Array(testimonial.rating)].map((_, i) => (
                        <Star key={i} className="w-5 h-5 fill-[#C87533] text-[#C87533]" />
                      ))}
                    </div>
                    <p className="text-gray-700 mb-6 leading-relaxed">"{testimonial.content}"</p>
                    <div>
                      <div className="font-bold text-gray-900">{testimonial.name}</div>
                      <div className="text-sm text-gray-600">{testimonial.role}</div>
                      <div className="text-sm text-[#C87533] mt-1 font-medium">{testimonial.project}</div>
                    </div>
                  </CardContent>
                </Card>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-32 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white relative overflow-hidden">
        <div className="absolute inset-0 opacity-10">
          <div className="absolute inset-0" style={{
            backgroundImage: 'url("data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23C87533" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")',
          }} />
        </div>
        <div className="container mx-auto px-6 text-center relative z-10">
          <h2 className="text-5xl md:text-6xl font-bold mb-6">Pronto Para Construir Seu Sonho?</h2>
          <p className="text-2xl md:text-3xl font-light text-[#C87533] mb-8">
            {companyInfo.slogan}
          </p>
          <p className="text-xl text-gray-300 mb-12 max-w-2xl mx-auto">
            Construtora de alto padrão em São Paulo. Vamos transformar seu projeto em realidade.
          </p>
          <Button size="lg" className="bg-[#C87533] hover:bg-[#B06429] text-white px-10 py-7 text-lg">
            <a href="#contato" className="flex items-center gap-2">
              <Heart className="w-6 h-6" />
              Solicitar Orçamento Agora
            </a>
          </Button>
        </div>
      </section>

      {/* Footer */}
      <footer id="contato" className="bg-gray-900 text-white py-16">
        <div className="container mx-auto px-6">
          <div className="grid md:grid-cols-3 gap-12 mb-12">
            <div>
              <img src="/logo-mudare.png" alt="MUDARE Construtora" className="h-12 mb-4" />
              <p className="text-[#C87533] italic mb-4">{companyInfo.slogan}</p>
              <p className="text-gray-400 text-sm leading-relaxed">
                Construtora de alto padrão em São Paulo. Especializada em construção residencial, reforma comercial e obras corporativas.
              </p>
            </div>

            <div>
              <h4 className="text-lg font-bold mb-4">Links Rápidos</h4>
              <ul className="space-y-2">
                <li><a href="#sobre" className="text-gray-400 hover:text-[#C87533] transition-colors">Sobre</a></li>
                <li><a href="#projetos" className="text-gray-400 hover:text-[#C87533] transition-colors">Projetos</a></li>
                <li><a href="#servicos" className="text-gray-400 hover:text-[#C87533] transition-colors">Serviços</a></li>
                <li><a href="#faq" className="text-gray-400 hover:text-[#C87533] transition-colors">FAQ</a></li>
              </ul>
            </div>

            <div>
              <h4 className="text-lg font-bold mb-4">Fale Conosco</h4>
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
            <p className="mb-2">
              © {new Date().getFullYear()} MUDARE Construtora. Todos os direitos reservados.
            </p>
            <p className="text-xs mb-2">Construtora de Alto Padrão | São Paulo | Jardins | Alphaville | Cidade Jardim</p>
            <p className="text-[#C87533] italic">{companyInfo.slogan}</p>
          </div>
        </div>
      </footer>
    </div>
  );
};

export default Home;