@echo off
title PHP Development Server

echo Setting working directory...
cd /d "%~dp0"

echo Starting PHP Server on localhost:8000...
start "PHP Server" cmd /k php -S localhost:8000 -t "%~dp0"

echo Waiting for server to start...
timeout /t 2 /nobreak >nul

echo Opening browser...
start "" "http://localhost:8000"

echo Server is running. Close this window to stop the server.
pause