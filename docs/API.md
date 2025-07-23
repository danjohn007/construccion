# API Documentation

## Overview

The Construction Management System provides a RESTful API for managing construction projects, concepts, materials, and progress tracking.

## Authentication

All API endpoints require authentication. The system uses session-based authentication.

### Login
```http
POST /api/auth/login
Content-Type: application/json

{
    "email": "admin@construccion.com",
    "password": "password"
}
```

### Logout
```http
POST /api/auth/logout
```

## Endpoints

### Obras (Projects)

#### List Projects
```http
GET /api/obras
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "nombre": "Casa Habitación Tipo Medio",
            "clave": "OBRA-001",
            "direccion": "Av. Revolución #123, Col. Centro",
            "municipio": "Guadalajara, Jalisco",
            "estado": "en_proceso",
            "avance_fisico": 35.50,
            "presupuesto_total": 850000.00
        }
    ]
}
```

#### Get Project
```http
GET /api/obras/{id}
```

#### Create Project
```http
POST /api/obras
Content-Type: application/json

{
    "nombre": "Nueva Obra",
    "clave": "OBRA-002",
    "direccion": "Calle Ejemplo #456",
    "municipio": "Ciudad Ejemplo",
    "fecha_inicio": "2024-01-15",
    "fecha_termino": "2024-06-15",
    "presupuesto_total": 1000000.00
}
```

#### Update Project
```http
PUT /api/obras/{id}
Content-Type: application/json

{
    "nombre": "Obra Actualizada",
    "estado": "terminada"
}
```

#### Delete Project
```http
DELETE /api/obras/{id}
```

### Conceptos (Work Concepts)

#### List Concepts
```http
GET /api/conceptos?obra_id={obra_id}
```

#### Create Concept
```http
POST /api/conceptos
Content-Type: application/json

{
    "obra_id": 1,
    "clave": "C-008",
    "descripcion": "Instalación eléctrica",
    "unidad": "salida",
    "cantidad": 25.00,
    "precio_unitario": 450.00,
    "etapa": "Instalaciones"
}
```

### Materiales (Materials)

#### List Materials
```http
GET /api/materiales
```

#### Create Material
```http
POST /api/materiales
Content-Type: application/json

{
    "nombre": "Tubería PVC 4\"",
    "unidad": "m",
    "precio_unitario": 85.50,
    "proveedor_id": 1,
    "categoria": "Plomería"
}
```

### Precios Unitarios (Unit Prices)

#### Get Unit Price Analysis
```http
GET /api/precios_unitarios/{concepto_id}
```

#### Create Unit Price Component
```http
POST /api/precios_unitarios
Content-Type: application/json

{
    "concepto_id": 1,
    "tipo": "material",
    "descripcion": "Cemento Portland",
    "unidad": "ton",
    "cantidad": 0.350,
    "precio_unitario": 2800.00
}
```

### Avance de Obra (Work Progress)

#### Record Progress
```http
POST /api/avance_obra
Content-Type: application/json

{
    "concepto_id": 1,
    "fecha": "2024-02-15",
    "cantidad_ejecutada": 15.50,
    "porcentaje_avance": 75.00,
    "importe_ejecutado": 12500.00,
    "observaciones": "Avance según cronograma"
}
```

#### Get Progress History
```http
GET /api/avance_obra?concepto_id={concepto_id}&fecha_inicio={fecha}&fecha_fin={fecha}
```

### Reportes (Reports)

#### Generate Report
```http
POST /api/reportes
Content-Type: application/json

{
    "obra_id": 1,
    "tipo": "avance_obra",
    "parametros": {
        "fecha_inicio": "2024-01-01",
        "fecha_fin": "2024-02-29",
        "formato": "pdf"
    }
}
```

#### Download Report
```http
GET /api/reportes/{id}/download
```

## Error Responses

All API endpoints return consistent error responses:

```json
{
    "success": false,
    "error": {
        "code": "VALIDATION_ERROR",
        "message": "Los campos requeridos no fueron proporcionados",
        "details": [
            "El campo 'nombre' es requerido",
            "El campo 'clave' es requerido"
        ]
    }
}
```

### HTTP Status Codes

- `200` - Success
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Validation Error
- `500` - Internal Server Error

## Rate Limiting

API requests are limited to:
- 100 requests per minute per authenticated user
- 1000 requests per hour per authenticated user

## Data Formats

### Dates
All dates should be in ISO 8601 format: `YYYY-MM-DD`

### Currency
All monetary values are in MXN (Mexican Pesos) with 2 decimal places

### Percentages
Percentages are represented as decimal values (0-100)

## Webhooks (Future Feature)

The system will support webhooks for real-time notifications:

- Project status changes
- Progress milestones reached
- Budget threshold alerts
- Schedule deviations

## SDK and Libraries

Future support for:
- JavaScript/Node.js SDK
- Python SDK
- Mobile SDK (React Native)

## Examples

### Complete Project Creation Workflow

1. **Create Project**
```http
POST /api/obras
{
    "nombre": "Edificio Corporativo",
    "clave": "EDI-001",
    "presupuesto_total": 5000000.00
}
```

2. **Add Concepts**
```http
POST /api/conceptos
{
    "obra_id": 1,
    "clave": "C-001",
    "descripcion": "Excavación",
    "cantidad": 500.00,
    "precio_unitario": 120.00
}
```

3. **Track Progress**
```http
POST /api/avance_obra
{
    "concepto_id": 1,
    "fecha": "2024-02-15",
    "cantidad_ejecutada": 250.00,
    "porcentaje_avance": 50.00
}
```

4. **Generate Report**
```http
POST /api/reportes
{
    "obra_id": 1,
    "tipo": "avance_financiero",
    "formato": "pdf"
}
```