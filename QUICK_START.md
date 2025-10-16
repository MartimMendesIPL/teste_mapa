# Quick Start Guide - Mapa Interativo de Portugal

Este guia rápido irá ajudá-lo a configurar e executar o projeto em minutos.

## Pré-requisitos

- PHP 7.4 ou superior
- MySQL ou MariaDB
- Composer (gerenciador de dependências PHP)
- Servidor web (Apache ou Nginx)

## Instalação em 5 Passos

### 1. Clone o Repositório

```bash
git clone https://github.com/MartimMendesIPL/teste_mapa.git
cd teste_mapa/yii2test
```

### 2. Instale as Dependências

```bash
composer install
```

Se o Composer não estiver instalado, instale primeiro:

```bash
# Linux/Mac
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Windows
# Baixe e instale: https://getcomposer.org/Composer-Setup.exe
```

### 3. Configure o Banco de Dados

Crie um banco de dados MySQL:

```bash
mysql -u root -p
```

```sql
CREATE DATABASE teste_mapa CHARACTER SET utf8 COLLATE utf8_unicode_ci;
GRANT ALL PRIVILEGES ON teste_mapa.* TO 'seu_usuario'@'localhost' IDENTIFIED BY 'sua_senha';
FLUSH PRIVILEGES;
EXIT;
```

Configure a conexão no arquivo `common/config/main-local.php`:

```php
<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=teste_mapa',
            'username' => 'seu_usuario',
            'password' => 'sua_senha',
            'charset' => 'utf8',
        ],
    ],
];
```

### 4. Execute as Migrações

```bash
php yii migrate
```

Responda `yes` quando perguntado. Isso irá:
- Criar a tabela `cultural_sites`
- Inserir 18 locais culturais de exemplo

### 5. Inicie o Servidor

#### Opção A: Servidor Embutido do PHP (Desenvolvimento)

```bash
# Frontend (Website com mapa)
cd frontend/web
php -S localhost:8080

# Backend (API)
# Em outro terminal
cd backend/web
php -S localhost:8081
```

#### Opção B: Apache/Nginx (Produção)

Configure o document root para:
- Frontend: `yii2test/frontend/web`
- Backend: `yii2test/backend/web`

## Testando a Instalação

### 1. Teste o Website

Abra o navegador e acesse:

```
http://localhost:8080/map/index
```

Você deverá ver um mapa interativo de Portugal com marcadores.

### 2. Teste a API

#### Listar todos os locais:

```bash
curl http://localhost:8081/api/cultural-sites
```

Ou abra no navegador:

```
http://localhost:8081/api/cultural-sites
```

#### Obter um local específico:

```bash
curl http://localhost:8081/api/cultural-sites/1
```

#### Filtrar por tipo (museus):

```bash
curl http://localhost:8081/api/cultural-sites/by-type/museum
```

#### Contar locais:

```bash
curl http://localhost:8081/api/cultural-sites/count
```

## Estrutura de Pastas

```
yii2test/
├── backend/              # Backend e API REST
│   ├── modules/
│   │   └── api/         # Módulo da API
│   │       └── controllers/
│   │           └── CulturalSiteController.php
│   └── web/             # Entry point do backend
│       └── index.php
│
├── frontend/            # Frontend web
│   ├── controllers/
│   │   └── MapController.php
│   ├── views/
│   │   └── map/
│   │       └── index.php  # View do mapa
│   └── web/             # Entry point do frontend
│       └── index.php
│
├── common/              # Código compartilhado
│   └── models/
│       └── CulturalSite.php  # Model principal
│
└── console/             # Comandos CLI
    └── migrations/      # Migrações do banco
        ├── m251016_134329_create_cultural_sites_table.php
        └── m251016_140000_seed_cultural_sites_data.php
```

## Funcionalidades do Mapa

### Filtros Disponíveis

1. **Por Tipo:**
   - Museus (marcador vermelho)
   - Monumentos (marcador azul)
   - Locais Culturais (marcador verde)

2. **Por Região/Cidade:**
   - Digite o nome da região ou cidade
   - Clique em "Aplicar Filtro"

### Interações

