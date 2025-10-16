# Arquitetura do Sistema - Mapa Interativo de Portugal

## Visão Geral da Arquitetura

```
┌─────────────────────────────────────────────────────────────────┐
│                        Camada de Apresentação                    │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│  ┌──────────────────┐              ┌────────────────────────┐   │
│  │   Website Yii2   │              │  Aplicação Android     │   │
│  │   (Frontend)     │              │                        │   │
│  │                  │              │  - Google Maps         │   │
│  │  - Leaflet.js    │              │  - Retrofit HTTP       │   │
│  │  - Bootstrap 5   │              │  - Gson JSON           │   │
│  │  - jQuery        │              │                        │   │
│  └────────┬─────────┘              └───────────┬────────────┘   │
│           │                                    │                 │
└───────────┼────────────────────────────────────┼─────────────────┘
            │                                    │
            │ Direct DB Access                   │ HTTP REST
            │                                    │
┌───────────▼────────────────────────────────────▼─────────────────┐
│                      Camada de Aplicação                          │
├───────────────────────────────────────────────────────────────────┤
│                                                                   │
│  ┌───────────────────────────┐    ┌─────────────────────────┐   │
│  │  Frontend Controllers     │    │   Backend API Module    │   │
│  │                           │    │                         │   │
│  │  - MapController          │    │  - CulturalSiteController  │
│  │    • actionIndex()        │    │    • CRUD Operations     │   │
│  │    • actionGetByRegion()  │    │    • Filter Endpoints   │   │
│  │    • actionGetByType()    │    │    • Geolocation Query  │   │
│  │    • actionGetByCity()    │    │                         │   │
│  └───────────┬───────────────┘    └────────────┬────────────┘   │
│              │                                  │                │
│              └──────────────┬───────────────────┘                │
│                             │                                    │
│                  ┌──────────▼──────────┐                         │
│                  │  Common Models      │                         │
│                  │                     │                         │
│                  │  - CulturalSite     │                         │
│                  │    • Validation     │                         │
│                  │    • Behaviors      │                         │
│                  │    • Query Methods  │                         │
│                  └──────────┬──────────┘                         │
│                             │                                    │
└─────────────────────────────┼────────────────────────────────────┘
                              │
┌─────────────────────────────▼────────────────────────────────────┐
│                      Camada de Dados                              │
├───────────────────────────────────────────────────────────────────┤
│                                                                   │
│                   ┌────────────────────┐                          │
│                   │  MySQL Database    │                          │
│                   │                    │                          │
│                   │  cultural_sites    │                          │
│                   │  ├─ id             │                          │
│                   │  ├─ name           │                          │
│                   │  ├─ description    │                          │
│                   │  ├─ type           │                          │
│                   │  ├─ latitude       │                          │
│                   │  ├─ longitude      │                          │
│                   │  ├─ address        │                          │
│                   │  ├─ phone          │                          │
│                   │  ├─ website        │                          │
│                   │  ├─ image_url      │                          │
│                   │  ├─ opening_hours  │                          │
│                   │  ├─ city           │                          │
│                   │  ├─ region         │                          │
│                   │  ├─ created_at     │                          │
│                   │  └─ updated_at     │                          │
│                   └────────────────────┘                          │
│                                                                   │
└───────────────────────────────────────────────────────────────────┘
```

## Fluxo de Dados

### 1. Website (Acesso Direto ao Banco de Dados)

```
Usuário → MapController → CulturalSite Model → Database → JSON → Leaflet.js → Mapa
```

**Passos:**
1. Usuário acessa `/map/index`
2. `MapController::actionIndex()` busca todos os locais do banco
3. Dados convertidos para JSON
4. View renderiza HTML com JavaScript
5. Leaflet.js cria marcadores no mapa
6. Usuário interage com filtros
7. JavaScript filtra marcadores localmente ou faz nova requisição AJAX

### 2. Aplicação Android (via API REST)

```
App Android → HTTP Request → API Endpoint → CulturalSite Model → Database → JSON Response → App Android
```

**Passos:**
1. App faz requisição HTTP GET para `/api/cultural-sites`
2. Yii2 roteia para `CulturalSiteController::actionIndex()`
3. Controller busca dados via Model
4. Dados serializados para JSON automaticamente (REST)
5. Response retornado ao app
6. Retrofit converte JSON para objetos Java
7. App exibe marcadores no Google Maps

