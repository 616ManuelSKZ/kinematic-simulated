# Simulador de Cinemática de los Cuerpos - Laravel

Sistema completo para simulación y análisis de MRUV y Movimiento Parabólico desarrollado en Laravel.

## 📋 Características

- ✅ Simulador MRUV con animación en tiempo real
- ✅ Simulador de Movimiento Parabólico
- ✅ Gráficas interactivas con Chart.js
- ✅ Exportación de datos a CSV
- ✅ Comparación con datos experimentales
- ✅ Cálculo de error RMSE
- ✅ Gestión de experimentos guardados
- ✅ Centro de ayuda con fórmulas y guías
- ✅ Sistema de autenticación de usuarios

## 🛠️ Requisitos

- PHP >= 8.1
- Composer
- MySQL >= 5.7 o PostgreSQL >= 10
- Node.js >= 16 y NPM

## 📦 Instalación

### 1. Clonar el repositorio o crear el proyecto

```bash
composer create-project laravel/laravel cinematica-simulador
cd cinematica-simulador
```

### 2. Configurar el entorno

```bash
cp .env.example .env
```

Edita el archivo `.env` con tus credenciales de base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cinematica_db
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 3. Generar la clave de aplicación

```bash
php artisan key:generate
```

### 4. Crear la base de datos

```sql
CREATE DATABASE cinematica_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Instalar dependencias

```bash
composer install
npm install
```

### 6. Copiar los archivos del sistema

Copia los archivos generados en las siguientes ubicaciones:

#### Migraciones
- `database/migrations/YYYY_MM_DD_create_experimentos_tables.php`

#### Modelos
- `app/Models/Experimento.php`
- `app/Models/DatoExperimental.php`

#### Controladores
- `app/Http/Controllers/ExperimentoController.php`
- `app/Http/Controllers/DashboardController.php`

#### Servicios
- `app/Services/CinematicaService.php`

#### Políticas
- `app/Policies/ExperimentoPolicy.php`

#### Vistas (en `resources/views/`)
```
resources/views/
├── dashboard.blade.php
├── experimentos/
│   ├── index.blade.php
│   └── show.blade.php
├── modulos/
│   ├── mruv.blade.php
│   └── parabolico.blade.php
└── ayuda/
    └── index.blade.php
```

#### Rutas
- `routes/web.php`

### 7. Ejecutar las migraciones

```bash
php artisan migrate
```

### 8. Instalar Laravel Breeze (para autenticación)

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install
npm run build
php artisan migrate
```

### 9. Crear enlace simbólico para almacenamiento

```bash
php artisan storage:link
```

### 10. Compilar assets

```bash
npm run dev
```

O para producción:

```bash
npm run build
```

### 11. Iniciar el servidor

```bash
php artisan serve
```

Visita: `http://localhost:8000`

## 📁 Estructura del Proyecto

```
cinematica-simulador/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── ExperimentoController.php
│   │       └── DashboardController.php
│   ├── Models/
│   │   ├── Experimento.php
│   │   ├── DatoExperimental.php
│   │   └── User.php
│   ├── Policies/
│   │   └── ExperimentoPolicy.php
│   └── Services/
│       └── CinematicaService.php
├── database/
│   └── migrations/
│       └── create_experimentos_tables.php
├── resources/
│   └── views/
│       ├── dashboard.blade.php
│       ├── experimentos/
│       ├── modulos/
│       └── ayuda/
├── routes/
│   └── web.php
└── public/
    └── storage/ (enlace simbólico)
```

## 🎯 Uso del Sistema

### 1. Registro e Inicio de Sesión

1. Visita `/register` para crear una cuenta
2. Inicia sesión en `/login`

### 2. Crear una Simulación MRUV

1. Desde el dashboard, haz clic en "MRUV"
2. Ingresa los parámetros:
   - Velocidad inicial (v₀)
   - Aceleración (a)
   - Tiempo total (t)
   - Posición inicial (x₀)
