# 🧪 Guía de Prueba - Panel de Cliente

## ✅ Estado Actual
- ✅ Servidor corriendo en: http://localhost:8000
- ✅ Rutas registradas correctamente
- ✅ Middleware funcionando
- ✅ Usuarios cliente disponibles
- ✅ Autenticación funcionando

## 👥 Usuarios de Prueba (Clientes)

### Cliente 1
- **Email:** `juan.perez@gmail.com`
- **Password:** `password` (por defecto en seeder)
- **Nombre:** Juan Carlos Pérez Hernández
- **Rol:** CLIENTE

### Cliente 2
- **Email:** `maria.gonzalez@outlook.com`
- **Password:** `password`
- **Nombre:** María Fernanda González López
- **Rol:** CLIENTE

### Cliente 3
- **Email:** `diego.ramirez@yahoo.com`
- **Password:** `password`
- **Nombre:** Diego Alejandro Ramírez
- **Rol:** CLIENTE

## 🧪 Pasos de Prueba

### 1. Iniciar Sesión como Cliente
1. Abrir navegador y ir a: http://localhost:8000
2. Hacer clic en "Iniciar Sesión" o ir directamente a: http://localhost:8000/login
3. Introducir credenciales:
   - Email: `juan.perez@gmail.com`
   - Password: `password`
4. Hacer clic en "Iniciar Sesión"

### 2. Verificar Redirección Automática
- Después del login, el cliente debería ser redirigido automáticamente al dashboard de cliente
- URL esperada: http://localhost:8000/cliente/dashboard

### 3. Acceso Manual al Panel de Cliente
Si la redirección automática no funciona, navegar manualmente a:
- **Dashboard:** http://localhost:8000/cliente/dashboard
- **Mis Viajes:** http://localhost:8000/cliente/viajes ⭐ (Problema reportado)

### 4. Probar Navegación en el Panel
Una vez en el dashboard de cliente:
1. **Verificar Sidebar:** Debe aparecer la navegación izquierda con:
   - Dashboard
   - Mis Viajes ⭐
   - Reservas
   - Facturas
   - Favoritos
   - Mi Perfil

2. **Hacer clic en "Mis Viajes"** y verificar que:
   - La página carga correctamente
   - Se muestran los viajes del usuario
   - La interfaz está bien estilizada
   - No hay errores en la consola del navegador

### 5. Pruebas Específicas para "Mis Viajes"
- Verificar que se muestran estadísticas
- Verificar que se muestran los viajes en formato de tarjeta
- Probar botones de filtro
- Verificar enlaces a detalles de viaje

## 🚨 Problemas Conocidos y Soluciones

### Problema: "No puedo ir a la página donde veo mis viajes"

#### Posibles Causas:
1. **Error 403 (Prohibido):** Problema con middleware de autorización
2. **Error 500 (Servidor):** Error en el controlador o vista
3. **Redirección inesperada:** Problema con autenticación
4. **JavaScript/Navegador:** Problema en el frontend

#### Verificaciones:
1. **Abrir Consola del Navegador** (F12)
   - Revisar errores en "Console"
   - Revisar errores en "Network" al navegar

2. **Verificar URL directa:**
   - Intentar acceso directo: http://localhost:8000/cliente/viajes

3. **Revisar logs de Laravel:**
   - Archivo: `storage/logs/laravel.log`
   - Buscar errores recientes

## 🔧 Comandos de Depuración

Si hay problemas, ejecutar estos comandos:

```bash
# Verificar que el servidor esté corriendo
php artisan serve --host=0.0.0.0 --port=8000

# Verificar rutas de cliente
php artisan route:list --name=cliente

# Verificar usuarios cliente
php artisan test:client-role

# Verificar acceso de cliente
php artisan test:client-access

# Limpiar caché si es necesario
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## 📊 Estado de Funcionalidades

### ✅ Completadas
- [x] Login de cliente
- [x] Dashboard de cliente
- [x] Navegación sidebar
- [x] Rutas protegidas
- [x] Middleware de autorización
- [x] Vista "Mis Viajes" (diseño)

### 🔄 En Pruebas
- [ ] Acceso a "Mis Viajes" desde navegador
- [ ] Funcionalidad de filtros
- [ ] Detalles de viaje
- [ ] Documentos de viaje

### 📋 Pendientes
- [ ] Reservas
- [ ] Facturas
- [ ] Favoritos
- [ ] Configuración de perfil

## 🆘 En Caso de Error

1. **Revisar logs:** `storage/logs/laravel.log`
2. **Verificar base de datos:** ¿Hay transacciones para el usuario?
3. **Verificar middleware:** ¿El usuario tiene rol CLIENTE?
4. **Verificar rutas:** ¿Las rutas están registradas?

## 📞 Información de Contacto

Si encuentras errores específicos:
1. Copia el mensaje de error completo
2. Indica qué pasos seguiste
3. Menciona qué navegador estás usando
4. Incluye captura de pantalla si es posible