## Componentes Principais

### Frontend (Website)

| Componente | Tecnologia | Responsabilidade |
|------------|------------|------------------|
| Layout | Bootstrap 5 | Interface responsiva |
| Mapa | Leaflet.js | Renderização do mapa interativo |
| Interações | jQuery | Filtros e eventos |
| Tiles | OpenStreetMap | Mapas base |

### Backend API

| Componente | Tecnologia | Responsabilidade |
|------------|------------|------------------|
| Framework | Yii2 | Estrutura MVC e roteamento |
| REST | ActiveController | CRUD automático |
| Serialização | JSON | Formato de resposta |
| Validação | Model Rules | Validação de dados |

### Android

| Componente | Tecnologia | Responsabilidade |
|------------|------------|------------------|
| HTTP Client | Retrofit | Requisições à API |
| JSON Parser | Gson | Conversão JSON ↔ Java |
| Mapa | Google Maps | Exibição de mapa e marcadores |
| UI | Material Design | Interface do usuário |

## Endpoints da API

### Endpoints REST Padrão

| Método | Endpoint | Ação |
|--------|----------|------|
| GET | `/api/cultural-sites` | Listar todos |
| GET | `/api/cultural-sites/{id}` | Ver um |
| POST | `/api/cultural-sites` | Criar |
| PUT | `/api/cultural-sites/{id}` | Atualizar |
| DELETE | `/api/cultural-sites/{id}` | Deletar |

### Endpoints Personalizados

| Método | Endpoint | Ação |
|--------|----------|------|
| GET | `/api/cultural-sites/count` | Contar total |
| GET | `/api/cultural-sites/by-region/{region}` | Filtrar por região |
| GET | `/api/cultural-sites/by-city/{city}` | Filtrar por cidade |
| GET | `/api/cultural-sites/by-type/{type}` | Filtrar por tipo |
| GET | `/api/cultural-sites/in-bounds` | Busca geográfica |

## Modelos de Dados

### CulturalSite (PHP - Yii2 ActiveRecord)

```php
class CulturalSite extends \yii\db\ActiveRecord
{
    // Propriedades mapeadas da tabela
    public $id;
    public $name;
    public $description;
    public $type; // 'museum', 'monument', 'cultural_site'
    public $latitude;
    public $longitude;
    public $address;
    public $phone;
    public $website;
    public $image_url;
    public $opening_hours;
    public $city;
    public $region;
    public $created_at;
    public $updated_at;
    
    // Behaviors
    - TimestampBehavior (auto-atualiza created_at/updated_at)
    
    // Validações
    - Campos obrigatórios: name, type, latitude, longitude, city, region
    - Type deve ser: museum, monument, ou cultural_site
    - Latitude: decimal(10,8)
    - Longitude: decimal(11,8)
}
```

### CulturalSite (Java - Android)

```java
public class CulturalSite {
    private int id;
    private String name;
    private String description;
    private String type;
    private double latitude;
    private double longitude;
    private String address;
    private String phone;
    private String website;
    private String imageUrl;
    private String openingHours;
    private String city;
    private String region;
    // getters e setters
}
```

## Padrões de Design Utilizados

### 1. MVC (Model-View-Controller)

- **Model**: `CulturalSite` - Lógica de negócio e acesso a dados
- **View**: Arquivos `.php` em `views/` - Apresentação
- **Controller**: `MapController`, `CulturalSiteController` - Controle de fluxo

### 2. Active Record

- Cada instância de `CulturalSite` representa uma linha na tabela
- Métodos como `save()`, `find()`, `delete()` encapsulam SQL

### 3. RESTful API

- Recursos identificados por URLs
- Métodos HTTP semânticos (GET, POST, PUT, DELETE)
- Respostas em JSON
- Stateless (sem sessão)

### 4. Repository Pattern (implícito no ActiveRecord)

- Model abstrai o acesso ao banco de dados
- Controllers não precisam saber detalhes de SQL

### 5. Dependency Injection (Yii2)

- Componentes injetados via container DI
- Facilita testes e manutenção

## Segurança

### Proteções Implementadas

