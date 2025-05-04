# 💱 Currency Converter API – Laravel + Sanctum

Este proyecto es una **API REST protegida con Laravel Sanctum** que permite convertir monedas en tiempo real utilizando una API pública de tipos de cambio. Forma parte de una prueba técnica para el puesto de **Senior Laravel Developer** en iDoctus.

---

## 🚀 Tecnologías utilizadas

- PHP 8.4
- Laravel 12
- Sanctum para autenticación de APIs
- SQLite como base de datos liviana
- Http Client de Laravel
- Arquitectura inspirada en Clean Architecture
- Pruebas automáticas con PHPUnit
- Curl/Postman para pruebas manuales

---

## ⚙️ Instalación

1. Clona el repositorio

```bash
git clone https://github.com/tu-usuario/currency-converter.git
cd currency-converter
```

2. Instala dependencias

```bash
composer install
```

3. Copia el archivo de entorno y genera la clave de aplicación

```bash
cp .env.example .env
php artisan key:generate
```

4. Configura la base de datos en `.env`:

```env
DB_CONNECTION=sqlite
DB_DATABASE=${PWD}/database/database.sqlite
```

> En Windows, reemplaza `${PWD}` por la ruta completa, por ejemplo: `C:/Users/TuUsuario/Desktop/currency-converter/database/database.sqlite`

5. Crea el archivo SQLite vacío

```bash
touch database/database.sqlite
```

6. Ejecuta las migraciones

```bash
php artisan migrate
```

7. Crea un usuario y token para probar la autenticación (opcional con Tinker):

```bash
php artisan tinker
```

```php
$user = \App\Models\User::create([
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => bcrypt('password'),
]);
$token = $user->createToken('dev-token')->plainTextToken;
echo $token;
```

---

## 🔐 Autenticación

El endpoint está protegido con Sanctum. Para acceder, añade este header:

```
Authorization: Bearer TU_TOKEN
```

---

## 🧪 Endpoint disponible

### `GET /api/convert`

Convierte una cantidad de una moneda a otra.

#### Parámetros:

| Nombre  | Tipo   | Requerido | Descripción                    |
|---------|--------|-----------|--------------------------------|
| `from`  | string | ✅         | Código de moneda origen (ej. USD) |
| `to`    | string | ✅         | Código de moneda destino (ej. EUR) |
| `amount`| float  | ✅         | Cantidad a convertir           |

#### Ejemplo:

```
GET /api/convert?from=USD&to=EUR&amount=100
```

#### Respuesta:

```json
{
  "from": "USD",
  "to": "EUR",
  "amount": 100,
  "rate": 0.91,
  "converted_amount": 91.0
}
```

---

## 🧪 Pruebas automáticas

Este proyecto incluye tests de integración para verificar el comportamiento del endpoint protegido.

```bash
php artisan test
```

Incluye:

- ✅ Acceso autorizado con token válido
- ❌ Rechazo a usuarios no autenticados
- ✅ Verificación de estructura y valores de respuesta
- 🧪 Simulación de la API externa con `Http::fake`

---

## 🧱 Estructura del proyecto

```bash
app/
├── Actions/
│   └── ConvertCurrencyAction.php
├── Http/
│   └── Controllers/
│       └── Api/
│           └── CurrencyController.php
├── Services/
│   └── ExchangeRateService.php
```

---

## 📄 Notas

- En entorno local, se desactiva la verificación SSL de la API pública con `Http::withoutVerifying()` debido a problemas comunes con `cURL error 60`. Esto se puede revertir fácilmente en producción.
- El endpoint usa una arquitectura limpia y desacoplada, separando lógica de negocio (`Action`), integración externa (`Service`) y transporte (`Controller`).


---

## 🛠️ Uso con Makefile

Este proyecto incluye un `Makefile` para simplificar comandos comunes:

```bash
make install       # Instala dependencias, copia .env y migra la base de datos
make serve         # Inicia el servidor local
make test          # Ejecuta los tests
make tinker        # Abre la consola interactiva
make migrate       # Ejecuta migraciones
make fresh         # Refresca base de datos y ejecuta seeders
make dev-user      # Crea el usuario de prueba y genera token de acceso
```

### 🧪 Flujo rápido recomendado:

```bash
make install
make dev-user
make serve
```

Luego prueba el endpoint:

```bash
curl.exe -H "Authorization: Bearer TU_TOKEN" ^
         "http://127.0.0.1:8000/api/convert?from=USD&to=EUR&amount=100"
```



> ⚠️ **Importante sobre SSL**  
> En entorno local, la API de tipos de cambio se consume con `Http::withoutVerifying()` para evitar errores comunes de certificados en Windows (`cURL error 60`).  
> **No debe usarse en producción.**  
> Para entornos productivos:
> - Usa `Http::get(...)` sin `withoutVerifying()`.
> - Asegúrate de tener configurado correctamente el archivo `cacert.pem` en tu `php.ini`:
> ```ini
> curl.cainfo = "/ruta/a/cacert.pem"
> openssl.cafile = "/ruta/a/cacert.pem"
> ```
> Puedes obtener el archivo actualizado desde: https://curl.se/ca/cacert.pem
> - O, alternativamente, aplica una condición como:
> ```php
> $response = app()->environment('local')
>     ? Http::withoutVerifying()->get($url)
>     : Http::get($url);
> ```


## 🙋 Sobre mí

Desarrollado como parte de la prueba técnico para iDoctus por Emilio Alvarez Diaz.

