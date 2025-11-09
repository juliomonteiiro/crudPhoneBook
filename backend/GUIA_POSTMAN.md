# 📮 Guia Completo - Configuração no Postman

## 🔧 Configuração Inicial

### 1. Criar Variáveis de Ambiente no Postman

1. Clique em **Environments** (canto superior direito)
2. Clique em **+** para criar novo ambiente
3. Adicione as variáveis:

| Variable | Initial Value | Current Value |
|----------|---------------|---------------|
| `base_url` | `http://127.0.0.1:8000/api` | `http://127.0.0.1:8000/api` |
| `token` | (deixe vazio) | (será preenchido após login) |

4. Selecione o ambiente criado no dropdown

---

## 🔓 **ENDPOINTS PÚBLICOS** (Sem Autenticação)

### 1. 📝 **POST /api/register** - Registrar Usuário

#### Configuração no Postman:

**Method:** `POST`

**URL:** `{{base_url}}/register`

**Headers:**
```
Content-Type: application/json
```

**Body (raw JSON):**
```json
{
  "name": "João Silva",
  "email": "joao@example.com",
  "password": "123456"
}
```

**Exemplo de Resposta (201):**
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "name": "João Silva",
    "email": "joao@example.com",
    "created_at": "2025-01-15T10:00:00.000000Z",
    "updated_at": "2025-01-15T10:00:00.000000Z"
  }
}
```

**Campos Obrigatórios:**
- `name` (string, obrigatório)
- `email` (string, obrigatório, formato email válido, único)
- `password` (string, obrigatório, mínimo 6 caracteres)

---

### 2. 🔐 **POST /api/login** - Login

#### Configuração no Postman:

**Method:** `POST`

**URL:** `{{base_url}}/login`

**Headers:**
```
Content-Type: application/json
```

**Body (raw JSON):**
```json
{
  "email": "joao@example.com",
  "password": "123456"
}
```

**Exemplo de Resposta (200):**
```json
{
  "status": "success",
  "data": {
    "token": "1|abcdefghijklmnopqrstuvwxyz1234567890",
    "user": {
      "id": 1,
      "name": "João Silva",
      "email": "joao@example.com"
    }
  }
}
```

**⚠️ IMPORTANTE:** Após fazer login, copie o `token` e salve na variável de ambiente `token` no Postman!

**Como salvar o token automaticamente:**
1. Vá em **Tests** (aba abaixo do Body)
2. Adicione este código:
```javascript
if (pm.response.code === 200) {
    const response = pm.response.json();
    if (response.data && response.data.token) {
        pm.environment.set("token", response.data.token);
        console.log("Token salvo:", response.data.token);
    }
}
```

**Campos Obrigatórios:**
- `email` (string, obrigatório)
- `password` (string, obrigatório)

**Resposta de Erro (422):**
```json
{
  "status": "error",
  "message": "Dados de validação inválidos",
  "errors": {
    "email": ["As credenciais estão incorretas."]
  }
}
```

---

## 🔒 **ENDPOINTS PROTEGIDOS** (Requerem Autenticação)

### 3. 👤 **GET /api/user** - Obter Usuário Autenticado

#### Configuração no Postman:

**Method:** `GET`

**URL:** `{{base_url}}/user`

**Headers:**
```
Authorization: Bearer {{token}}
Content-Type: application/json
```

**Body:** Não precisa (GET request)

**Exemplo de Resposta (200):**
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "name": "João Silva",
    "email": "joao@example.com",
    "created_at": "2025-01-15T10:00:00.000000Z",
    "updated_at": "2025-01-15T10:00:00.000000Z"
  }
}
```

**Resposta de Erro (401):**
```json
{
  "status": "error",
  "message": "Unauthenticated"
}
```

---

### 4. 🚪 **POST /api/logout** - Logout

#### Configuração no Postman:

**Method:** `POST`

**URL:** `{{base_url}}/logout`

**Headers:**
```
Authorization: Bearer {{token}}
Content-Type: application/json
```

**Body:** Não precisa (ou pode enviar vazio)

**Exemplo de Resposta (200):**
```json
{
  "status": "success",
  "message": "Logout realizado com sucesso"
}
```

---

## 📞 **ENDPOINTS DE CONTATOS** (Requerem Autenticação)

### 5. 📋 **GET /api/contacts** - Listar Todos os Contatos

#### Configuração no Postman:

**Method:** `GET`

**URL:** `{{base_url}}/contacts`

**Headers:**
```
Authorization: Bearer {{token}}
Content-Type: application/json
```

**Body:** Não precisa (GET request)