1. **CSRF Protection** (Yii2 padrão)
   - Tokens CSRF para formulários

2. **SQL Injection** (ActiveRecord)
   - Prepared statements automáticos
   - Escaping de parâmetros

3. **XSS Protection**
   - `Html::encode()` em todas as views
   - Sanitização de output

### Recomendações para Produção

1. **Autenticação da API**
   ```php
   'authenticator' => [
       'class' => HttpBearerAuth::class,
   ]
   ```

2. **HTTPS**
   - SSL/TLS obrigatório em produção

3. **Rate Limiting**
   ```php
   'rateLimiter' => [
       'class' => RateLimiter::class,
       'maxRequests' => 100,
       'period' => 3600,
   ]
   ```

4. **CORS Controlado**
   - Permitir apenas domínios específicos
   - Headers apropriados

## Escalabilidade

### Otimizações Implementadas

1. **Índices no Banco de Dados**
   - `idx-cultural_sites-city`
   - `idx-cultural_sites-region`
   - `idx-cultural_sites-type`

2. **Paginação**
   - API retorna no máximo 50 itens por página
   - Evita sobrecarga de memória

### Melhorias Futuras

1. **Cache**
   - Redis/Memcached para dados frequentes
   - Cache de queries complexas

2. **CDN**
   - Assets estáticos (CSS, JS, imagens)
   - Leaflet.js via CDN

3. **Load Balancer**
   - Múltiplos servidores backend
   - Distribuição de carga

4. **Database Replication**
   - Master-Slave replication
   - Leitura distribuída

## Manutenção e Monitoramento

### Logs

1. **Yii2 Logs**
   - `runtime/logs/app.log`
   - Erros, warnings, info

2. **Servidor Web**
   - Apache/Nginx access logs
   - Error logs

### Métricas Recomendadas

1. **Performance**
   - Tempo de resposta da API
   - Tempo de carregamento do mapa
   - Queries lentas

2. **Uso**
   - Total de requisições
   - Endpoints mais usados
   - Erros 4xx/5xx

3. **Recursos**
   - CPU usage
   - Memória
   - Espaço em disco

## Testes

### Estratégia de Testes

1. **Unit Tests**
   - Testar métodos do Model
   - Validações
   - Query methods

2. **Functional Tests**
   - Testar Controllers
   - Requisições HTTP
   - Respostas JSON

3. **Integration Tests**
   - Testar fluxo completo
   - API → Model → Database

### Exemplo de Teste (Codeception)

```php
public function testCreateCulturalSite()
{
    $site = new CulturalSite([
        'name' => 'Teste',
        'type' => 'museum',
        'latitude' => 38.7,
        'longitude' => -9.1,
        'city' => 'Lisboa',
        'region' => 'Lisboa',
    ]);
    
    $this->assertTrue($site->save());
    $this->assertNotNull($site->id);
}
```

## Deployment

### Checklist de Deploy

- [ ] Configurar variáveis de ambiente
- [ ] Executar migrações (`php yii migrate`)
- [ ] Configurar servidor web (Apache/Nginx)
- [ ] Configurar SSL/TLS
- [ ] Configurar permissões de arquivos
- [ ] Testar todos os endpoints
- [ ] Verificar logs
- [ ] Configurar backup automático
- [ ] Configurar monitoramento

### Ambientes

1. **Desenvolvimento**
   - Debug ativado
   - Logs detalhados
   - Dados de teste

2. **Staging**
   - Cópia da produção
   - Testes finais
   - QA

3. **Produção**
   - Debug desativado
   - Logs críticos apenas
   - Dados reais
   - HTTPS obrigatório
   - Backup automático

## Conclusão

Esta arquitetura fornece:

✅ Separação clara de responsabilidades  
✅ Escalabilidade horizontal e vertical  
✅ Manutenibilidade através de código limpo  
✅ Segurança em múltiplas camadas  
✅ Flexibilidade para expansão futura  
✅ Suporte para múltiplas plataformas (Web + Mobile)  

Para mais detalhes, consulte:
- [MAPA_INTERATIVO_README.md](MAPA_INTERATIVO_README.md)
- [API_DOCUMENTATION.md](API_DOCUMENTATION.md)
- [ANDROID_INTEGRATION.md](ANDROID_INTEGRATION.md)
