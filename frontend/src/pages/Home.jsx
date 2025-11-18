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
  Star,
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
  faq,
  architects
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
                alt="MUDARE Construtora de Alto Padrão" 
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
              <a href="#arquitetos" className={`text-sm font-medium transition-colors ${
                scrollY > 50 ? 'text-gray-700 hover:text-[#C87533]' : 'text-white hover:text-white/80'
              }`}>Arquitetos</a>
              <Button 
                className="bg-[#C87533] hover:bg-[#B06429] text-white"
                onClick={() => window.location.href = `https://wa.me/551151961909?text=${encodeURIComponent('Olá! Gostaria de falar sobre um projeto.')}`}
              >
                Contato
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
            <a href="#arquitetos" className="text-xl text-gray-900" onClick={() => setIsMenuOpen(false)}>Arquitetos</a>
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
          <h1 className="text-5xl md:text-7xl font-bold mb-4 leading-tight">
            {companyInfo.hero.title}
          </h1>
          <h2 className="text-4xl md:text-5xl font-bold mb-6 text-[#C87533]">
            {companyInfo.hero.subtitle}
          </h2>
          <p className="text-lg md:text-xl mb-10 max-w-3xl mx-auto leading-relaxed">
            {companyInfo.hero.description}
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Button 
              size="lg" 
              className="bg-[#C87533] hover:bg-[#B06429] text-white px-8 py-6 text-base"
            >
              <a href="#projetos" className="flex items-center gap-2">
                Ver Projetos <ArrowRight className="w-5 h-5" />
              </a>
            </Button>
            <Button 
              size="lg" 
              variant="outline" 
              className="border-white text-white hover:bg-white hover:text-gray-900 px-8 py-6 text-base"
              onClick={() => window.location.href = `https://wa.me/551151961909?text=${encodeURIComponent('Olá! Gostaria de falar sobre um projeto.')}`}
            >
              Fale Conosco
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
                <div className="text-sm text-gray-600 uppercase tracking-wider">{stat.label}</div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Manifesto Section */}
      <section className="py-24 bg-gray-50">
        <div className="container mx-auto px-6">
          <div className="max-w-4xl mx-auto text-center">
            <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-8">
              Filosofia
            </h2>
            <p className="text-xl text-gray-700 leading-relaxed mb-8">
              {companyInfo.manifesto}
            </p>
            <p className="text-2xl font-light text-gray-600 italic">
              {companyInfo.slogan}
            </p>
          </div>
        </div>
      </section>

      {/* Sobre Section */}
      <section id="sobre" className="py-24 bg-white">
        <div className="container mx-auto px-6">
          <div className="max-w-6xl mx-auto">
            <div className="grid md:grid-cols-2 gap-16 items-center mb-20">
              <div>
                <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                  Excelência Técnica.
                  <br />
                  Sensibilidade Estética.
                </h2>
                <p className="text-gray-600 mb-6 leading-relaxed text-lg">
                  {companyInfo.philosophy}
                </p>
                <p className="text-gray-600 mb-8 leading-relaxed text-lg">
                  {companyInfo.approach}
                </p>
                <div className="grid grid-cols-2 gap-4">
                  {whyMudare.map((item, index) => (
                    <div key={index} className="p-4 bg-gray-50 rounded-lg">
                      <h4 className="font-bold text-gray-900 mb-2">{item.title}</h4>
                      <p className="text-sm text-gray-600">{item.description}</p>
                    </div>
                  ))}
                </div>
              </div>
              <div className="relative">
                <div className="aspect-[4/3] rounded-lg overflow-hidden shadow-xl">
                  <img 
                    src="https://images.unsplash.com/photo-1599995903128-531fc7fb694b"
                    alt="Obra MUDARE Construtora"
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
          </div>
        </div>
      </section>

      {/* Projetos Section */}
      <section id="projetos" className="py-24 bg-gray-50">
        <div className="container mx-auto px-6">
          <div className="mb-16 text-center">
            <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Projetos</h2>
            <p className="text-xl text-gray-600 max-w-2xl mx-auto">
              Obras residenciais, comerciais e corporativas executadas com precisão técnica
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
                  </div>
                </div>
                <div className={index % 2 === 0 ? 'order-2' : 'order-1'}>
                  <Badge className="mb-3 bg-gray-100 text-gray-700 hover:bg-gray-200 border-none">
                    {project.category}
                  </Badge>
                  <h3 className="text-3xl font-bold text-gray-900 mb-4">{project.title}</h3>
                  <p className="text-gray-600 mb-4 leading-relaxed text-lg">{project.description}</p>
                  <p className="text-gray-500 mb-6 leading-relaxed">{project.story}</p>
                  <div className="space-y-2 text-gray-700 text-sm">
                    <div className="flex items-center gap-2">
                      <span className="font-medium">Arquiteto:</span>
                      <span>{project.architect}</span>
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

      {/* Arquitetos Parceiros */}
      <section id="arquitetos" className="py-24 bg-white">
        <div className="container mx-auto px-6">
          <div className="max-w-5xl mx-auto">
            <div className="text-center mb-12">
              <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Arquitetos Parceiros</h2>
              <p className="text-xl text-gray-600">
                Trabalhamos com os principais nomes da arquitetura brasileira
              </p>
            </div>
            <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
              {architects.map((architect, index) => (
                <div key={index} className="text-center p-4">
                  <p className="text-gray-700 font-medium">{architect}</p>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Processo Section */}
      <section className="py-24 bg-gray-50">
        <div className="container mx-auto px-6">
          <div className="max-w-5xl mx-auto">
            <div className="text-center mb-16">
              <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Processo</h2>
              <p className="text-xl text-gray-600">
                {companyInfo.mission}
              </p>
            </div>

            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
              {processSteps.map((step) => (
                <Card key={step.id} className="border-none shadow-sm hover:shadow-md transition-shadow">
                  <CardContent className="p-8">
                    <div className="w-12 h-12 bg-[#C87533] text-white rounded-full flex items-center justify-center text-xl font-bold mb-4">
                      {step.number}
                    </div>
                    <h3 className="text-xl font-bold text-gray-900 mb-3">{step.title}</h3>
                    <p className="text-gray-600 leading-relaxed">{step.description}</p>
                  </CardContent>
                </Card>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Process Images */}
      <section className="py-20 bg-white">
        <div className="container mx-auto px-6">
          <div className="grid md:grid-cols-3 gap-4">
            {processImages.map((image, index) => (
              <div key={index} className="relative aspect-square overflow-hidden bg-gray-200 rounded-lg group">
                <img 
                  src={image}
                  alt={`Obra MUDARE ${index + 1}`}
                  className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                  loading="lazy"
                />
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Serviços Section */}
      <section id="servicos" className="py-24 bg-gray-50">
        <div className="container mx-auto px-6">
          <div className="max-w-6xl mx-auto">
            <div className="text-center mb-16">
              <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Serviços</h2>
            </div>

            <div className="grid md:grid-cols-2 gap-8">
              {services.map((service) => (
                <Card key={service.id} className="border-none shadow-sm hover:shadow-md transition-shadow">
                  <CardContent className="p-8">
                    <h3 className="text-xl font-bold text-gray-900 mb-3">{service.title}</h3>
                    <p className="text-gray-600 leading-relaxed mb-3">{service.description}</p>
                    <p className="text-sm text-gray-500">{service.technical}</p>
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
              <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Equipe</h2>
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
                        loading="lazy"
                      />
                    </div>
                    <h3 className="text-2xl font-bold text-gray-900 mb-2">{member.name}</h3>
                    <p className="text-[#C87533] font-medium mb-4">{member.role}</p>
                    <p className="text-gray-600 mb-6">{member.bio}</p>
                    <Separator className="my-6" />
                    <div className="text-left space-y-2">
                      {member.credentials.map((credential, index) => (
                        <div key={index} className="text-sm text-gray-600">
                          • {credential}
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
              <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Depoimentos</h2>
            </div>

            <div className="grid md:grid-cols-3 gap-8">
              {testimonials.map((testimonial) => (
                <Card key={testimonial.id} className="border-none shadow-md hover:shadow-lg transition-shadow">
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
                      <div className="text-sm text-[#C87533] mt-1">{testimonial.project}</div>
                    </div>
                  </CardContent>
                </Card>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* FAQ Section */}
      <section id="faq" className="py-24 bg-white">
        <div className="container mx-auto px-6">
          <div className="max-w-4xl mx-auto">
            <div className="text-center mb-16">
              <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Perguntas Frequentes</h2>
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

      {/* CTA Section */}
      <section className="py-32 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white">
        <div className="container mx-auto px-6 text-center">
          <h2 className="text-5xl md:text-6xl font-bold mb-6">Vamos Conversar?</h2>
          <p className="text-2xl md:text-3xl font-light text-[#C87533] mb-8">
            {companyInfo.slogan}
          </p>
          <p className="text-xl text-gray-300 mb-12 max-w-2xl mx-auto">
            Entre em contato para discutir seu projeto
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Button 
              size="lg" 
              className="bg-[#C87533] hover:bg-[#B06429] text-white px-8 py-6"
              onClick={() => window.location.href = `https://wa.me/5511247693 03?text=${encodeURIComponent('Olá! Gostaria de falar sobre um projeto.')}`}
            >
              WhatsApp
            </Button>
            <Button 
              size="lg" 
              variant="outline"
              className="border-white text-white hover:bg-white hover:text-gray-900 px-8 py-6"
              onClick={() => window.location.href = `mailto:${companyInfo.contact.email}?subject=${encodeURIComponent('Contato - Projeto MUDARE')}`}
            >
              Enviar Email
            </Button>
            <Button 
              size="lg" 
              variant="outline"
              className="border-white text-white hover:bg-white hover:text-gray-900 px-8 py-6"
              onClick={() => window.location.href = `tel:${companyInfo.contact.phone}`}
            >
              Ligar Agora
            </Button>
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer id="contato" className="bg-gray-900 text-white py-16">
        <div className="container mx-auto px-6">
          <div className="grid md:grid-cols-3 gap-12 mb-12">
            <div>
              <img src="/logo-mudare.png" alt="MUDARE Construtora" className="h-12 mb-4" />
              <p className="text-[#C87533] italic mb-4">{companyInfo.slogan}</p>
              <p className="text-gray-400 text-sm leading-relaxed mb-6">
                Construtora de alto padrão especializada em arquitetura autoral
              </p>
              {/* Social Media - Discreto */}
              <div className="flex gap-4">
                <a 
                  href={companyInfo.social.instagram} 
                  target="_blank" 
                  rel="noopener noreferrer"
                  className="text-gray-400 hover:text-[#C87533] transition-colors"
                  aria-label="Instagram"
                >
                  <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                  </svg>
                </a>
                <a 
                  href={companyInfo.social.linkedin} 
                  target="_blank" 
                  rel="noopener noreferrer"
                  className="text-gray-400 hover:text-[#C87533] transition-colors"
                  aria-label="LinkedIn"
                >
                  <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                  </svg>
                </a>
                <a 
                  href={companyInfo.social.facebook} 
                  target="_blank" 
                  rel="noopener noreferrer"
                  className="text-gray-400 hover:text-[#C87533] transition-colors"
                  aria-label="Facebook"
                >
                  <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                  </svg>
                </a>
              </div>
            </div>

            <div>
              <h4 className="text-lg font-bold mb-4">Navegação</h4>
              <ul className="space-y-2">
                <li><a href="#sobre" className="text-gray-400 hover:text-[#C87533] transition-colors">Sobre</a></li>
                <li><a href="#projetos" className="text-gray-400 hover:text-[#C87533] transition-colors">Projetos</a></li>
                <li><a href="#arquitetos" className="text-gray-400 hover:text-[#C87533] transition-colors">Arquitetos</a></li>
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
            <p className="mb-2">
              © {new Date().getFullYear()} MUDARE Construtora. Todos os direitos reservados.
            </p>
            <p className="text-[#C87533] italic">{companyInfo.slogan}</p>
          </div>
        </div>
      </footer>
    </div>
  );
};

export default Home;