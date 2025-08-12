@echo off
echo Iniciando commit de cambios...
cd "C:\GitHub\relaxarc-travel"

echo Agregando archivos...
git add .

echo Haciendo commit...
git commit -m "Refactorizacion completa a español - SOLUCIONADO problema usuarios admin"

echo Enviando cambios...
git push origin main

echo.
echo Proceso completado!
echo Ahora ejecuta tu script de deploy en el servidor
pause