3. Haz clic en "Simular"
4. Visualiza la animación y gráficas
5. Exporta los datos o guarda el experimento

### 3. Crear una Simulación Parabólica

1. Desde el dashboard, haz clic en "Parabólico"
2. Ingresa los parámetros:
   - Velocidad inicial (v₀)
   - Ángulo de lanzamiento (θ)
   - Altura inicial (y₀)
   - Gravedad (g)
3. Haz clic en "Simular"
4. Observa la trayectoria animada
5. Analiza las gráficas y resultados

### 4. Comparar con Datos Experimentales

1. Abre un experimento guardado
2. Haz clic en "Comparar con datos experimentales"
3. Sube un archivo CSV con el formato:
   ```csv
   t,x,v    # Para MRUV
   t,x,y    # Para Parabólico
   ```
4. El sistema calculará el error RMSE automáticamente

### 5. Exportar Datos

- Haz clic en "Exportar CSV" para descargar los datos
- El archivo incluye todas las mediciones de la simulación

## 🧪 Formato de Archivos CSV

### MRUV
```csv
Tiempo (s),Posición (m),Velocidad (m/s)
0.0,0.0,0.0
0.5,0.5,1.0
1.0,2.0,2.0
```

### Movimiento Parabólico
```csv
Tiempo (s),Posición X (m),Posición Y (m)
0.0,0.0,0.0
0.2,2.8,1.8
0.4,5.6,3.2
```

## 🔧 Personalización

### Cambiar valores por defecto

Edita los archivos de vista en `resources/views/modulos/`:
- `mruv.blade.php` - Valores iniciales del formulario MRUV
- `parabolico.blade.php` - Valores iniciales del formulario Parabólico

### Modificar cálculos físicos

Edita `app/Services/CinematicaService.php` para ajustar las fórmulas o añadir nuevas funcionalidades.

### Personalizar estilos

El sistema usa Tailwind CSS. Modifica las clases en las vistas Blade o agrega estilos personalizados en `resources/css/app.css`.

## 📊 Base de Datos

### Tabla: experimentos
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint | ID único |
| user_id | bigint | ID del usuario |
| nombre | varchar(255) | Nombre del experimento |
| tipo | enum | 'mruv' o 'parabolico' |
| parametros | json | Parámetros de entrada |
| resultados | json | Resultados calculados |
| notas | text | Notas opcionales |
| created_at | timestamp | Fecha de creación |
| updated_at | timestamp | Última actualización |

### Tabla: datos_experimentales
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint | ID único |
| experimento_id | bigint | FK a experimentos |
| archivo_csv | varchar(255) | Ruta del archivo |
| datos | json | Datos experimentales |
| error_rmse | decimal(10,6) | Error calculado |
| created_at | timestamp | Fecha de creación |
| updated_at | timestamp | Última actualización |

## 🧮 Fórmulas Implementadas

### MRUV
```php
v(t) = v₀ + a·t
x(t) = x₀ + v₀·t + ½·a·t²
```

### Movimiento Parabólico
```php
v₀ₓ = v₀·cos(θ)
v₀ᵧ = v₀·sin(θ)
x(t) = x₀ + v₀ₓ·t
y(t) = y₀ + v₀ᵧ·t - ½·g·t²
t_vuelo = (v₀ᵧ + √(v₀ᵧ² + 2·g·y₀)) / g
h_max = y₀ + v₀ᵧ² / (2·g)
R = v₀²·sin(2θ) / g
```

### Cálculo de Error RMSE
```php
RMSE = √(Σ(valor_teórico - valor_experimental)² / n)
```

## 🚀 Características Avanzadas

### Animaciones Canvas

Las animaciones se renderizan en tiempo real usando HTML5 Canvas:
- MRUV: Carrito moviéndose en pista con indicadores de posición
- Parabólico: Proyectil con trayectoria, vectores de velocidad y sombra

### Gráficas Interactivas

Uso de Chart.js para:
- Gráficas de posición vs tiempo
- Gráficas de velocidad vs tiempo
- Trayectorias parabólicas (y vs x)
- Hover interactivo para ver valores exactos

