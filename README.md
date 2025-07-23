# Sistema Web de Análisis de Precios y Programa de Obra

Este proyecto permite gestionar presupuestos, avances y recursos de obras de construcción. Migrado desde un sistema Excel a una aplicación online en PHP y MySQL.

## 🏗️ Funcionalidades principales

- ✅ **Gestión de obras y conceptos** - CRUD completo para proyectos de construcción
- ✅ **Análisis de precios unitarios (PU)** - Cálculo detallado de costos
- ✅ **Volúmenes y básicos** - Gestión de cantidades de obra
- ✅ **Programa de obra y control de avance** - Seguimiento de progreso
- ✅ **Materiales, mano de obra, proveedores** - Catálogos de recursos
- ✅ **Panel de control con KPIs y reportes exportables** - Dashboard ejecutivo
- ✅ **Niveles de usuario (admin, analista, visitante)** - Control de acceso
- ✅ **Seguridad y validación** - Autenticación y autorización

## 📁 Estructura del proyecto

```
/
├── public/                 # Archivos públicos y punto de entrada
│   ├── index.php          # Dashboard principal
│   ├── login.php          # Página de inicio de sesión
│   ├── obras.php          # Gestión de obras
│   └── assets/            # CSS, JS, imágenes
├── src/                   # Lógica principal del sistema
│   ├── Controllers/       # Controladores PHP (futuro)
│   ├── Models/           # Modelos de base de datos
│   ├── Views/            # Vistas HTML/PHP
│   └── Helpers/          # Funciones auxiliares
├── config/               # Configuración de BD y variables
├── migrations/           # Scripts para crear/poblar tablas
├── exports/             # Reportes generados (PDF/Excel)
├── docs/                # Documentación técnica
├── .env                 # Variables de entorno
└── setup_database.sh    # Script de instalación
```

## 🚀 Instalación rápida

### Prerrequisitos
- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache/Nginx)

### Pasos de instalación

1. **Clona el repositorio**
   ```bash
   git clone [repository-url]
   cd construccion
   ```

2. **Configura la base de datos**
   ```bash
   # Edita las credenciales en .env
   cp .env.example .env
   nano .env
   ```

3. **Ejecuta el script de instalación**
   ```bash
   chmod +x setup_database.sh
   ./setup_database.sh
   ```

4. **Configura tu servidor web**
   - Apunta el document root a la carpeta `public/`
   - Asegúrate de que PHP tenga acceso a la base de datos

5. **Accede al sistema**
   - Visita `http://tu-servidor/public/` en tu navegador
   - Usa las credenciales de prueba para acceder

## 👥 Usuarios de prueba

| Rol | Email | Contraseña | Permisos |
|-----|-------|------------|----------|
| **Admin** | admin@construccion.com | password | Acceso total al sistema |
| **Analista** | analista@construccion.com | password | Gestión de obras (sin usuarios) |
| **Visitante** | visitante@construccion.com | password | Solo lectura |

## 🗄️ Base de datos

### Tablas principales
- `usuarios` - Gestión de usuarios y roles
- `obras` - Proyectos de construcción
- `conceptos` - Conceptos de trabajo por obra
- `precios_unitarios` - Análisis de precios unitarios
- `materiales` - Catálogo de materiales
- `mano_obra` - Catálogo de mano de obra
- `avance_obra` - Registro de avances
- `programa_obra` - Programa de actividades
- `proveedores` - Catálogo de proveedores

### Migración de datos desde Excel

El sistema incluye scripts de migración para importar datos desde Excel:

```bash
# Ejecutar migraciones
mysql -u root -p construccion_db < migrations/001_create_tables.sql
mysql -u root -p construccion_db < migrations/002_sample_data.sql
```

## 📊 Módulos implementados

### ✅ Completados
1. **Sistema de autenticación** - Login, logout, control de roles
2. **Dashboard** - KPIs principales y resumen ejecutivo
3. **Gestión de obras** - CRUD completo con validaciones
4. **Modelos de base de datos** - Estructura completa implementada

### 🔄 En desarrollo
5. Gestión de conceptos
6. Precios unitarios
7. Control de materiales y mano de obra
8. Registro de avances
9. Programa de obra
10. Generación de reportes

## 🔧 Tecnologías utilizadas

- **Backend:** PHP 8.0+ (vanilla, sin framework)
- **Base de datos:** MySQL 8.0+
- **Frontend:** HTML5, CSS3, JavaScript (ES6+)
- **Framework CSS:** Bootstrap 5.3
- **Iconos:** Bootstrap Icons

## 🛡️ Seguridad

- Autenticación basada en sesiones
- Validación de entrada de datos
- Protección contra SQL injection (PDO prepared statements)
- Control de acceso basado en roles
- Sanitización de salidas HTML

## 📈 Características técnicas

- **Responsive design** - Compatible con dispositivos móviles
- **Validación en tiempo real** - Formularios con validación client-side y server-side
- **Cálculos automáticos** - Importes, porcentajes y avances se calculan automáticamente
- **Búsqueda y filtrado** - Tablas con capacidades de búsqueda
- **Exportación** - Reportes en PDF y Excel (próximamente)

## 🔮 Roadmap

### Versión 1.1 (Próxima)
- [ ] Módulo de conceptos completo
- [ ] Análisis de precios unitarios
- [ ] Gestión de materiales y mano de obra

### Versión 1.2
- [ ] Control de avances con gráficos
- [ ] Programa de obra (calendario/Gantt)
- [ ] Exportación de reportes

### Versión 1.3
- [ ] API REST para integraciones
- [ ] Notificaciones automáticas
- [ ] Backup automático

## 🐛 Reportar problemas

Si encuentras algún problema o tienes sugerencias:

1. Abre un issue en GitHub
2. Describe el problema detalladamente
3. Incluye pasos para reproducir el error
4. Especifica tu entorno (PHP, MySQL, navegador)

## 🤝 Contribuir

Las contribuciones son bienvenidas:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT - ver el archivo [LICENSE](LICENSE) para detalles.

## 📞 Contacto y soporte

Para dudas, mejoras o soporte técnico:
- Abre una issue en GitHub
- Consulta la documentación en `/docs`
- Revisa los ejemplos en el código

---

**Sistema de Análisis de Precios y Programa de Obra** - Versión 1.0  
© 2024 - Desarrollado para la gestión moderna de proyectos de construcción
