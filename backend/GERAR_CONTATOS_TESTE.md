# Gerar Contatos de Teste

Este projeto possui duas formas de gerar contatos de teste:

## Opção 1: Usando o Comando Artisan (Recomendado)

Execute o comando no terminal dentro da pasta `backend`:

```bash
php artisan contacts:generate --user_id=1 --count=30
```

**Parâmetros:**
- `--user_id`: ID do usuário (padrão: 1)
- `--count`: Quantidade de contatos a criar (padrão: 30, máximo: 1000)

**Exemplos:**
```bash
# Criar 30 contatos para o usuário ID 1 (padrão)
php artisan contacts:generate

# Criar 50 contatos para o usuário ID 1
php artisan contacts:generate --count=50

# Criar 30 contatos para o usuário ID 2
php artisan contacts:generate --user_id=2

# Criar 100 contatos para o usuário ID 1
php artisan contacts:generate --count=100
```

## Opção 2: Usando o Seeder

Execute o seeder diretamente:

```bash
php artisan db:seed --class=ContactSeeder
```

Ou adicione ao `DatabaseSeeder.php` e execute:

```bash
php artisan db:seed
```

## Notas

- Os contatos são gerados com dados aleatórios usando Faker (português brasileiro)
- Telefones são gerados com 11 dígitos numéricos
- Emails são únicos e válidos
- Se o usuário não existir, o comando perguntará se deseja criá-lo

