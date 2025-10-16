# Mapa Interativo de Portugal - Documentação

## Visão Geral

Este projeto implementa um mapa interativo de Portugal com museus, monumentos e locais culturais. A solução utiliza:

- **Framework**: Yii2 Advanced Application Template
- **Backend**: PHP com Yii2
- **Frontend**: HTML, CSS, JavaScript, Bootstrap 5
- **Mapa**: Leaflet.js (biblioteca open-source para mapas interativos)
- **API REST**: Para integração com aplicações mobile Android

## Estrutura do Projeto

### 1. Banco de Dados

#### Tabela: `cultural_sites`

Armazena informações sobre os locais culturais:

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | INT | Chave primária auto-incremento |
| name | VARCHAR(255) | Nome do local |
| description | TEXT | Descrição detalhada |
| type | VARCHAR(100) | Tipo: 'museum', 'monument', 'cultural_site' |
| latitude | DECIMAL(10,8) | Coordenada de latitude |
| longitude | DECIMAL(11,8) | Coordenada de longitude |
| address | VARCHAR(500) | Endereço completo |
| phone | VARCHAR(50) | Telefone de contato |
| website | VARCHAR(500) | URL do website |
| image_url | VARCHAR(500) | URL da imagem |
| opening_hours | VARCHAR(500) | Horário de funcionamento |
| city | VARCHAR(100) | Cidade |
| region | VARCHAR(100) | Região de Portugal |
| created_at | INT | Timestamp de criação |
| updated_at | INT | Timestamp de atualização |

### 2. Modelos (Models)

#### `common/models/CulturalSite.php`

Modelo ActiveRecord que representa a tabela `cultural_sites`:

```php
// Exemplo de uso
$site = new CulturalSite();
$site->name = 'Torre de Belém';
$site->type = 'monument';
$site->city = 'Lisboa';
// ... outros campos
$site->save();

// Consultas
$sites = CulturalSite::getByRegion('Lisboa');
$museums = CulturalSite::getByType('museum');
```

### 3. API REST para Android

#### Endpoints Disponíveis

Base URL: `http://seu-dominio/api/cultural-sites`

##### 1. Listar todos os locais
```
GET /api/cultural-sites
```

Resposta:
```json
[
  {
    "id": 1,
    "name": "Torre de Belém",
    "description": "Torre de defesa do século XVI...",
    "type": "monument",
    "latitude": "38.69160000",
    "longitude": "-9.21600000",
    "city": "Lisboa",
    "region": "Lisboa",
    ...
  }
]
```

##### 2. Obter local específico
```
GET /api/cultural-sites/{id}
```

##### 3. Criar novo local
```
POST /api/cultural-sites
Content-Type: application/json

{
  "name": "Nome do Local",
  "type": "museum",
  "latitude": 38.7,
  "longitude": -9.1,
  "city": "Lisboa",
  "region": "Lisboa"
}
```

##### 4. Atualizar local
```
PUT /api/cultural-sites/{id}
Content-Type: application/json

{
  "name": "Novo Nome",
  "description": "Nova descrição"
}
```

##### 5. Deletar local
```
DELETE /api/cultural-sites/{id}
```

##### 6. Filtrar por região
```
GET /api/cultural-sites/by-region/{region}
```

Exemplo: `/api/cultural-sites/by-region/Lisboa`

##### 7. Filtrar por cidade
```
GET /api/cultural-sites/by-city/{city}
```

Exemplo: `/api/cultural-sites/by-city/Porto`

##### 8. Filtrar por tipo
```
GET /api/cultural-sites/by-type/{type}
```

Tipos válidos: `museum`, `monument`, `cultural_site`

Exemplo: `/api/cultural-sites/by-type/museum`

##### 9. Buscar por área geográfica (bounding box)
```
GET /api/cultural-sites/in-bounds?minLat=38.5&maxLat=39.0&minLng=-9.5&maxLng=-9.0
```

##### 10. Contar total de locais
```
GET /api/cultural-sites/count
```

Resposta:
```json
{
  "count": 18
}
```

#### Filtros Query String

Na listagem geral (`GET /api/cultural-sites`), você pode usar parâmetros:

```
GET /api/cultural-sites?type=museum&city=Lisboa&region=Lisboa
```

### 4. Frontend Web

#### Página do Mapa

URL: `http://seu-dominio/map/index`

**Características:**

- Mapa interativo centrado em Portugal
- Marcadores coloridos por tipo:
  - 🔴 Vermelho: Museus
  - 🔵 Azul: Monumentos
  - 🟢 Verde: Locais Culturais
- Popup com informações detalhadas ao clicar
- Filtros por tipo e região
- Legenda explicativa
- Contador de locais exibidos

**Tecnologias:**

- Leaflet.js para renderização do mapa
- OpenStreetMap para tiles do mapa
- Bootstrap 5 para layout responsivo
- jQuery para interações

### 5. Integração com Android

#### Exemplo de Código Android (Retrofit)

```java
public interface CulturalSiteApi {
    @GET("api/cultural-sites")
    Call<List<CulturalSite>> getAllSites();
    
    @GET("api/cultural-sites/{id}")
    Call<CulturalSite> getSite(@Path("id") int id);
    
    @GET("api/cultural-sites/by-region/{region}")
    Call<List<CulturalSite>> getSitesByRegion(@Path("region") String region);
    
    @GET("api/cultural-sites/by-type/{type}")
    Call<List<CulturalSite>> getSitesByType(@Path("type") String type);
    
    @POST("api/cultural-sites")
    Call<CulturalSite> createSite(@Body CulturalSite site);
    
    @PUT("api/cultural-sites/{id}")
    Call<CulturalSite> updateSite(@Path("id") int id, @Body CulturalSite site);
    
    @DELETE("api/cultural-sites/{id}")
    Call<Void> deleteSite(@Path("id") int id);
}

// Classe modelo
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
    
    // Getters e Setters
}
```

