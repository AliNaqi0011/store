@echo off
echo Starting NexShop Servers...

echo Starting Laravel Backend...
start "Laravel Backend" cmd /k "cd /d d:\xamp neww\htdocs\hadri && php artisan serve"

timeout /t 3

echo Starting Vue Frontend...
start "Vue Frontend" cmd /k "cd /d d:\xamp neww\htdocs\hadri\frontend && npm run dev"

echo.
echo Servers are starting...
echo Backend: http://127.0.0.1:8000
echo Frontend: http://localhost:8080
echo.
pause