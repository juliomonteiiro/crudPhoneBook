# Agenda Telefônica

Sistema completo de agenda telefônica desenvolvido com Vue.js 3 (Frontend) e Laravel 8 (Backend).

## 📋 Características

- ✅ CRUD completo de contatos (Create, Read, Update, Delete)
- ✅ Autenticação com Laravel Sanctum
- ✅ Upload de imagens para contatos
- ✅ Design responsivo (Desktop e Mobile)
- ✅ Validação de rotas protegidas
- ✅ Interface moderna e intuitiva

## 🛠️ Tecnologias

### Frontend
- Vue.js 3
- Pinia (State Management)
- Vue Router
- Axios
- Tailwind CSS 4
- Vite

### Backend
- Laravel 7.4
- Laravel Sanctum (Autenticação)
- MySQL

## 📦 Instalação

### Pré-requisitos
- PHP 7.4
- Composer
- Node.js 22.12.0
- MySQL

### Backend (Laravel)

1. Entre na pasta do backend:
```bash
cd backend
```

2. Instale as dependências:
```bash
composer install
```

3. Configure o arquivo `.env`:
```bash
cp .env.example .env
```

4. Edite o arquivo `.env` e configure:
```env
APP_NAME="Agenda Telefônica"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=phonebook
DB_USERNAME=root
DB_PASSWORD=

CORS_ALLOWED_ORIGINS=http://localhost:5173
```

5. Gere a chave da aplicação:
```bash
php artisan key:generate
```

6. Execute as migrações:
```bash
php artisan migrate
```

7. Crie o link simbólico para armazenamento:
```bash
php artisan storage:link
```

8. Inicie o servidor:
```bash
php artisan serve
```

O backend estará disponível em `http://localhost:8000`

### Frontend (Vue.js)

1. Entre na pasta do frontend:
```bash
cd frontend
```

2. Instale as dependências:
```bash
npm install
```

3. Configure o arquivo `.env`:
```bash
cp .env.example .env
```

4. Edite o arquivo `.env` e configure:
```env
VITE_API_BASE_URL=http://127.0.0.1:8000
```

5. Inicie o servidor de desenvolvimento:
```bash
npm run dev
```

O frontend estará disponível em `http://localhost:5173`

## 🚀 Comandos para Iniciar

### Backend
```bash
cd backend
php artisan serve
```

### Frontend
```bash
cd frontend
npm run dev
```

## 📝 Estrutura do Projeto

```
crudPhoneBook/
├── backend/                 # Laravel API
│   ├── app/
│   │   ├── Http/
│   │   │   └── Controllers/ # Controllers da API
│   │   ├── Models/          # Models Eloquent
│   │   └── Services/        # Services (lógica de negócio)
│   ├── database/
│   │   └── migrations/      # Migrações do banco
│   ├── routes/
│   │   └── api.php          # Rotas da API
│   └── config/              # Configurações
│
└── frontend/                # Vue.js App
    ├── src/
    │   ├── api/             # Clientes API
    │   ├── components/      # Componentes reutilizáveis
    │   ├── config/          # Configurações (axios)
    │   ├── layouts/         # Layouts
    │   ├── modules/         # Módulos (auth, contacts)
    │   ├── router/          # Rotas
    │   └── store/           # Pinia stores
    └── public/              # Arquivos públicos
```

## 🔐 Autenticação

O sistema utiliza Laravel Sanctum para autenticação. As rotas protegidas requerem um token de autenticação que é enviado no header `Authorization: Bearer {token}`.

### Endpoints da API

#### Autenticação
- `POST /api/register` - Registrar novo usuário
- `POST /api/login` - Login
- `POST /api/logout` - Logout (requer autenticação)
- `GET /api/user` - Obter usuário atual (requer autenticação)

#### Contatos (requer autenticação)
- `GET /api/contacts` - Listar contatos
- `POST /api/contacts` - Criar contato
- `GET /api/contacts/{id}` - Obter contato
- `PUT /api/contacts/{id}` - Atualizar contato
- `DELETE /api/contacts/{id}` - Excluir contato

## 🎨 Funcionalidades

### Modo Escuro
O sistema possui modo escuro que pode ser alternado através do botão na navbar. A preferência é salva no localStorage.

### Upload de Imagens
- Formatos aceitos: JPG, PNG, GIF
- Tamanho máximo: 2MB
- As imagens são armazenadas em `storage/app/public/contacts`

### Responsividade
- Desktop: Grid com múltiplas colunas
- Tablet: Grid com 2-3 colunas
- Mobile: Grid com 1 coluna

## 🔒 Segurança

- Todas as variáveis sensíveis estão no arquivo `.env`
- Autenticação via Laravel Sanctum
- Validação de rotas no frontend e backend
- Proteção CSRF (Laravel)
- CORS configurado
- Validação de dados no backend

## 📱 Uso

1. Acesse `http://localhost:5173`
2. Faça login com suas credenciais (ou registre-se)
3. Visualize seus contatos na lista
4. Clique em "Novo Contato" para adicionar um contato
5. Clique em "Editar" para editar um contato
6. Clique em "Excluir" para remover um contato (com confirmação)

## 🧪 Testes

### Backend
```bash
cd backend
php artisan test
```

### Frontend
```bash
cd frontend
npm run test
```

## 🏗️ Build para Produção

### Frontend
```bash
cd frontend
npm run build
```

Os arquivos estarão em `frontend/dist/`

### Backend
Configure o `.env` para produção:
```env
APP_ENV=production
APP_DEBUG=false
```

## 📄 Licença

Este projeto é open source e está disponível sob a licença MIT.

## 👨‍💻 Desenvolvido por

**Desenvolvido por [Julio Monteiro](https://github.com/juliomonteiiro)** em Vue.js e Laravel.