#### Exemplo de Uso

```java
Retrofit retrofit = new Retrofit.Builder()
    .baseUrl("http://seu-dominio/")
    .addConverterFactory(GsonConverterFactory.create())
    .build();

CulturalSiteApi api = retrofit.create(CulturalSiteApi.class);

// Obter todos os museus
Call<List<CulturalSite>> call = api.getSitesByType("museum");
call.enqueue(new Callback<List<CulturalSite>>() {
    @Override
    public void onResponse(Call<List<CulturalSite>> call, Response<List<CulturalSite>> response) {
        if (response.isSuccessful()) {
            List<CulturalSite> museums = response.body();
            // Processar dados
        }
    }
    
    @Override
    public void onFailure(Call<List<CulturalSite>> call, Throwable t) {
        // Tratar erro
    }
});
```

## Instalação e Configuração

### Pré-requisitos

- PHP >= 7.4
- MySQL/MariaDB
- Composer
- Servidor web (Apache/Nginx)

### Passos de Instalação

1. **Configure o banco de dados**

Edite `yii2test/common/config/main-local.php`:

```php
'db' => [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=teste_mapa',
    'username' => 'seu_usuario',
    'password' => 'sua_senha',
    'charset' => 'utf8',
],
```

2. **Execute as migrações**

```bash
cd yii2test
php yii migrate
```

Isso criará a tabela `cultural_sites` e inserirá os dados de exemplo.

3. **Configure o servidor web**

Aponte o document root para `yii2test/frontend/web` (frontend) ou `yii2test/backend/web` (backend/API).

4. **Habilite URL amigáveis**

Para Apache, certifique-se de que o mod_rewrite está ativado.

Para Nginx, adicione:

```nginx
location / {
    try_files $uri $uri/ /index.php?$args;
}
```

5. **Teste a instalação**

- Frontend: `http://seu-dominio/map/index`
- API: `http://seu-dominio/api/cultural-sites`

## Dados de Exemplo

O sistema já vem com 18 locais culturais pré-cadastrados:

### Lisboa (5 locais)
- Torre de Belém (Monumento)
- Mosteiro dos Jerónimos (Monumento)
- Museu Nacional de Arte Antiga (Museu)
- Castelo de São Jorge (Monumento)
- MAAT (Museu)

### Porto (4 locais)
- Torre dos Clérigos (Monumento)
- Museu Serralves (Museu)
- Palácio da Bolsa (Local Cultural)
- Livraria Lello (Local Cultural)

### Outras Regiões (9 locais)
- Coimbra: Universidade de Coimbra, Mosteiro de Santa Clara-a-Velha
- Évora: Templo Romano, Capela dos Ossos
- Sintra: Palácio da Pena, Quinta da Regaleira
- Guimarães: Castelo de Guimarães
- Braga: Bom Jesus do Monte
- Faro: Centro Histórico de Faro

## Personalização

### Adicionar Novos Tipos de Locais

1. Edite o modelo `CulturalSite.php`:

```php
[['type'], 'in', 'range' => ['museum', 'monument', 'cultural_site', 'novo_tipo']],
```

2. Adicione cor no CSS da view `map/index.php`:

```css
.legend .novo_tipo { background-color: #cor; }
```

3. Atualize a função JavaScript `getMarkerColor`:

```javascript
case 'novo_tipo': return '#cor';
```

### Adicionar Novos Campos

1. Crie uma migration:

```php
php yii migrate/create add_campo_to_cultural_sites
```

2. Adicione o campo no modelo e nas validações

3. Atualize as views conforme necessário

## Segurança

### Autenticação da API

Para proteger a API, adicione autenticação no controller:

```php
public function behaviors()
{
    $behaviors = parent::behaviors();
    $behaviors['authenticator'] = [
        'class' => HttpBearerAuth::class,
    ];
    return $behaviors;
}
```

### CORS para Android

Para permitir requisições do Android, adicione no controller:

```php
public function behaviors()
{
    $behaviors = parent::behaviors();
    $behaviors['corsFilter'] = [
        'class' => \yii\filters\Cors::class,
        'cors' => [
            'Origin' => ['*'],
            'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
            'Access-Control-Request-Headers' => ['*'],
        ],
    ];
    return $behaviors;
}
```

## Manutenção

### Adicionar Novos Locais via Admin

Você pode criar um CRUD no backend para gerenciar os locais culturais:

```bash
cd yii2test
php yii gii/crud --modelClass=common\\models\\CulturalSite --controllerClass=backend\\controllers\\CulturalSiteController
```

### Backup do Banco de Dados

```bash
mysqldump -u usuario -p teste_mapa cultural_sites > backup_cultural_sites.sql
```

## Troubleshooting

### Erro: "Class 'common\models\CulturalSite' not found"

Execute: `composer dump-autoload`

### Mapa não carrega

Verifique:
- Console do navegador para erros JavaScript
- Se o Leaflet.js está carregando corretamente
- Se os dados JSON estão sendo passados para a view

### API retorna 404

Verifique:
- URL Manager está configurado corretamente
- mod_rewrite (Apache) ou try_files (Nginx) está configurado
- O módulo API está registrado no backend config

## Recursos Adicionais

- [Documentação Yii2](https://www.yiiframework.com/doc/guide/2.0/en)
- [Documentação Leaflet.js](https://leafletjs.com/reference.html)
- [API REST Best Practices](https://restfulapi.net/)

## Suporte

Para questões e suporte, consulte a documentação do Yii2 ou abra uma issue no repositório.

## Licença

Este projeto utiliza o Yii2 Framework sob licença BSD-3-Clause.