**Exemplo de Resposta (200):**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "user_id": 1,
      "name": "Maria Santos",
      "phone": "11999999999",
      "email": "maria@example.com",
      "image": "contacts/abc123.jpg",
      "created_at": "2025-01-15T10:00:00.000000Z",
      "updated_at": "2025-01-15T10:00:00.000000Z"
    },
    {
      "id": 2,
      "user_id": 1,
      "name": "Pedro Oliveira",
      "phone": "11888888888",
      "email": "pedro@example.com",
      "image": null,
      "created_at": "2025-01-15T11:00:00.000000Z",
      "updated_at": "2025-01-15T11:00:00.000000Z"
    }
  ]
}
```

**Resposta quando não há contatos (200):**
```json
{
  "status": "success",
  "data": []
}
```

---

### 6. ➕ **POST /api/contacts** - Criar Contato

#### Configuração no Postman:

**Method:** `POST`

**URL:** `{{base_url}}/contacts`

**Headers:**
```
Authorization: Bearer {{token}}
```

**⚠️ IMPORTANTE:** NÃO adicione `Content-Type` manualmente! O Postman vai adicionar automaticamente com `multipart/form-data` quando você selecionar `form-data`.

**Body (form-data):**

| Key | Type | Value |
|-----|------|-------|
| `name` | Text | `Maria Santos` |
| `phone` | Text | `11999999999` |
| `email` | Text | `maria@example.com` |
| `image` | File | (selecione um arquivo de imagem - opcional) |

**Exemplo sem imagem:**
- `name`: `Maria Santos`
- `phone`: `11999999999`
- `email`: `maria@example.com`

**Exemplo com imagem:**
- `name`: `Maria Santos`
- `phone`: `11999999999`
- `email`: `maria@example.com`
- `image`: (selecione arquivo - JPG, PNG, etc. - máximo 2MB)

**Exemplo de Resposta (201):**
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "user_id": 1,
    "name": "Maria Santos",
    "phone": "11999999999",
    "email": "maria@example.com",
    "image": "contacts/abc123.jpg",
    "created_at": "2025-01-15T10:00:00.000000Z",
    "updated_at": "2025-01-15T10:00:00.000000Z"
  }
}
```

**Campos Obrigatórios:**
- `name` (string, obrigatório)
- `phone` (string, obrigatório)
- `email` (string, obrigatório, formato email válido)
- `image` (file, opcional, imagem, máximo 2MB)

**Resposta de Erro de Validação (422):**
```json
{
  "status": "error",
  "message": "Dados de validação inválidos",
  "errors": {
    "name": ["O campo name é obrigatório."],
    "email": ["O campo email deve ser um endereço de e-mail válido."]
  }
}
```

---

### 7. 👁️ **GET /api/contacts/{id}** - Visualizar Contato Específico

#### Configuração no Postman:

**Method:** `GET`

**URL:** `{{base_url}}/contacts/1`

**Substitua `1` pelo ID do contato que deseja visualizar**

**Headers:**
```
Authorization: Bearer {{token}}
Content-Type: application/json
```

**Body:** Não precisa (GET request)

**Exemplo de Resposta (200):**
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "user_id": 1,
    "name": "Maria Santos",
    "phone": "11999999999",
    "email": "maria@example.com",
    "image": "contacts/abc123.jpg",
    "created_at": "2025-01-15T10:00:00.000000Z",
    "updated_at": "2025-01-15T10:00:00.000000Z"
  }
}
```

**Resposta de Erro (403) - Tentando acessar contato de outro usuário:**
```json
{
  "status": "error",
  "message": "Unauthorized"
}
```

**Resposta de Erro (404) - Contato não encontrado:**
```json
{
  "message": "No query results for model [App\\Models\\Contact] 999"
}
```

---

### 8. ✏️ **PUT /api/contacts/{id}** - Atualizar Contato

#### Configuração no Postman:

**Method:** `PUT` ou `PATCH`

**URL:** `{{base_url}}/contacts/1`

**Substitua `1` pelo ID do contato que deseja atualizar**

**Headers:**
```
Authorization: Bearer {{token}}
```

**⚠️ IMPORTANTE:** NÃO adicione `Content-Type` manualmente! Use `form-data`.

**Body (form-data):**

| Key | Type | Value |
|-----|------|-------|
| `name` | Text | `Maria Santos Silva` |
| `phone` | Text | `11988888888` |
| `email` | Text | `maria.silva@example.com` |
| `image` | File | (selecione um arquivo de imagem - opcional) |

**Exemplo sem imagem:**
- `name`: `Maria Santos Silva`
- `phone`: `11988888888`
- `email`: `maria.silva@example.com`

**Exemplo com imagem (substitui a anterior):**
- `name`: `Maria Santos Silva`
- `phone`: `11988888888`
- `email`: `maria.silva@example.com`
- `image`: (selecione arquivo - JPG, PNG, etc. - máximo 2MB)

**Exemplo de Resposta (200):**
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "user_id": 1,
    "name": "Maria Santos Silva",
    "phone": "11988888888",
    "email": "maria.silva@example.com",
    "image": "contacts/xyz789.jpg",
    "created_at": "2025-01-15T10:00:00.000000Z",
    "updated_at": "2025-01-15T12:00:00.000000Z"
  }
}
```

**⚠️ NOTA:** Se você enviar uma nova imagem, a imagem antiga será automaticamente removida do storage.

