# Guia de Integração Android

Este guia explica como integrar a API de locais culturais com sua aplicação Android.

## Configuração Inicial

### 1. Adicionar Dependências (build.gradle)

```gradle
dependencies {
    // Retrofit para chamadas HTTP
    implementation 'com.squareup.retrofit2:retrofit:2.9.0'
    implementation 'com.squareup.retrofit2:converter-gson:2.9.0'
    
    // OkHttp para logging (opcional, mas recomendado)
    implementation 'com.squareup.okhttp3:logging-interceptor:4.9.0'
    
    // Google Maps (se for usar mapas)
    implementation 'com.google.android.gms:play-services-maps:18.1.0'
}
```

### 2. Permissões (AndroidManifest.xml)

```xml
<uses-permission android:name="android.permission.INTERNET" />
<uses-permission android:name="android.permission.ACCESS_FINE_LOCATION" />
<uses-permission android:name="android.permission.ACCESS_COARSE_LOCATION" />
```

## Estrutura do Código

### 1. Modelo de Dados (CulturalSite.java)

```java
package com.example.mapapp.models;

import com.google.gson.annotations.SerializedName;

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
    
    @SerializedName("image_url")
    private String imageUrl;
    
    @SerializedName("opening_hours")
    private String openingHours;
    
    private String city;
    private String region;
    
    @SerializedName("created_at")
    private long createdAt;
    
    @SerializedName("updated_at")
    private long updatedAt;

    // Getters
    public int getId() { return id; }
    public String getName() { return name; }
    public String getDescription() { return description; }
    public String getType() { return type; }
    public double getLatitude() { return latitude; }
    public double getLongitude() { return longitude; }
    public String getAddress() { return address; }
    public String getPhone() { return phone; }
    public String getWebsite() { return website; }
    public String getImageUrl() { return imageUrl; }
    public String getOpeningHours() { return openingHours; }
    public String getCity() { return city; }
    public String getRegion() { return region; }
    
    // Setters
    public void setName(String name) { this.name = name; }
    public void setDescription(String description) { this.description = description; }
    public void setType(String type) { this.type = type; }
    public void setLatitude(double latitude) { this.latitude = latitude; }
    public void setLongitude(double longitude) { this.longitude = longitude; }
    public void setAddress(String address) { this.address = address; }
    public void setPhone(String phone) { this.phone = phone; }
    public void setWebsite(String website) { this.website = website; }
    public void setImageUrl(String imageUrl) { this.imageUrl = imageUrl; }
    public void setOpeningHours(String openingHours) { this.openingHours = openingHours; }
    public void setCity(String city) { this.city = city; }
    public void setRegion(String region) { this.region = region; }
    
    // Método auxiliar para obter label do tipo em português
    public String getTypeLabel() {
        switch (type) {
            case "museum": return "Museu";
            case "monument": return "Monumento";
            case "cultural_site": return "Local Cultural";
            default: return type;
        }
    }
}
```

### 2. Interface da API (CulturalSiteApi.java)

```java
package com.example.mapapp.api;

import com.example.mapapp.models.CulturalSite;
import java.util.List;
import retrofit2.Call;
import retrofit2.http.*;

public interface CulturalSiteApi {
    
    // Listar todos os locais
    @GET("api/cultural-sites")
    Call<List<CulturalSite>> getAllSites();
    
    // Obter local específico
    @GET("api/cultural-sites/{id}")
    Call<CulturalSite> getSite(@Path("id") int id);
    
    // Filtrar por região
    @GET("api/cultural-sites/by-region/{region}")
    Call<List<CulturalSite>> getSitesByRegion(@Path("region") String region);
    
    // Filtrar por cidade
    @GET("api/cultural-sites/by-city/{city}")
    Call<List<CulturalSite>> getSitesByCity(@Path("city") String city);
    
    // Filtrar por tipo
    @GET("api/cultural-sites/by-type/{type}")
    Call<List<CulturalSite>> getSitesByType(@Path("type") String type);
    
    // Buscar por área (bounding box)
    @GET("api/cultural-sites/in-bounds")
    Call<List<CulturalSite>> getSitesInBounds(
        @Query("minLat") double minLat,
        @Query("maxLat") double maxLat,
        @Query("minLng") double minLng,
        @Query("maxLng") double maxLng
    );
    
    // Contar locais
    @GET("api/cultural-sites/count")
    Call<CountResponse> getCount();
    
    // Criar novo local
    @POST("api/cultural-sites")
    Call<CulturalSite> createSite(@Body CulturalSite site);
    
    // Atualizar local
    @PUT("api/cultural-sites/{id}")
    Call<CulturalSite> updateSite(@Path("id") int id, @Body CulturalSite site);
    
    // Deletar local
    @DELETE("api/cultural-sites/{id}")
    Call<Void> deleteSite(@Path("id") int id);
    
    // Classe auxiliar para resposta de contagem
    class CountResponse {
        private int count;
        public int getCount() { return count; }
    }
}
```

