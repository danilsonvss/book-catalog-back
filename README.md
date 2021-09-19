# API Laravel para cadastro de livros

## Instalando o projeto

Rode os comandos abaixo para iniciar a configuração e instalação do projeto.

```
composer install
```

## Configurando o container do docker

```bash
# Instalar imagens e criar containers docker
./vendor/bin/sail up -d
```

## Rodando as migrations e populandos o banco de dados com a seed do usuário padrão
```
# Cria as tabelas no banco de dados criado pelo sail presente no .env
./vendor/bin/sail artisan migrate

# Alimenta o banco de dados criando o usuário padrão
./vendor/bin/sail artisan db:seed
```
