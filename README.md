# teste_mapa

Projeto de mapa interativo de Portugal com museus, monumentos e locais culturais.

## Características

- 🗺️ Mapa interativo usando Leaflet.js
- 📍 18+ locais culturais pré-cadastrados em Portugal
- 🔴 Marcadores coloridos por tipo (Museus, Monumentos, Locais Culturais)
- 🔍 Filtros por tipo e região
- 📱 API REST para integração com aplicações Android
- 🖥️ Interface web responsiva com Bootstrap 5

## Tecnologias

- **Backend**: Yii2 Framework (PHP)
- **Frontend**: HTML, CSS, JavaScript, Bootstrap 5
- **Mapa**: Leaflet.js
- **Banco de Dados**: MySQL/MariaDB

## Documentação Completa

Para instruções detalhadas de instalação, configuração, uso da API e integração com Android, consulte:

📖 [MAPA_INTERATIVO_README.md](MAPA_INTERATIVO_README.md)

## Quick Start

1. Configure o banco de dados em `yii2test/common/config/main-local.php`
2. Execute as migrações: `cd yii2test && php yii migrate`
3. Acesse o mapa: `http://seu-dominio/map/index`
4. API disponível em: `http://seu-dominio/api/cultural-sites`

## Estrutura do Projeto

```
yii2test/
├── backend/            # Backend e API REST
│   └── modules/api/    # Módulo API
├── frontend/           # Frontend web
│   ├── controllers/    # MapController
│   └── views/map/      # View do mapa interativo
├── common/
│   └── models/         # CulturalSite model
└── console/
    └── migrations/     # Migrações do banco de dados
```

## Licença

BSD-3-Clause (Yii2 Framework)