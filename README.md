# Documentación de la API

## Rutas de la API

- **Swagger JSON**: `/api/docs [GET]` - Especificación OpenAPI en formato JSON.
- **Swagger UI**: `/api/docs-ui [GET]` - Interfaz gráfica de Swagger para la API.
- **Login y Logout**: `/api/login [POST]`, `/api/logout [POST]` - Endpoints para autenticación.
- **Gestión de Sensores**: `/api/sensors [GET]`, `/api/sensors [POST]` - Para agregar y obtener sensores.
- **Mediciones**: `/api/wines/measurements [GET]`, `/api/measurements [POST]` - Para obtener y agregar mediciones.

## Acceso a Swagger UI

1. Asegúrate de que la aplicación esté ejecutándose localmente.
2. Visita: [http://127.0.0.1:8000/api/docs-ui](http://127.0.0.1:8000/api/docs-ui)
3. Autentícate con usuario `admin` y contraseña `admin`.

## Documentación Adicional

- **Diagrama E-R y SQL**: Ubicados en `database_docs` en la raíz del proyecto.

## Configuración de la Base de Datos

- Configura la URL de la base de datos en el archivo `.env`:
  
`DATABASE_URL="postgresql://postgres:{your_password}@127.0.0.1:5432/vinoteca?serverVersion=16&charset=utf8"`


## Notas Adicionales

- Asegúrate de que el servidor esté accesible desde `http://127.0.0.1:8000`.
- Cambia las credenciales predeterminadas en ambientes de producción.
- Mantén los cambios consistenes y actualizados en todo el proyecto.