### Validaciones

- Validación de rangos de valores (ángulo 1-89°, tiempo > 0, etc.)
- Validación de archivos CSV
- Autorización de acceso a experimentos (solo propietario)

## 🐛 Solución de Problemas

### Error: "Class 'App\Services\CinematicaService' not found"

Ejecuta:
```bash
composer dump-autoload
```

### Las animaciones no se cargan

Verifica que:
1. Chart.js esté cargado desde CDN
2. El JavaScript no tenga errores en la consola
3. Los datos de simulación se estén retornando correctamente

### Error al subir CSV

Asegúrate de que:
1. El enlace simbólico de storage esté creado: `php artisan storage:link`
2. Los permisos de la carpeta storage sean correctos: `chmod -R 775 storage`

### Las gráficas no se muestran

1. Limpia la caché del navegador
2. Verifica que los datos tengan el formato correcto
3. Revisa la consola del navegador por errores JavaScript

## 🔐 Seguridad

- ✅ Autenticación con Laravel Breeze
- ✅ Autorización mediante Policies
- ✅ Protección CSRF en todos los formularios
- ✅ Validación de entrada de datos
- ✅ SQL injection prevention (Eloquent ORM)
- ✅ XSS protection (Blade templating)

## 📈 Optimizaciones

### Para producción:

1. **Compilar assets:**
```bash
npm run build
```

2. **Optimizar configuración:**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. **Configurar caché de base de datos:**
```bash
php artisan cache:clear
php artisan optimize
```

4. **Configurar cola de trabajos (opcional):**
```bash
php artisan queue:table
php artisan migrate
```

## 🧪 Testing

### Crear tests unitarios:

```bash
php artisan make:test CinematicaServiceTest --unit
```

### Ejecutar tests:

```bash
php artisan test
```

## 📝 API Endpoints (Opcionales)

Si deseas crear una API REST, añade estas rutas en `routes/api.php`:

```php
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/simular', [ExperimentoController::class, 'simular']);
    Route::apiResource('experimentos', ExperimentoController::class);
});
```

## 🌐 Despliegue

### Preparar para producción:

1. Configurar `.env` para producción
2. Establecer `APP_DEBUG=false`
3. Configurar el dominio en `APP_URL`
4. Usar un servidor web (Nginx/Apache)
5. Configurar SSL/HTTPS
6. Usar supervisor para queues (si aplica)

### Ejemplo de configuración Nginx:

```nginx
server {
    listen 80;
    server_name cinematica.example.com;
    root /var/www/cinematica-simulador/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## 🤝 Contribuciones

Para contribuir al proyecto:

1. Fork el repositorio
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT.

## 👥 Créditos

- Desarrollado con Laravel 10
- Animaciones con HTML5 Canvas
- Gráficas con Chart.js
- Estilos con Tailwind CSS

## 📞 Soporte

Para reportar bugs o solicitar features, abre un issue en el repositorio.

## 🎓 Uso Educativo

Este sistema está diseñado específicamente para:
- Laboratorios de física
- Proyectos académicos
- Comparación de datos experimentales con modelos teóricos
- Análisis de errores en mediciones

## ✨ Próximas Características

- [ ] Exportación a PDF con gráficas
- [ ] Modo oscuro
- [ ] Múltiples idiomas (i18n)
- [ ] Más tipos de movimiento (circular, armónico)
- [ ] API REST completa
- [ ] Compartir experimentos públicamente
- [ ] Análisis estadístico avanzado
- [ ] Integración con sensores físicos (Arduino/Raspberry Pi)

## 📚 Referencias

- [Documentación de Laravel](https://laravel.com/docs)
- [Chart.js Documentation](https://www.chartjs.org/docs/)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [HTML5 Canvas API](https://developer.mozilla.org/en-US/docs/Web/API/Canvas_API)

---

**¡Disfruta explorando la física con el Simulador de Cinemática! 🚀**