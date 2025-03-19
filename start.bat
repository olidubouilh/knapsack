@echo off

start "PHP Server" php -S localhost:8000

timeout /t 2 /nobreak >nul

start "" "http://localhost:8000"

exit
