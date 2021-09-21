# API Laravel para cadastro de livros

## Instalando o projeto

Rode os comandos abaixo para iniciar a configuração e instalação do projeto.

```
composer install
```

## Configurando o container do docker

Importante: O container do sail está configurado para rodar na porta 80, caso haja algum serviço nesta porta,
é aconselhável parar o mesmo antes de subir o container da aplicação.
Outra alternativa é alterar a porta no .env adicionando a propriedade `APP_PORT`.
Exemplo: `APP_PORT=800`

```bash
cp .env.example .env
```

```bash
# Instalar imagens e criar containers docker
./vendor/bin/sail up -d
```

## Rodando as migrations e populando o banco de dados
```
# Gera a chave de criptografia da aplicação
./vendor/bin/sail artisan key:generate

# Cria as tabelas no banco de dados criado pelo sail presente no .env
./vendor/bin/sail artisan migrate

# Alimenta o banco de dados criando o usuário padrão
./vendor/bin/sail artisan db:seed
```

## Configurando a API do HGBrasil para obter o clima
Documentação: https://console.hgbrasil.com/

Adicione sua chave da API ao `.env` conforme abaixo

```
HG_APP_KEY=DIGITE_SUA_CHAVE_AQUI
```