### 3. Cliente Retrofit (ApiClient.java)

```java
package com.example.mapapp.api;

import okhttp3.OkHttpClient;
import okhttp3.logging.HttpLoggingInterceptor;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class ApiClient {
    private static final String BASE_URL = "http://seu-dominio.com/";
    private static Retrofit retrofit = null;
    
    public static Retrofit getClient() {
        if (retrofit == null) {
            // Logging interceptor para debug
            HttpLoggingInterceptor logging = new HttpLoggingInterceptor();
            logging.setLevel(HttpLoggingInterceptor.Level.BODY);
            
            OkHttpClient client = new OkHttpClient.Builder()
                .addInterceptor(logging)
                .build();
            
            retrofit = new Retrofit.Builder()
                .baseUrl(BASE_URL)
                .client(client)
                .addConverterFactory(GsonConverterFactory.create())
                .build();
        }
        return retrofit;
    }
    
    public static CulturalSiteApi getApi() {
        return getClient().create(CulturalSiteApi.class);
    }
}
```

### 4. Activity com Mapa (MapsActivity.java)

```java
package com.example.mapapp;

import android.os.Bundle;
import android.util.Log;
import android.widget.Toast;
import androidx.appcompat.app.AppCompatActivity;
import com.example.mapapp.api.ApiClient;
import com.example.mapapp.api.CulturalSiteApi;
import com.example.mapapp.models.CulturalSite;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;
import java.util.List;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class MapsActivity extends AppCompatActivity implements OnMapReadyCallback {
    
    private static final String TAG = "MapsActivity";
    private GoogleMap mMap;
    private CulturalSiteApi api;
    
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_maps);
        
        // Inicializar API
        api = ApiClient.getApi();
        
        // Obter o mapa
        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager()
                .findFragmentById(R.id.map);
        if (mapFragment != null) {
            mapFragment.getMapAsync(this);
        }
    }
    
    @Override
    public void onMapReady(GoogleMap googleMap) {
        mMap = googleMap;
        
        // Centralizar em Portugal
        LatLng portugal = new LatLng(39.3999, -8.2245);
        mMap.moveCamera(CameraUpdateFactory.newLatLngZoom(portugal, 7));
        
        // Carregar locais culturais
        loadCulturalSites();
    }
    
    private void loadCulturalSites() {
        Call<List<CulturalSite>> call = api.getAllSites();
        
        call.enqueue(new Callback<List<CulturalSite>>() {
            @Override
            public void onResponse(Call<List<CulturalSite>> call, Response<List<CulturalSite>> response) {
                if (response.isSuccessful() && response.body() != null) {
                    List<CulturalSite> sites = response.body();
                    Log.d(TAG, "Carregados " + sites.size() + " locais");
                    
                    // Adicionar marcadores no mapa
                    for (CulturalSite site : sites) {
                        addMarker(site);
                    }
                    
                    Toast.makeText(MapsActivity.this, 
                        "Carregados " + sites.size() + " locais", 
                        Toast.LENGTH_SHORT).show();
                } else {
                    Log.e(TAG, "Erro na resposta: " + response.code());
                    Toast.makeText(MapsActivity.this, 
                        "Erro ao carregar locais", 
                        Toast.LENGTH_SHORT).show();
                }
            }
            
            @Override
            public void onFailure(Call<List<CulturalSite>> call, Throwable t) {
                Log.e(TAG, "Erro na requisição", t);
                Toast.makeText(MapsActivity.this, 
                    "Erro de conexão: " + t.getMessage(), 
                    Toast.LENGTH_SHORT).show();
            }
        });
    }
    
    private void addMarker(CulturalSite site) {
        LatLng position = new LatLng(site.getLatitude(), site.getLongitude());
        
        // Cor do marcador baseada no tipo
        float markerColor = getMarkerColor(site.getType());
        
        MarkerOptions markerOptions = new MarkerOptions()
            .position(position)
            .title(site.getName())
            .snippet(site.getTypeLabel() + " - " + site.getCity())
            .icon(BitmapDescriptorFactory.defaultMarker(markerColor));
        
        mMap.addMarker(markerOptions);
    }
    
    private float getMarkerColor(String type) {
        switch (type) {
            case "museum":
                return BitmapDescriptorFactory.HUE_RED;
            case "monument":
                return BitmapDescriptorFactory.HUE_BLUE;
            case "cultural_site":
                return BitmapDescriptorFactory.HUE_GREEN;
            default:
                return BitmapDescriptorFactory.HUE_ORANGE;
        }
    }
}
```

### 5. Layout do Mapa (activity_maps.xml)

