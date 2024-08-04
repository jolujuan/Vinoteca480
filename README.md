# Documentación de la API

## Rutas de la API

- **Swagger JSON**: `/api/doc.json` - Especificación OpenAPI en formato JSON.
- **Swagger UI**: `/api/doc` - Interfaz gráfica de Swagger para la documentación de la API.
- **Login y Logout**: `/api/login`, `/api/logout` - Endpoints para autenticación.
- **Gestión de Sensores**: `/api/addSensor`, `/api/getSensors` - Para agregar y obtener sensores.
- **Mediciones**: `/api/getWineMeasurament`, `/api/addMeasurament` - Para obtener y agregar mediciones.

## Acceso a Swagger UI

1. Asegúrate de que la aplicación esté ejecutándose localmente.
2. Visita: [http://127.0.0.1:8000/api/doc](http://127.0.0.1:8000/api/doc)
3. Autentícate con usuario `admin` y contraseña `admin`.

## Documentación Adicional

- **Diagrama E-R y SQL**: Ubicados en `docs` en la raíz del proyecto.

## Configuración de la Base de Datos

- Configura la URL de la base de datos en el archivo `.env`:
  
`DATABASE_URL="postgresql://postgres:1991@127.0.0.1:5432/vinoteca?serverVersion=16&charset=utf8"`


## Notas Adicionales

- Asegúrate de que el servidor esté accesible desde `http://127.0.0.1:8000`.
- Cambia las credenciales predeterminadas en ambientes de producción.
