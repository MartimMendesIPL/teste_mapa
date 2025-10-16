# API REST - Documentação dos Endpoints

Base URL: `http://seu-dominio.com/api/cultural-sites`

## Índice

- [Autenticação](#autenticação)
- [Listagem](#listagem)
- [Consulta Individual](#consulta-individual)
- [Filtros](#filtros)
- [CRUD](#crud-create-read-update-delete)
- [Códigos de Status](#códigos-de-status)
- [Exemplos](#exemplos)

## Autenticação

Por padrão, a API é pública e não requer autenticação. Para adicionar autenticação, consulte a seção de Segurança na documentação principal.

## Listagem

### GET /api/cultural-sites

Lista todos os locais culturais com suporte a paginação e filtros.

**Query Parameters:**

| Parâmetro | Tipo | Descrição | Exemplo |
|-----------|------|-----------|---------|
| page | integer | Número da página (padrão: 1) | `?page=2` |
| per-page | integer | Itens por página (padrão: 50, máx: 100) | `?per-page=20` |
| type | string | Filtrar por tipo | `?type=museum` |
| city | string | Filtrar por cidade | `?city=Lisboa` |
| region | string | Filtrar por região | `?region=Porto` |

**Exemplo de Request:**

```bash
curl -X GET "http://seu-dominio.com/api/cultural-sites?type=museum&city=Lisboa"
```

**Exemplo de Response (200 OK):**

```json
[
  {
    "id": 3,
    "name": "Museu Nacional de Arte Antiga",
    "description": "O maior e mais importante museu de arte em Portugal...",
    "type": "museum",
    "latitude": "38.70400000",
    "longitude": "-9.16270000",
    "address": "Rua das Janelas Verdes, 1249-017 Lisboa",
    "phone": "+351 21 391 2800",
    "website": "http://www.museudearteantiga.pt",
    "image_url": null,
    "opening_hours": "10h-18h (Seg fechado)",
    "city": "Lisboa",
    "region": "Lisboa",
    "created_at": 1697554800,
    "updated_at": 1697554800
  }
]
```

## Consulta Individual

### GET /api/cultural-sites/{id}

Obtém detalhes de um local específico.

**Path Parameters:**

| Parâmetro | Tipo | Descrição |
|-----------|------|-----------|
| id | integer | ID do local cultural |

**Exemplo de Request:**

```bash
curl -X GET "http://seu-dominio.com/api/cultural-sites/1"
```

**Exemplo de Response (200 OK):**

```json
{
  "id": 1,
  "name": "Torre de Belém",
  "description": "Torre de defesa do século XVI, Património Mundial da UNESCO...",
  "type": "monument",
  "latitude": "38.69160000",
  "longitude": "-9.21600000",
  "address": "Av. Brasília, 1400-038 Lisboa",
  "phone": "+351 21 362 0034",
  "website": "http://www.torrebelem.pt",
  "image_url": null,
  "opening_hours": "10h-18h30 (Out-Abr até 17h30)",
  "city": "Lisboa",
  "region": "Lisboa",
  "created_at": 1697554800,
  "updated_at": 1697554800
}
```

**Response (404 Not Found):**

```json
{
  "name": "Not Found",
  "message": "Object not found: 999",
  "code": 0,
  "status": 404
}
```

## Filtros

### GET /api/cultural-sites/by-region/{region}

Lista locais por região.

**Path Parameters:**

| Parâmetro | Tipo | Descrição |
|-----------|------|-----------|
| region | string | Nome da região |

**Exemplo:**

```bash
curl -X GET "http://seu-dominio.com/api/cultural-sites/by-region/Lisboa"
```

---

### GET /api/cultural-sites/by-city/{city}

Lista locais por cidade.

**Path Parameters:**

| Parâmetro | Tipo | Descrição |
|-----------|------|-----------|
| city | string | Nome da cidade |

**Exemplo:**

```bash
curl -X GET "http://seu-dominio.com/api/cultural-sites/by-city/Porto"
```

---

### GET /api/cultural-sites/by-type/{type}

Lista locais por tipo.

**Path Parameters:**

| Parâmetro | Tipo | Descrição |
|-----------|------|-----------|
| type | string | Tipo: `museum`, `monument`, ou `cultural_site` |

**Exemplo:**

```bash
curl -X GET "http://seu-dominio.com/api/cultural-sites/by-type/museum"
```

---

### GET /api/cultural-sites/in-bounds

Lista locais dentro de uma área geográfica (bounding box).

**Query Parameters:**

| Parâmetro | Tipo | Obrigatório | Descrição |
|-----------|------|-------------|-----------|
| minLat | decimal | Sim | Latitude mínima |
| maxLat | decimal | Sim | Latitude máxima |
| minLng | decimal | Sim | Longitude mínima |
| maxLng | decimal | Sim | Longitude máxima |

**Exemplo:**

```bash
curl -X GET "http://seu-dominio.com/api/cultural-sites/in-bounds?minLat=38.5&maxLat=39.0&minLng=-9.5&maxLng=-9.0"
```

---

### GET /api/cultural-sites/count

Retorna o total de locais cadastrados.

**Exemplo de Request:**

```bash
curl -X GET "http://seu-dominio.com/api/cultural-sites/count"
```

**Exemplo de Response (200 OK):**

```json
{
  "count": 18
}
```

## CRUD (Create, Read, Update, Delete)

### POST /api/cultural-sites

Cria um novo local cultural.

**Headers:**

```
Content-Type: application/json
```

**Request Body:**

```json
{
  "name": "Museu do Azulejo",
  "description": "Museu dedicado à arte do azulejo em Portugal",
  "type": "museum",
  "latitude": 38.7370,
  "longitude": -9.1074,
  "address": "Rua Madre de Deus 4, 1900-312 Lisboa",
  "phone": "+351 21 810 0340",
  "website": "http://www.museudoazulejo.gov.pt",
  "opening_hours": "10h-18h (Seg fechado)",
  "city": "Lisboa",
  "region": "Lisboa"
}
```

**Campos Obrigatórios:**

- name
- type
- latitude
- longitude
- city
- region

**Exemplo de Request:**

```bash
curl -X POST "http://seu-dominio.com/api/cultural-sites" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Museu do Azulejo",
    "type": "museum",
    "latitude": 38.7370,
    "longitude": -9.1074,
    "city": "Lisboa",
    "region": "Lisboa"
  }'
```

**Exemplo de Response (201 Created):**

```json
{
  "id": 19,
  "name": "Museu do Azulejo",
  "description": "Museu dedicado à arte do azulejo em Portugal",
  "type": "museum",
  "latitude": "38.73700000",
  "longitude": "-9.10740000",
  "address": "Rua Madre de Deus 4, 1900-312 Lisboa",
  "phone": "+351 21 810 0340",
  "website": "http://www.museudoazulejo.gov.pt",
  "image_url": null,
  "opening_hours": "10h-18h (Seg fechado)",
  "city": "Lisboa",
  "region": "Lisboa",
  "created_at": 1697641200,
  "updated_at": 1697641200
}
```

**Response de Erro (422 Unprocessable Entity):**

```json
[
  {
    "field": "name",
    "message": "Name cannot be blank."
  },
  {
    "field": "type",
    "message": "Type is invalid."
  }
]
```

---

### PUT /api/cultural-sites/{id}

Atualiza um local existente.

**Path Parameters:**

| Parâmetro | Tipo | Descrição |
|-----------|------|-----------|
| id | integer | ID do local cultural |

**Headers:**

```
Content-Type: application/json
```

**Request Body:**

```json
{
  "name": "Torre de Belém - UNESCO",
  "description": "Torre de defesa do século XVI, atualizada com mais informações...",
  "opening_hours": "10h-19h (Out-Abr até 17h30)"
}
```

**Exemplo de Request:**

```bash
curl -X PUT "http://seu-dominio.com/api/cultural-sites/1" \
  -H "Content-Type: application/json" \
  -d '{
    "description": "Nova descrição mais detalhada"
  }'
```

**Exemplo de Response (200 OK):**

```json
{
  "id": 1,
  "name": "Torre de Belém - UNESCO",
  "description": "Torre de defesa do século XVI, atualizada com mais informações...",
  "type": "monument",
  "latitude": "38.69160000",
  "longitude": "-9.21600000",
  "address": "Av. Brasília, 1400-038 Lisboa",
  "phone": "+351 21 362 0034",
  "website": "http://www.torrebelem.pt",
  "image_url": null,
  "opening_hours": "10h-19h (Out-Abr até 17h30)",
  "city": "Lisboa",
  "region": "Lisboa",
  "created_at": 1697554800,
  "updated_at": 1697641500
}
```

---

### DELETE /api/cultural-sites/{id}

Deleta um local cultural.

**Path Parameters:**

| Parâmetro | Tipo | Descrição |
|-----------|------|-----------|
| id | integer | ID do local cultural |

**Exemplo de Request:**

```bash
curl -X DELETE "http://seu-dominio.com/api/cultural-sites/1"
```

**Response (204 No Content):**

Sem corpo na resposta. Status HTTP 204 indica sucesso.

**Response (404 Not Found):**

```json
{
  "name": "Not Found",
  "message": "Object not found: 1",
  "code": 0,
  "status": 404
}
```

## Códigos de Status

| Código | Descrição |
|--------|-----------|
| 200 OK | Requisição bem-sucedida |
| 201 Created | Recurso criado com sucesso |
| 204 No Content | Operação bem-sucedida sem conteúdo de resposta |
| 400 Bad Request | Requisição inválida |
| 404 Not Found | Recurso não encontrado |
| 422 Unprocessable Entity | Erro de validação |
| 500 Internal Server Error | Erro interno do servidor |

## Exemplos

### Cenário 1: Listar Todos os Museus de Lisboa

```bash
curl -X GET "http://seu-dominio.com/api/cultural-sites?type=museum&city=Lisboa"
```

### Cenário 2: Buscar Locais em uma Área Específica

```bash
# Buscar locais na região de Lisboa (coordenadas aproximadas)
curl -X GET "http://seu-dominio.com/api/cultural-sites/in-bounds?minLat=38.6&maxLat=38.8&minLng=-9.3&maxLng=-9.0"
```

### Cenário 3: Obter Detalhes de um Local e Atualizar

```bash
# 1. Obter detalhes
curl -X GET "http://seu-dominio.com/api/cultural-sites/1"

# 2. Atualizar horário de abertura
curl -X PUT "http://seu-dominio.com/api/cultural-sites/1" \
  -H "Content-Type: application/json" \
  -d '{"opening_hours": "9h-20h"}'
```

### Cenário 4: Criar Novo Local

```bash
curl -X POST "http://seu-dominio.com/api/cultural-sites" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Museu Calouste Gulbenkian",
    "description": "Museu de arte com coleção privada",
    "type": "museum",
    "latitude": 38.7376,
    "longitude": -9.1545,
    "address": "Av. de Berna 45A, 1067-001 Lisboa",
    "phone": "+351 21 782 3000",
    "website": "https://gulbenkian.pt/museu/",
    "opening_hours": "10h-18h (Ter fechado)",
    "city": "Lisboa",
    "region": "Lisboa"
  }'
```

## Tipos de Locais Válidos

| Valor | Descrição |
|-------|-----------|
| `museum` | Museus |
| `monument` | Monumentos históricos |
| `cultural_site` | Locais culturais (bibliotecas, palácios, etc.) |

## Regiões de Portugal

Exemplos de regiões válidas:

- Lisboa
- Porto
- Coimbra
- Alentejo
- Algarve
- Braga
- Entre outras regiões portuguesas

## Cidades Principais

Exemplos de cidades com locais cadastrados:

- Lisboa
- Porto
- Coimbra
- Évora
- Sintra
- Guimarães
- Braga
- Faro

## Rate Limiting

Atualmente não há limite de requisições implementado. Em produção, considere implementar rate limiting para proteger a API.

## CORS

A API deve ser configurada para aceitar requisições de origens diferentes (CORS) para permitir integração com aplicações web e mobile.

## Suporte

Para questões sobre a API, consulte a documentação completa em [MAPA_INTERATIVO_README.md](MAPA_INTERATIVO_README.md).

## Changelog

### v1.0.0 (2025-10-16)

- Lançamento inicial da API
- Endpoints CRUD completos
- Filtros por região, cidade, tipo
- Busca por área geográfica
- 18 locais culturais pré-cadastrados
