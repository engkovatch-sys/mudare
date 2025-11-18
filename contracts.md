# Contratos - Painel Administrativo MUDARE

## Objetivo
Criar painel administrativo para gerenciar conteúdo do site sem precisar editar código.

## Funcionalidades

### 1. Autenticação
- Login com usuário e senha
- Sessão segura
- Logout

### 2. Gerenciamento de Projetos
- Listar todos os projetos
- Adicionar novo projeto (com upload de imagem)
- Editar projeto existente
- Excluir projeto
- Marcar como "featured" (destaque)

### 3. Gerenciamento de Arquitetos
- Listar arquitetos parceiros
- Adicionar/Editar/Excluir arquitetos

### 4. Gerenciamento de Depoimentos
- Listar depoimentos
- Adicionar/Editar/Excluir depoimentos

### 5. Gerenciamento de Serviços
- Listar serviços
- Editar descrição dos serviços

### 6. Gerenciamento de Informações da Empresa
- Editar textos principais (manifesto, filosofia, etc)
- Editar informações de contato
- Editar slogan

### 7. Upload de Imagens
- Sistema de upload para projetos
- Armazenamento em /app/frontend/public/uploads/

## APIs Backend

### Autenticação
- POST /api/admin/login - Login
- POST /api/admin/logout - Logout
- GET /api/admin/check - Verificar se está logado

### Projetos
- GET /api/admin/projects - Listar todos
- POST /api/admin/projects - Criar novo
- PUT /api/admin/projects/{id} - Atualizar
- DELETE /api/admin/projects/{id} - Excluir
- POST /api/admin/projects/upload - Upload de imagem

### Arquitetos
- GET /api/admin/architects - Listar
- POST /api/admin/architects - Criar
- PUT /api/admin/architects/{id} - Atualizar
- DELETE /api/admin/architects/{id} - Excluir

### Depoimentos
- GET /api/admin/testimonials - Listar
- POST /api/admin/testimonials - Criar
- PUT /api/admin/testimonials/{id} - Atualizar
- DELETE /api/admin/testimonials/{id} - Excluir

### Serviços
- GET /api/admin/services - Listar
- PUT /api/admin/services/{id} - Atualizar

### Informações da Empresa
- GET /api/admin/company-info - Buscar
- PUT /api/admin/company-info - Atualizar

## Frontend Admin

### Rotas
- /admin/login - Página de login
- /admin/dashboard - Dashboard principal
- /admin/projects - Gerenciar projetos
- /admin/architects - Gerenciar arquitetos
- /admin/testimonials - Gerenciar depoimentos
- /admin/services - Gerenciar serviços
- /admin/company - Gerenciar informações da empresa

### Componentes
- AdminLogin - Tela de login
- AdminLayout - Layout com sidebar
- ProjectsManager - Gerenciar projetos
- ArchitectsManager - Gerenciar arquitetos
- TestimonialsManager - Gerenciar depoimentos
- ServicesManager - Gerenciar serviços
- CompanyInfoManager - Gerenciar info da empresa

## Modelos MongoDB

### User (admin)
```
{
  _id: ObjectId,
  username: string,
  password: string (hashed),
  created_at: datetime
}
```

### Project
```
{
  _id: ObjectId,
  title: string,
  category: string,
  location: string,
  architect: string,
  year: number,
  area: string,
  description: string,
  story: string,
  image: string (URL),
  featured: boolean,
  created_at: datetime,
  updated_at: datetime
}
```

### Architect
```
{
  _id: ObjectId,
  name: string,
  order: number
}
```

### Testimonial
```
{
  _id: ObjectId,
  name: string,
  role: string,
  project: string,
  content: string,
  rating: number
}
```

### Service
```
{
  _id: ObjectId,
  title: string,
  description: string,
  technical: string,
  order: number
}
```

### CompanyInfo
```
{
  _id: ObjectId,
  slogan: string,
  manifesto: string,
  philosophy: string,
  approach: string,
  excellence_title: string,
  excellence_subtitle: string,
  excellence_description: string,
  mission: string,
  vision: string,
  contact_phone: string,
  contact_email: string,
  contact_address: string,
  updated_at: datetime
}
```

## Credenciais Default
- Username: admin
- Password: mudare2024

## Integração com Site
- Frontend irá buscar dados do backend via API
- Remover mockData.js e usar dados reais do MongoDB
- Criar hook useData() para buscar dados