**Campos Obrigatórios:**
- `name` (string, obrigatório)
- `phone` (string, obrigatório)
- `email` (string, obrigatório, formato email válido)
- `image` (file, opcional, imagem, máximo 2MB)

---

### 9. 🗑️ **DELETE /api/contacts/{id}** - Deletar Contato

#### Configuração no Postman:

**Method:** `DELETE`

**URL:** `{{base_url}}/contacts/1`

**Substitua `1` pelo ID do contato que deseja deletar**

**Headers:**
```
Authorization: Bearer {{token}}
Content-Type: application/json
```

**Body:** Não precisa (DELETE request)

**Exemplo de Resposta (200):**
```json
{
  "status": "success",
  "message": "Contato removido com sucesso"
}
```

**⚠️ NOTA:** A imagem do contato também será automaticamente removida do storage.

**Resposta de Erro (403) - Tentando deletar contato de outro usuário:**
```json
{
  "status": "error",
  "message": "Unauthorized"
}
```

---

## 🖼️ **Acessando Imagens dos Contatos**

Após criar ou atualizar um contato com imagem, você pode acessá-la via:

```
http://127.0.0.1:8000/storage/{caminho_da_imagem}
```

**Exemplo:**
Se a resposta retornar `"image": "contacts/abc123.jpg"`, acesse:
```
http://127.0.0.1:8000/storage/contacts/abc123.jpg
```

---

## 🎯 **Dicas Importantes para o Postman**

### 1. **Configurar Token Automaticamente Após Login**

Na aba **Tests** da requisição de login, adicione:

```javascript
if (pm.response.code === 200) {
    const response = pm.response.json();
    if (response.data && response.data.token) {
        pm.environment.set("token", response.data.token);
        console.log("✅ Token salvo automaticamente!");
    }
}
```

### 2. **Criar Collection Organizada**

Organize suas requisições em pastas:
```
📁 PhoneBook API
  📁 Auth (Público)
    - POST Register
    - POST Login
  📁 Auth (Protegido)
    - GET User
    - POST Logout
  📁 Contacts
    - GET List Contacts
    - POST Create Contact
    - GET Show Contact
    - PUT Update Contact
    - DELETE Delete Contact
```

### 3. **Usar Variáveis de Ambiente**

Sempre use `{{base_url}}` e `{{token}}` para facilitar a manutenção.

### 4. **Salvar Respostas de Exemplo**

Salve exemplos de respostas bem-sucedidas e de erro para referência futura.

---

## 🧪 **Fluxo de Teste Recomendado**

1. **POST /api/register** - Criar usuário
2. **POST /api/login** - Fazer login (token será salvo automaticamente)
3. **GET /api/user** - Verificar usuário autenticado
4. **POST /api/contacts** - Criar contato (com e sem imagem)
5. **GET /api/contacts** - Listar todos os contatos
6. **GET /api/contacts/{id}** - Ver contato específico
7. **PUT /api/contacts/{id}** - Atualizar contato
8. **DELETE /api/contacts/{id}** - Deletar contato
9. **POST /api/logout** - Fazer logout

---

## ❌ **Códigos de Erro Comuns**

| Código | Significado | Solução |
|--------|-------------|---------|
| `401` | Não autenticado | Verifique se o token está correto no header |
| `403` | Não autorizado | Você está tentando acessar recurso de outro usuário |
| `404` | Não encontrado | Verifique se o ID do contato existe |
| `422` | Erro de validação | Verifique os campos obrigatórios e formatos |
| `500` | Erro interno | Verifique os logs do servidor Laravel |

---

## 📝 **Exemplo Completo de Requisição com Imagem**

### POST /api/contacts

**Headers:**
```
Authorization: Bearer 1|abcdefghijklmnopqrstuvwxyz1234567890
```

**Body (form-data):**
```
name: Maria Santos
phone: 11999999999
email: maria@example.com
image: [selecione arquivo: foto.jpg]
```

**Resposta esperada:**
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "user_id": 1,
    "name": "Maria Santos",
    "phone": "11999999999",
    "email": "maria@example.com",
    "image": "contacts/abc123.jpg",
    "created_at": "2025-01-15T10:00:00.000000Z",
    "updated_at": "2025-01-15T10:00:00.000000Z"
  }
}
```

**Acessar imagem:**
```
http://127.0.0.1:8000/storage/contacts/abc123.jpg
```

---

## ✅ **Checklist de Teste**

- [ ] Registrar usuário
- [ ] Fazer login e salvar token
- [ ] Obter usuário autenticado
- [ ] Criar contato sem imagem
- [ ] Criar contato com imagem
- [ ] Listar todos os contatos
- [ ] Visualizar contato específico
- [ ] Atualizar contato sem imagem
- [ ] Atualizar contato com imagem (substituir)
- [ ] Deletar contato
- [ ] Testar erro 401 (sem token)
- [ ] Testar erro 403 (acessar contato de outro usuário)
- [ ] Fazer logout

---

Pronto! Agora você tem um guia completo para testar todas as requisições no Postman! 🚀

