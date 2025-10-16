# Funcionalidades do Mapa Interativo

## Visão Geral

O sistema de mapa interativo oferece uma experiência rica e intuitiva para explorar locais culturais de Portugal.

## Interface Web

### 1. Página Principal do Mapa (`/map/index`)

```
┌─────────────────────────────────────────────────────────────────────┐
│ Navbar: [Home] [Mapa Cultural] [About] [Contact] [Login/Logout]    │
├─────────────────────────────────────────────────────────────────────┤
│                                                                      │
│  Mapa Interativo de Portugal - Museus, Monumentos e Locais Culturais│
│  ═══════════════════════════════════════════════════════════════   │
│                                                                      │
│  ┌──────────────────────────────────────────────────────────────┐  │
│  │ Filtros                                                       │  │
│  │ ┌─────────────────┐ ┌─────────────────┐ ┌──────────────┐   │  │
│  │ │Filtrar por Tipo:│ │Filtrar Região:  │ │              │   │  │
│  │ │ [Todos ▼]       │ │ [Ex: Lisboa]    │ │[Aplicar Filtro]  │
│  │ └─────────────────┘ └─────────────────┘ └──────────────┘   │  │
│  └──────────────────────────────────────────────────────────────┘  │
│                                                                      │
│  ┌──────────────────────────────────────────────────────────────┐  │
│  │                                                               │  │
│  │                 🗺️ MAPA INTERATIVO                          │  │
│  │                                                               │  │
│  │   🔴 Lisboa (Torre de Belém)                                 │  │
│  │   🔴 Lisboa (Jerónimos)                                      │  │
│  │   🟢 Porto (Livraria Lello)                                  │  │
│  │   🔵 Porto (Torre Clérigos)                                  │  │
│  │                                                               │  │
│  │   [+] [-]                        ┌────────────┐             │  │
│  │                                  │ Legenda:   │             │  │
│  │                                  │ 🔴 Museus  │             │  │
│  │                                  │ 🔵 Monumentos            │  │
│  │                                  │ 🟢 Locais  │             │  │
│  │                                  │   Culturais│             │  │
│  │                                  └────────────┘             │  │
│  └──────────────────────────────────────────────────────────────┘  │
│                                                                      │
│  Total de locais: 18                                                │
│                                                                      │
└─────────────────────────────────────────────────────────────────────┘
```

### 2. Popup ao Clicar em Marcador

```
┌────────────────────────────────────┐
│ Torre de Belém                  [×]│
├────────────────────────────────────┤
│ [Imagem do local]                  │
│                                    │
│ Torre de defesa do século XVI,     │
│ Património Mundial da UNESCO.      │
│ Construída no reinado de D.        │
│ Manuel I...                        │
│                                    │
│ Tipo: Monumento                    │
│ Cidade: Lisboa                     │
│ Região: Lisboa                     │
│ Endereço: Av. Brasília,            │
│           1400-038 Lisboa          │
│ Telefone: +351 21 362 0034         │
│ Horário: 10h-18h30                 │
│          (Out-Abr até 17h30)       │
│ Website: [Visitar ↗]               │
└────────────────────────────────────┘
```

## Funcionalidades Principais

### 🗺️ Visualização do Mapa

- **Tecnologia**: Leaflet.js com tiles do OpenStreetMap
- **Centralização**: Portugal (lat: 39.3999, lng: -8.2245)
- **Zoom inicial**: Nível 7 (visão geral do país)
- **Zoom máximo**: Nível 19 (visão de rua)

**Interações:**
- Arrastar para navegar
- Scroll para zoom
- Clique duplo para zoom rápido
- Clique direito para menu de contexto

### 📍 Marcadores Personalizados