- **Clique em um marcador**: Ver detalhes do local
- **Zoom**: Use o scroll do mouse ou botões +/-
- **Pan**: Arraste o mapa
- **Legenda**: Veja no canto inferior direito

## Locais Pré-cadastrados

O sistema já vem com 18 locais famosos:

**Lisboa (5):**
- Torre de Belém
- Mosteiro dos Jerónimos
- Museu Nacional de Arte Antiga
- Castelo de São Jorge
- MAAT

**Porto (4):**
- Torre dos Clérigos
- Museu Serralves
- Palácio da Bolsa
- Livraria Lello

**Outros (9):**
- Universidade de Coimbra
- Mosteiro de Santa Clara-a-Velha (Coimbra)
- Templo Romano de Évora
- Capela dos Ossos (Évora)
- Palácio da Pena (Sintra)
- Quinta da Regaleira (Sintra)
- Castelo de Guimarães
- Bom Jesus do Monte (Braga)
- Centro Histórico de Faro

## Próximos Passos

### 1. Adicionar Novos Locais

Via API (POST):

```bash
curl -X POST http://localhost:8081/api/cultural-sites \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Museu do Azulejo",
    "type": "museum",
    "latitude": 38.7370,
    "longitude": -9.1074,
    "city": "Lisboa",
    "region": "Lisboa",
    "description": "Museu dedicado à arte do azulejo"
  }'
```

### 2. Integrar com Android

Siga o guia em [ANDROID_INTEGRATION.md](ANDROID_INTEGRATION.md)

### 3. Personalizar o Mapa

Edite `frontend/views/map/index.php` para:
- Alterar cores dos marcadores
- Adicionar mais filtros
- Customizar popups
- Mudar posição inicial do mapa

### 4. Criar Backend Admin

Gere um CRUD completo:

```bash
cd yii2test
php yii gii/crud \
  --modelClass=common\\models\\CulturalSite \
  --controllerClass=backend\\controllers\\CulturalSiteController \
  --viewPath=@backend/views/cultural-site \
  --baseControllerClass=yii\\web\\Controller \
  --indexWidgetType=grid
```

## Troubleshooting

### Problema: "php yii: command not found"

**Solução:** Use o caminho completo:

```bash
php /caminho/para/yii2test/yii migrate
```

### Problema: "SQLSTATE[HY000] [1045] Access denied"

**Solução:** Verifique as credenciais em `common/config/main-local.php`

### Problema: "404 Not Found" nas rotas

**Solução:** 

Para Apache, certifique-se de que mod_rewrite está ativo:

```bash
sudo a2enmod rewrite
sudo service apache2 restart
```

E que `.htaccess` existe em `frontend/web` e `backend/web`.

Para Nginx, adicione ao config:

```nginx
location / {
    try_files $uri $uri/ /index.php?$args;
}
```

### Problema: Mapa não carrega

**Solução:**

1. Abra o console do navegador (F12)
2. Verifique se há erros JavaScript
3. Confirme que Leaflet.js está carregando
4. Verifique se há dados JSON na view

### Problema: API retorna array vazio

**Solução:**

1. Verifique se as migrações foram executadas:

```bash
php yii migrate
```

2. Verifique se há dados no banco:

```bash
mysql -u root -p teste_mapa -e "SELECT COUNT(*) FROM cultural_sites;"
```

## Recursos Adicionais

- 📖 [Documentação Completa](MAPA_INTERATIVO_README.md)
- 🔌 [API Documentation](API_DOCUMENTATION.md)
- 📱 [Guia Android](ANDROID_INTEGRATION.md)
- 🏗️ [Arquitetura](ARCHITECTURE.md)
- 🌐 [Yii2 Docs](https://www.yiiframework.com/doc/guide/2.0/en)
- 🗺️ [Leaflet.js Docs](https://leafletjs.com/)

## Suporte

Para problemas ou dúvidas:

1. Verifique os logs:
   - `runtime/logs/app.log`
   - Logs do servidor web

2. Consulte a documentação do Yii2

3. Abra uma issue no GitHub

## Licença

Este projeto utiliza o Yii2 Framework sob licença BSD-3-Clause.

---

**Pronto!** Você agora tem um mapa interativo de Portugal funcionando! 🎉

Explore, personalize e divirta-se desenvolvendo! 🚀