```xml
<?xml version="1.0" encoding="utf-8"?>
<androidx.coordinatorlayout.widget.CoordinatorLayout 
    xmlns:android="http://schemas.android.com/apk/res/android"
    xmlns:app="http://schemas.android.com/apk/res-auto"
    android:layout_width="match_parent"
    android:layout_height="match_parent">

    <fragment
        android:id="@+id/map"
        android:name="com.google.android.gms.maps.SupportMapFragment"
        android:layout_width="match_parent"
        android:layout_height="match_parent" />
    
    <com.google.android.material.floatingactionbutton.FloatingActionButton
        android:id="@+id/fab_filter"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:layout_gravity="bottom|end"
        android:layout_margin="16dp"
        android:src="@android:drawable/ic_menu_search"
        app:fabSize="normal" />

</androidx.coordinatorlayout.widget.CoordinatorLayout>
```

## Exemplos de Uso

### Carregar Museus de Lisboa

```java
Call<List<CulturalSite>> call = api.getSitesByCity("Lisboa");
call.enqueue(new Callback<List<CulturalSite>>() {
    @Override
    public void onResponse(Call<List<CulturalSite>> call, Response<List<CulturalSite>> response) {
        if (response.isSuccessful()) {
            List<CulturalSite> sites = response.body();
            // Processar sites
        }
    }
    
    @Override
    public void onFailure(Call<List<CulturalSite>> call, Throwable t) {
        Log.e(TAG, "Erro", t);
    }
});
```

### Buscar Locais Próximos

```java
// Obter coordenadas da localização atual ou região visível do mapa
double minLat = 38.5;
double maxLat = 39.0;
double minLng = -9.5;
double maxLng = -9.0;

Call<List<CulturalSite>> call = api.getSitesInBounds(minLat, maxLat, minLng, maxLng);
call.enqueue(new Callback<List<CulturalSite>>() {
    @Override
    public void onResponse(Call<List<CulturalSite>> call, Response<List<CulturalSite>> response) {
        if (response.isSuccessful()) {
            List<CulturalSite> nearbySites = response.body();
            // Mostrar locais próximos
        }
    }
    
    @Override
    public void onFailure(Call<List<CulturalSite>> call, Throwable t) {
        Log.e(TAG, "Erro", t);
    }
});
```

### Criar Novo Local (CRUD)

```java
CulturalSite newSite = new CulturalSite();
newSite.setName("Novo Museu");
newSite.setDescription("Descrição do museu");
newSite.setType("museum");
newSite.setLatitude(38.7);
newSite.setLongitude(-9.1);
newSite.setCity("Lisboa");
newSite.setRegion("Lisboa");

Call<CulturalSite> call = api.createSite(newSite);
call.enqueue(new Callback<CulturalSite>() {
    @Override
    public void onResponse(Call<CulturalSite> call, Response<CulturalSite> response) {
        if (response.isSuccessful()) {
            CulturalSite createdSite = response.body();
            Toast.makeText(context, "Local criado com ID: " + createdSite.getId(), 
                Toast.LENGTH_SHORT).show();
        }
    }
    
    @Override
    public void onFailure(Call<CulturalSite> call, Throwable t) {
        Log.e(TAG, "Erro ao criar local", t);
    }
});
```

## Dicas e Boas Práticas

### 1. Usar NetworkSecurityConfig para HTTP (desenvolvimento)

Crie `res/xml/network_security_config.xml`:

```xml
<?xml version="1.0" encoding="utf-8"?>
<network-security-config>
    <base-config cleartextTrafficPermitted="true">
        <trust-anchors>
            <certificates src="system" />
        </trust-anchors>
    </base-config>
</network-security-config>
```

Adicione no AndroidManifest.xml:

```xml
<application
    android:networkSecurityConfig="@xml/network_security_config"
    ...>
```

### 2. Usar AsyncTask ou Coroutines

Para evitar bloqueio da UI, sempre faça chamadas de rede em background.

### 3. Cachear Dados Localmente

Use Room Database para armazenar locais offline:

```gradle
implementation "androidx.room:room-runtime:2.5.0"
annotationProcessor "androidx.room:room-compiler:2.5.0"
```

### 4. Tratamento de Erros

Sempre trate erros de rede e mostre mensagens apropriadas ao usuário.

### 5. Loading Indicators

Mostre um ProgressBar enquanto carrega os dados.

## Troubleshooting

### Erro: "Unable to resolve host"

- Verifique a URL base no ApiClient
- Verifique a conectividade de rede
- Teste a URL no navegador primeiro

### Erro: "Cleartext HTTP traffic not permitted"

- Configure o NetworkSecurityConfig (ver acima)
- Ou use HTTPS em produção

### Marcadores não aparecem

- Verifique se a resposta da API está correta
- Adicione logs para debug
- Verifique as coordenadas (latitude/longitude)

## Recursos Adicionais

- [Retrofit Documentation](https://square.github.io/retrofit/)
- [Google Maps Android API](https://developers.google.com/maps/documentation/android-sdk)
- [Gson Documentation](https://github.com/google/gson)

## Próximos Passos

1. Adicionar filtros na interface
2. Implementar detalhes do local em uma nova Activity
3. Adicionar favoritos com SharedPreferences ou Room
4. Implementar navegação até o local
5. Adicionar imagens usando Glide ou Picasso