**Cores por Tipo:**
- 🔴 **Vermelho** (#e74c3c): Museus
- 🔵 **Azul** (#3498db): Monumentos
- 🟢 **Verde** (#2ecc71): Locais Culturais

**Design:**
- Círculos com borda branca
- Sombra para destaque
- Tamanho: 25x25 pixels
- Animação ao adicionar

### 🔍 Sistema de Filtros

#### Filtro por Tipo

**Opções:**
- Todos (sem filtro)
- Museus
- Monumentos
- Locais Culturais

**Comportamento:**
- Filtragem instantânea
- Marcadores ocultados dinamicamente
- Ajuste automático de zoom para mostrar todos os resultados

#### Filtro por Região/Cidade

**Características:**
- Campo de texto livre
- Busca case-insensitive
- Busca em região E cidade
- Busca parcial (substring)

**Exemplos:**
- "Lisboa" → Mostra todos em Lisboa
- "Porto" → Mostra todos no Porto
- "Sin" → Mostra Sintra

### 💬 Popups Informativos

**Informações Exibidas:**
1. Nome do local (título destacado)
2. Imagem (se disponível)
3. Descrição completa
4. Tipo (traduzido)
5. Cidade
6. Região
7. Endereço completo
8. Telefone de contato
9. Horário de abertura
10. Link para website (abre em nova aba)

**Características:**
- Largura máxima: 300px
- Scroll automático se conteúdo muito grande
- Fechar com X ou clicando fora
- Animação suave de abertura

### 📊 Contador de Locais

**Funcionalidade:**
- Exibe total de locais visíveis
- Atualiza automaticamente ao filtrar
- Formato: "Total de locais: X"

### 🎨 Design Responsivo

**Bootstrap 5:**
- Mobile-first
- Grid system responsivo
- Breakpoints:
  - < 576px: Mobile
  - 576-768px: Tablet
  - 768-992px: Desktop pequeno
  - 992px+: Desktop grande

**Adaptações Mobile:**
- Filtros em coluna única
- Mapa com altura ajustável
- Touch-friendly (botões maiores)
- Popups adaptados à tela

## API REST para Android

### 📱 Endpoints Disponíveis

#### 1. Listagem Completa
```
GET /api/cultural-sites
```
**Retorna:** Array JSON com todos os locais
**Uso:** Carregar mapa inicial

#### 2. Busca por ID
```
GET /api/cultural-sites/{id}
```
**Retorna:** Objeto JSON de um local
**Uso:** Detalhes de um local específico

#### 3. Filtro por Região
```
GET /api/cultural-sites/by-region/Lisboa
```
**Retorna:** Array JSON filtrado
**Uso:** Filtro regional no app

#### 4. Filtro por Cidade
```
GET /api/cultural-sites/by-city/Porto
```
**Retorna:** Array JSON filtrado
**Uso:** Filtro por cidade no app

#### 5. Filtro por Tipo
```
GET /api/cultural-sites/by-type/museum
```
**Retorna:** Array JSON filtrado
**Uso:** Mostrar apenas museus/monumentos

#### 6. Busca Geográfica
```
GET /api/cultural-sites/in-bounds?minLat=38.5&maxLat=39.0&minLng=-9.5&maxLng=-9.0
```
**Retorna:** Array JSON de locais na área
**Uso:** Buscar locais próximos ou visíveis no mapa

#### 7. Contagem
```
GET /api/cultural-sites/count
```
**Retorna:** `{"count": 18}`
**Uso:** Estatísticas do app

#### 8. Criar Local (CRUD)
```
POST /api/cultural-sites
Content-Type: application/json

{
  "name": "Novo Museu",
  "type": "museum",
  "latitude": 38.7,
  "longitude": -9.1,
  "city": "Lisboa",
  "region": "Lisboa"
}
```
**Uso:** Adicionar novos locais pelo app

#### 9. Atualizar Local (CRUD)
```
PUT /api/cultural-sites/{id}
Content-Type: application/json

{
  "description": "Nova descrição"
}
```
**Uso:** Editar informações

#### 10. Deletar Local (CRUD)
```
DELETE /api/cultural-sites/{id}
```
**Uso:** Remover locais

### 📊 Formato de Resposta JSON

```json
{
  "id": 1,
  "name": "Torre de Belém",
  "description": "Torre de defesa do século XVI...",
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

## Locais Culturais Pré-cadastrados

### Lisboa (5 locais)

1. **Torre de Belém** (Monumento)
   - Lat/Lng: 38.6916, -9.2160
   - UNESCO World Heritage

2. **Mosteiro dos Jerónimos** (Monumento)
   - Lat/Lng: 38.6977, -9.2062
   - Arquitetura Manuelina

3. **Museu Nacional de Arte Antiga** (Museu)
   - Lat/Lng: 38.7040, -9.1627
   - Maior museu de arte de Portugal

4. **Castelo de São Jorge** (Monumento)
   - Lat/Lng: 38.7139, -9.1334
   - Vista panorâmica

5. **MAAT** (Museu)
   - Lat/Lng: 38.6957, -9.2053
   - Arte, Arquitetura e Tecnologia

### Porto (4 locais)

6. **Torre dos Clérigos** (Monumento)
   - Lat/Lng: 41.1459, -8.6144
   - Símbolo do Porto

7. **Museu Serralves** (Museu)
   - Lat/Lng: 41.1594, -8.6597
   - Arte contemporânea

8. **Palácio da Bolsa** (Local Cultural)
   - Lat/Lng: 41.1411, -8.6155
   - Salão Árabe

9. **Livraria Lello** (Local Cultural)
   - Lat/Lng: 41.1467, -8.6147
   - Uma das mais bonitas do mundo

### Coimbra (2 locais)

10. **Universidade de Coimbra** (Local Cultural)
    - Lat/Lng: 40.2074, -8.4274
    - UNESCO, fundada em 1290

11. **Mosteiro de Santa Clara-a-Velha** (Monumento)
    - Lat/Lng: 40.2022, -8.4390
    - Gótico, recuperado

### Évora (2 locais)

12. **Templo Romano de Évora** (Monumento)
    - Lat/Lng: 38.5742, -7.9073
    - UNESCO, século I

13. **Capela dos Ossos** (Local Cultural)
    - Lat/Lng: 38.5727, -7.9078
    - Século XVII

### Sintra (2 locais)

14. **Palácio da Pena** (Monumento)
    - Lat/Lng: 38.7876, -9.3905
    - UNESCO, Romantismo

15. **Quinta da Regaleira** (Local Cultural)
    - Lat/Lng: 38.7960, -9.3960
    - Poço Iniciático

### Guimarães (1 local)

16. **Castelo de Guimarães** (Monumento)
    - Lat/Lng: 41.4467, -8.2914
    - Berço da nacionalidade

### Braga (1 local)

17. **Bom Jesus do Monte** (Local Cultural)
    - Lat/Lng: 41.5547, -8.3770
    - UNESCO, escadaria barroca

### Faro (1 local)

18. **Centro Histórico de Faro** (Local Cultural)
    - Lat/Lng: 37.0174, -7.9304
    - Centro medieval

## Características Técnicas

### Performance

- **Carregamento inicial**: < 2 segundos
- **Resposta API**: < 200ms (local)
- **Renderização mapa**: Instantânea
- **Filtros**: Tempo real

### Segurança

- CSRF protection (Yii2)
- SQL injection protection (ActiveRecord)
- XSS protection (Html::encode)
- Input validation (Model rules)

### Acessibilidade

- Navegação por teclado
- Labels semânticos
- Alt text em imagens
- Contraste adequado

### SEO

- URLs amigáveis
- Meta tags
- Breadcrumbs
- Structured data (future)

## Expansões Futuras

### Website

- [ ] Galeria de fotos
- [ ] Sistema de avaliações
- [ ] Comentários de usuários
- [ ] Rotas turísticas
- [ ] Favoritos persistentes
- [ ] Compartilhamento social
- [ ] Modo noturno
- [ ] Múltiplos idiomas
- [ ] Pesquisa avançada
- [ ] Geolocalização do usuário

### API

- [ ] Autenticação JWT
- [ ] Rate limiting
- [ ] Versionamento
- [ ] Webhooks
- [ ] GraphQL alternative
- [ ] Busca full-text
- [ ] Agregações/estatísticas
- [ ] Export (CSV, PDF)

### Mobile

- [ ] Navegação até o local
- [ ] AR (Realidade Aumentada)
- [ ] Notificações push
- [ ] Modo offline
- [ ] Gamificação
- [ ] QR codes
- [ ] Tours guiados por áudio

## Suporte

Para mais informações, consulte:
- [QUICK_START.md](QUICK_START.md) - Guia de início rápido
- [MAPA_INTERATIVO_README.md](MAPA_INTERATIVO_README.md) - Documentação completa
- [API_DOCUMENTATION.md](API_DOCUMENTATION.md) - Documentação da API
- [ANDROID_INTEGRATION.md](ANDROID_INTEGRATION.md) - Guia Android
- [ARCHITECTURE.md](ARCHITECTURE.md) - Arquitetura do sistema
