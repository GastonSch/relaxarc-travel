# Script simplificado para hacer commit de cambios
Write-Host "🚀 Iniciando commit de cambios..." -ForegroundColor Green

# Cambiar al directorio del proyecto
Set-Location "C:\GitHub\relaxarc-travel"

# Agregar todos los archivos modificados
Write-Host "📁 Agregando archivos..." -ForegroundColor Cyan
git add .

# Hacer commit con mensaje detallado
Write-Host "💾 Haciendo commit..." -ForegroundColor Cyan
git commit -m "Refactorización completa a español - SOLUCIONADO problema usuarios admin

✅ Cambios principales:
- UserResource refactorizado (ahora muestra TODOS los usuarios)
- Sistema 100% españolizado
- Archivos de idioma: app.php, auth.php, validation.php  
- Seeder con datos mexicanos realistas
- Formato moneda MXN, timezone Mexico
- Helpers actualizados
- Configuración Laravel en español

🚀 Usuarios por defecto creados:
- superadmin@relaxarc.com / password123 (Super Admin)
- admin@relaxarc.com / admin123 (Admin)  
- ventas@relaxarc.com / ventas123 (Staff)
- juan.perez@email.com / cliente123 (Cliente)
- maria.gonzalez@email.com / cliente123 (Cliente)

📋 Panel admin ahora funciona correctamente"

Write-Host "⬆️ Enviando cambios al repositorio..." -ForegroundColor Cyan
git push origin main

Write-Host ""
Write-Host "📋 Archivos principales modificados:" -ForegroundColor Blue
Write-Host "- ✅ UserResource.php (CORREGIDO filtro usuarios)" -ForegroundColor White
Write-Host "- ✅ config/app.php (idioma español)" -ForegroundColor White  
Write-Host "- ✅ resources/lang/es/* (traducciones completas)" -ForegroundColor White
Write-Host "- ✅ DatabaseSeeder.php (datos mexicanos)" -ForegroundColor White
Write-Host "- ✅ myHelpers.php (formato MXN)" -ForegroundColor White
Write-Host "- ✅ .env.example (configuración actualizada)" -ForegroundColor White

Write-Host ""
Write-Host "🎉 ¡Proceso completado!" -ForegroundColor Green
Write-Host "🔄 Ahora ejecuta tu script de deploy en el servidor" -ForegroundColor Yellow
Write-Host "📱 El panel admin mostrará todos los usuarios correctamente" -ForegroundColor Cyan
