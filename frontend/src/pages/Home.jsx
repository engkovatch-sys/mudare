import React, { useState, useEffect } from 'react';
import { Button } from '../components/ui/button';
import { Card, CardContent } from '../components/ui/card';
import { Badge } from '../components/ui/badge';
import { ArrowRight, Phone, Mail, MapPin, Menu, X } from 'lucide-react';
import { companyInfo, projects, services, stats, teamMembers, values } from '../mockData';

const Home = () => {
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [activeProject, setActiveProject] = useState(0);
  const [scrollY, setScrollY] = useState(0);

  useEffect(() => {
    const handleScroll = () => setScrollY(window.scrollY);
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  return (
    <div className="min-h-screen bg-white">
      {/* Minimal Header */}
      <header className={`fixed top-0 w-full z-50 transition-all duration-300 ${
        scrollY > 50 ? 'bg-white/95 backdrop-blur-md shadow-sm' : 'bg-transparent'
      }`}>
        <div className="container mx-auto px-6 py-6">
          <div className="flex items-center justify-between">
            <div className="text-2xl font-bold tracking-tight text-gray-900">
              {companyInfo.name}
            </div>
            <nav className="hidden md:flex items-center space-x-10">
              <a href="#projetos" className="text-sm text-gray-700 hover:text-gray-900 transition-colors">Projetos</a>
              <a href="#sobre" className="text-sm text-gray-700 hover:text-gray-900 transition-colors">Sobre</a>
              <a href="#servicos" className="text-sm text-gray-700 hover:text-gray-900 transition-colors">Serviços</a>
              <a href="#contato" className="text-sm text-gray-700 hover:text-gray-900 transition-colors">Contato</a>
            </nav>
            <button 
              className="md:hidden"
              onClick={() => setIsMenuOpen(!isMenuOpen)}
            >
              {isMenuOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
            </button>
          </div>
        </div>
      </header>

      {/* Mobile Menu */}
      {isMenuOpen && (
        <div className="fixed inset-0 z-40 bg-white md:hidden pt-20">
          <nav className="flex flex-col items-center space-y-8 py-12">
            <a href="#projetos" className="text-2xl text-gray-900" onClick={() => setIsMenuOpen(false)}>Projetos</a>
            <a href="#sobre" className="text-2xl text-gray-900" onClick={() => setIsMenuOpen(false)}>Sobre</a>
            <a href="#servicos" className="text-2xl text-gray-900" onClick={() => setIsMenuOpen(false)}>Serviços</a>
            <a href="#contato" className="text-2xl text-gray-900" onClick={() => setIsMenuOpen(false)}>Contato</a>
          </nav>
        </div>
      )}

      {/* Hero Section - Full Screen Image */}
      <section className="relative h-screen flex items-center justify-center overflow-hidden">
        <div 
          className="absolute inset-0 bg-cover bg-center"
          style={{
            backgroundImage: `url('${projects[activeProject].image}')`,
            transform: `scale(${1 + scrollY * 0.0005})`,
            transition: 'background-image 1s ease-in-out'
          }}
        >
          <div className="absolute inset-0 bg-black/40"></div>
        </div>
        
        <div className="relative z-10 text-center text-white px-6 max-w-4xl">
          <div className="mb-6 text-sm tracking-[0.3em] uppercase opacity-90">
            Desde {companyInfo.foundedYear}
          </div>
          <h1 className="text-6xl md:text-8xl font-bold mb-6 leading-none">
            {companyInfo.tagline}
          </h1>
          <p className="text-xl md:text-2xl mb-12 opacity-90 font-light">
            {companyInfo.description}
          </p>
          <Button 
            size="lg" 
            className="bg-white text-gray-900 hover:bg-gray-100 px-8 py-6 text-base"
          >
            <a href="#projetos" className="flex items-center gap-2">
              Explorar Projetos <ArrowRight className="w-5 h-5" />
            </a>
          </Button>
        </div>

        {/* Project Navigation Dots */}
        <div className="absolute bottom-12 left-1/2 transform -translate-x-1/2 flex gap-3 z-20">
          {projects.filter(p => p.featured).map((_, index) => (
            <button
              key={index}
              onClick={() => setActiveProject(index)}
              className={`w-2 h-2 rounded-full transition-all duration-300 ${
                activeProject === index ? 'bg-white w-8' : 'bg-white/50 hover:bg-white/80'
              }`}
            />
          ))}
        </div>
      </section>

      {/* Stats Bar */}
      <section className="border-y border-gray-200 bg-white">
        <div className="container mx-auto px-6 py-12">
          <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
            {stats.map((stat, index) => (
              <div key={index} className="text-center">
                <div className="text-5xl font-bold text-gray-900 mb-2">{stat.value}</div>
                <div className="text-sm text-gray-600 uppercase tracking-wider">{stat.label}</div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Projetos Section - Grid Clean */}
      <section id="projetos" className="py-32 bg-white">
        <div className="container mx-auto px-6">
          <div className="max-w-6xl mx-auto">
            <div className="mb-20 max-w-2xl">
              <h2 className="text-5xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                Projetos Selecionados
              </h2>
              <p className="text-xl text-gray-600">
                Obras com arquitetura autoral e alto padrão construtivo
              </p>
            </div>

            {/* Large Feature Projects */}
            <div className="space-y-32">
              {projects.filter(p => p.featured).map((project, index) => (
                <div 
                  key={project.id}
                  className="group"
                >
                  <div className="grid md:grid-cols-2 gap-12 items-center">
                    <div className={index % 2 === 0 ? 'order-1' : 'order-2'}>
                      <div className="relative aspect-[4/3] overflow-hidden bg-gray-100">
                        <img 
                          src={project.image}
                          alt={project.title}
                          className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                        />
                      </div>
                    </div>
                    <div className={index % 2 === 0 ? 'order-2' : 'order-1'}>
                      <div className="text-sm text-gray-500 mb-3">{project.category}</div>
                      <h3 className="text-4xl font-bold text-gray-900 mb-4">{project.title}</h3>
                      <div className="space-y-3 text-gray-600 mb-6">
                        <div className="flex items-center gap-3">
                          <span className="text-sm font-medium">Localização:</span>
                          <span>{project.location}</span>
                        </div>
                        <div className="flex items-center gap-3">
                          <span className="text-sm font-medium">Arquiteto:</span>
                          <span>{project.architect}</span>
                        </div>
                        <div className="flex items-center gap-3">
                          <span className="text-sm font-medium">Área:</span>
                          <span>{project.area}</span>
                        </div>
                        <div className="flex items-center gap-3">
                          <span className="text-sm font-medium">Ano:</span>
                          <span>{project.year}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Sobre Section - Minimal */}
      <section id="sobre" className="py-32 bg-gray-50">
        <div className="container mx-auto px-6">
          <div className="max-w-4xl mx-auto">
            <div className="text-center mb-16">
              <h2 className="text-5xl md:text-6xl font-bold text-gray-900 mb-8 leading-tight">
                Excelência Construtiva
              </h2>
              <p className="text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">
                Unimos conhecimento clássico a práticas atualizadas de engenharia, garantindo 
                especificações corretas, controle de qualidade rigoroso e desempenho estrutural duradouro.
              </p>
            </div>

            {/* Values Grid */}
            <div className="grid grid-cols-2 md:grid-cols-4 gap-8 mb-20">
              {values.map((value, index) => (
                <div key={index} className="text-center">
                  <div className="text-lg font-medium text-gray-900">{value}</div>
                </div>
              ))}
            </div>

            {/* Team */}
            <div className="grid md:grid-cols-2 gap-12">
              {teamMembers.map((member) => (
                <div key={member.id} className="text-center">
                  <h3 className="text-2xl font-bold text-gray-900 mb-2">{member.name}</h3>
                  <p className="text-gray-600 mb-2">{member.role}</p>
                  <p className="text-sm text-gray-500">{member.credentials}</p>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Serviços Section */}
      <section id="servicos" className="py-32 bg-white">
        <div className="container mx-auto px-6">
          <div className="max-w-6xl mx-auto">
            <div className="mb-20">
              <h2 className="text-5xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                Serviços
              </h2>
            </div>

            <div className="grid md:grid-cols-2 gap-x-20 gap-y-12">
              {services.map((service) => (
                <div key={service.id} className="border-t border-gray-200 pt-6">
                  <h3 className="text-2xl font-bold text-gray-900 mb-3">{service.title}</h3>
                  <p className="text-gray-600">{service.description}</p>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Construction Process Images */}
      <section className="py-20 bg-gray-50">
        <div className="container mx-auto px-6">
          <div className="grid md:grid-cols-3 gap-4">
            <div className="relative aspect-square overflow-hidden bg-gray-200">
              <img 
                src="https://images.unsplash.com/photo-1599995903128-531fc7fb694b"
                alt="Processo construtivo"
                className="w-full h-full object-cover hover:scale-105 transition-transform duration-700"
              />
            </div>
            <div className="relative aspect-square overflow-hidden bg-gray-200">
              <img 
                src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5"
                alt="Equipe técnica"
                className="w-full h-full object-cover hover:scale-105 transition-transform duration-700"
              />
            </div>
            <div className="relative aspect-square overflow-hidden bg-gray-200">
              <img 
                src="https://images.unsplash.com/photo-1696401680571-f6e9986026d0"
                alt="Detalhes arquitetônicos"
                className="w-full h-full object-cover hover:scale-105 transition-transform duration-700"
              />
            </div>
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-32 bg-gray-900 text-white">
        <div className="container mx-auto px-6 text-center">
          <h2 className="text-5xl md:text-6xl font-bold mb-8">Vamos conversar?</h2>
          <p className="text-xl text-gray-300 mb-12 max-w-2xl mx-auto">
            Entre em contato e descubra como podemos transformar seu projeto em patrimônio
          </p>
          <Button size="lg" className="bg-white text-gray-900 hover:bg-gray-100 px-8 py-6 text-base">
            <a href="#contato">Iniciar Projeto</a>
          </Button>
        </div>
      </section>

      {/* Footer - Minimal */}
      <footer id="contato" className="bg-white border-t border-gray-200">
        <div className="container mx-auto px-6 py-20">
          <div className="grid md:grid-cols-2 gap-16 max-w-5xl mx-auto">
            <div>
              <h3 className="text-3xl font-bold text-gray-900 mb-8">Contato</h3>
              <div className="space-y-4">
                <div className="flex items-start gap-4">
                  <MapPin className="w-5 h-5 text-gray-400 mt-1 flex-shrink-0" />
                  <div className="text-gray-600">
                    {companyInfo.contact.address}<br />
                    {companyInfo.contact.neighborhood}<br />
                    {companyInfo.contact.city} - CEP {companyInfo.contact.cep}
                  </div>
                </div>
                <div className="flex items-center gap-4">
                  <Phone className="w-5 h-5 text-gray-400" />
                  <a href={`tel:${companyInfo.contact.phone}`} className="text-gray-600 hover:text-gray-900 transition-colors">
                    {companyInfo.contact.phone}
                  </a>
                </div>
                <div className="flex items-center gap-4">
                  <Mail className="w-5 h-5 text-gray-400" />
                  <a href={`mailto:${companyInfo.contact.email}`} className="text-gray-600 hover:text-gray-900 transition-colors">
                    {companyInfo.contact.email}
                  </a>
                </div>
              </div>
            </div>
            <div>
              <h3 className="text-3xl font-bold text-gray-900 mb-8">{companyInfo.name}</h3>
              <p className="text-gray-600 mb-6">{companyInfo.description}</p>
              <p className="text-sm text-gray-500">© {new Date().getFullYear()} {companyInfo.name}. Todos os direitos reservados.</p>
            </div>
          </div>
        </div>
      </footer>
    </div>
  );
};

export default Home;