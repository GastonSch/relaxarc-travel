# 🧪 GUÍA DE PRUEBAS - PANEL DE CLIENTE

## ✅ **VERIFICACIÓN PREVIA COMPLETADA**

- ✅ Servidor corriendo en: `http://127.0.0.1:8000`
- ✅ Assets compilados correctamente
- ✅ Rutas de cliente registradas (11 rutas)
- ✅ Usuarios cliente configurados y funcionales
- ✅ Middleware de cliente activo

---

## 🎯 **PLAN DE PRUEBAS**

### **Paso 1: Login como Cliente**
1. Ir a: `http://127.0.0.1:8000/login`
2. Credenciales de prueba:
   - **Email:** `juan.perez@gmail.com`
   - **Password:** `cliente123`
3. **Resultado esperado:** Redirección a página principal (home)

### **Paso 2: Acceso al Panel de Cliente**
1. Ir manualmente a: `http://127.0.0.1:8000/cliente/dashboard`
2. **Resultado esperado:** 
   - Panel de cliente cargado
   - Sidebar visible
   - 4 widgets de estadísticas
   - Layout con colores de Global Travels

### **Paso 3: Navegación del Panel**
Probar cada ruta del cliente:
- ✅ `/cliente/dashboard` - Dashboard principal
- ⏳ `/cliente/viajes` - Lista de viajes
- ⏳ `/cliente/reservas` - Reservas
- ⏳ `/cliente/facturas` - Facturas
- ⏳ `/cliente/favoritos` - Favoritos
- ⏳ `/cliente/perfil` - Perfil personal

### **Paso 4: Verificar Responsive Design**
- Probar en móvil (< 768px)
- Probar en tablet (768px - 1024px)
- Probar en desktop (> 1024px)

---

## 🔍 **ELEMENTOS A VERIFICAR**

### **Visual:**
- [ ] Paleta de colores Global Travels aplicada
- [ ] Fuentes Inter y Poppins cargadas
- [ ] Icons de Font Awesome funcionando
- [ ] Animaciones suaves (fade-in, slide-up)
- [ ] Sidebar colapsible en móvil

### **Funcionalidad:**
- [ ] Widgets muestran estadísticas (aunque sean simuladas)
- [ ] Tabla de viajes recientes cargada
- [ ] Notificaciones visibles
- [ ] Links de navegación funcionando
- [ ] Mensajes de sesión mostrándose

### **Seguridad:**
- [ ] Solo usuarios con rol CLIENTE pueden acceder
- [ ] Middleware redirige usuarios no autorizados
- [ ] Rutas protegidas correctamente

---

## 🐛 **POSIBLES PROBLEMAS Y SOLUCIONES**

### **Error 403 - Forbidden**
**Causa:** Usuario no tiene rol CLIENTE
**Solución:** Verificar que el usuario esté logueado y tenga rol correcto

### **Error 404 - Not Found**
**Causa:** Ruta no registrada
**Solución:** Verificar `php artisan route:list --name=cliente`

### **CSS no carga**
**Causa:** Assets no compilados
**Solución:** `npm run build` o `npm run dev`

### **Sidebar no funciona**
**Causa:** JavaScript de Bootstrap no cargado
**Solución:** Verificar que Bootstrap esté incluido

---

## 📊 **RESULTADOS ESPERADOS**

### **Dashboard (vista principal):**
```
🏠 Global Travels
👤 Juan Carlos Pérez Hernández [▼]

📊 Panel de Cliente
├── Dashboard (activo)
├── Mis Viajes
├── Reservas
├── Facturas  
├── Favoritos
├── Mi Perfil
└── Configuración

📈 WIDGETS:
[📊 0] Viajes Reservados    [⏰ 0] Viajes Pendientes
[📍 0] Destinos Visitados  [❤️ 0] Favoritos

📋 Mis Últimos Viajes:
"No hay viajes reservados"

⚡ Acciones Rápidas:
- Nueva Reserva
- Ver Mis Viajes  
- Mis Favoritos
- Mi Perfil

🔔 Notificaciones:
- Reserva Confirmada (2h)
- Próximo Viaje (1d)
- Nueva Oferta (3d)
```

---

## 🚀 **COMANDOS ÚTILES PARA TESTING**

```bash
# Verificar servidor
curl http://127.0.0.1:8000

# Ver rutas de cliente
php artisan route:list --name=cliente

# Limpiar cache si hay problemas
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Recompilar assets
npm run build

# Ver logs en tiempo real
tail -f storage/logs/laravel.log
```

---

## 📝 **CHECKLIST DE PRUEBAS**

- [ ] **Login exitoso** con credenciales de cliente
- [ ] **Dashboard carga** sin errores 404/500
- [ ] **Layout correcto** con sidebar y header
- [ ] **CSS aplicado** con colores Global Travels
- [ ] **Widgets muestran datos** (aunque sean 0s)
- [ ] **Tabla responsive** en diferentes tamaños
- [ ] **Navegación funciona** entre secciones
- [ ] **Notificaciones visibles** en panel derecho
- [ ] **Logout funciona** correctamente
- [ ] **Middleware protege** rutas correctamente

---

**🎯 OBJETIVO:** Validar que el MVP Fase 1 del panel de cliente funciona correctamente antes de continuar con vistas adicionales.
