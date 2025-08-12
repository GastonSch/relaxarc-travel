# Script para hacer commit de los cambios de españolización
Write-Host "🚀 Iniciando commit de cambios..." -ForegroundColor Green

# Cambiar al directorio del proyecto
Set-Location "C:\GitHub\relaxarc-travel"

# Verificar si Git está disponible
try {
    $gitVersion = git --version 2>$null
    if (-not $gitVersion) {
        throw "Git no encontrado"
    }
    Write-Host "✅ Git encontrado: $gitVersion" -ForegroundColor Green
}
catch {
    Write-Host "❌ Git no está instalado o no está en el PATH" -ForegroundColor Red
    Write-Host "📋 Por favor instala Git desde: https://git-scm.com/download/win" -ForegroundColor Yellow
    exit 1
}

# Agregar todos los archivos modificados
Write-Host "📁 Agregando archivos..." -ForegroundColor Cyan
git add .

# Hacer commit
Write-Host "💾 Haciendo commit..." -ForegroundColor Cyan
git commit -m "🌍 Refactorización completa a español

✅ Cambios realizados:
- Sistema 100% españolizado
- UserResource refactorizado (CORREGIDO problema usuarios admin)
- Archivos de idioma: app.php, auth.php, validation.php
- Seeder con datos mexicanos/latinos realistas
- Formato moneda MXN, timezone Mexico
- Helpers actualizados
- Configuración Laravel en español

🚀 Usuarios por defecto:
- superadmin@relaxarc.com / password123
- admin@relaxarc.com / admin123  
- ventas@relaxarc.com / ventas123
- + clientes de ejemplo

📋 Panel admin ahora muestra TODOS los usuarios correctamente"

if ($LASTEXITCODE -eq 0) {
    Write-Host "✅ Commit realizado exitosamente!" -ForegroundColor Green
    
    # Push a remote
    Write-Host "⬆️ Enviando cambios al repositorio..." -ForegroundColor Cyan
    git push origin main
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host "🎉 ¡Cambios enviados exitosamente!" -ForegroundColor Green
        Write-Host "🔄 Ahora ejecuta de nuevo tu script de deploy en el servidor" -ForegroundColor Yellow
    } else {
        Write-Host "❌ Error al hacer push" -ForegroundColor Red
    }
} else {
    Write-Host "❌ Error al hacer commit" -ForegroundColor Red
}

Write-Host "`n📋 Resumen de archivos modificados:" -ForegroundColor Blue
Write-Host "- ✅ UserResource.php (solucionado problema usuarios)" -ForegroundColor White
Write-Host "- ✅ config/app.php (idioma español)" -ForegroundColor White  
Write-Host "- ✅ resources/lang/es/* (traducciones)" -ForegroundColor White
Write-Host "- ✅ DatabaseSeeder.php (datos mexicanos)" -ForegroundColor White
Write-Host "- ✅ myHelpers.php (formato MXN)" -ForegroundColor White
Write-Host "- ✅ .env.example (configuración)" -ForegroundColor White
Write-Host "- ✅ README.md (documentación)" -ForegroundColor White

Write-Host "`n🚀 Próximo paso:" -ForegroundColor Green
Write-Host "Ejecuta tu script de deploy en el servidor para aplicar los cambios" -ForegroundColor Yellow
