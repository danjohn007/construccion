# Sistema Web de Análisis de Precios y Programa de Obra

Este proyecto permite gestionar presupuestos, avances y recursos de obras de construcción. Migrado desde un sistema Excel a una aplicación online en PHP y MySQL.  
Referencia y estructura basada en el archivo de Excel adjunto.

## Funcionalidades principales

- Gestión de obras y conceptos
- Análisis de precios unitarios (PU)
- Volúmenes y básicos
- Programa de obra y control de avance
- Materiales, mano de obra, proveedores
- Panel de control con KPIs y reportes exportables
- Niveles de usuario (admin, analista, visitante)
- Seguridad y validación

## Estructura del proyecto

- **public/**: archivos públicos y punto de entrada (index.php)
- **src/**: lógica principal, modelos, controladores, vistas
- **config/**: configuración y credenciales
- **migrations/**: scripts para crear/poblar tablas
- **exports/**: reportes generados (PDF/Excel)
- **docs/**: documentación técnica
- **.env**: variables de entorno
- **README.md**: este archivo

## Instalación rápida

1. Clona el repositorio.
2. Configura la base de datos en `.env`.
3. Ejecuta los scripts de migración (`migrations/`).
4. Accede a `public/index.php` desde tu navegador.
5. Usa los usuarios de ejemplo para probar el sistema.

## Migración de datos desde Excel

Incluye scripts y ejemplos para importar datos principales desde Excel.

## Contacto y soporte

Para dudas, mejoras o soporte, abre una issue o pull request.
