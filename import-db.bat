@echo off
setlocal
chcp 65001 >nul
echo =======================================================
echo   Dang nap (Import) du lieu vao Database WordPress...
echo =======================================================

if not exist "docker\mysql-init\init.sql" (
    echo [LOI] Khong tim thay file 'docker\mysql-init\init.sql'!
    pause
    exit /b 1
)

docker ps | findstr /i "group_a_db" >nul
if errorlevel 1 (
    echo [LOI] Container 'group_a_db' chua duoc khoi chay!
    echo Vui long chay: docker compose up -d
    pause
    exit /b 1
)

docker exec -i group_a_db mariadb -u wordpress -pwordpress wordpress < "docker\mysql-init\init.sql"

if %ERRORLEVEL% EQU 0 (
    echo.
    echo [THANH CONG] Da nap toan bo du lieu tu init.sql vao Database!
    echo Ban co the truy cap ngay: http://localhost:8000
) else (
    echo.
    echo [LOI] Co loi xay ra trong qua trinh nap database!
)

echo =======================================================
pause

