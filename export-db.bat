@echo off
setlocal
chcp 65001 >nul
echo =======================================================
echo   Dang xuat (Export) du lieu Database WordPress...
echo =======================================================

docker ps | findstr /i "group_a_db" >nul
if errorlevel 1 (
    echo [LOI] Container 'group_a_db' chua duoc khoi chay!
    echo Vui long chay: docker compose up -d
    pause
    exit /b 1
)

if not exist "docker\mysql-init" mkdir "docker\mysql-init"

docker exec group_a_db mariadb-dump -u wordpress -pwordpress wordpress > "docker\mysql-init\init.sql"

if %ERRORLEVEL% EQU 0 (
    echo.
    echo [THANH CONG] Da xuat Database ra file: docker\mysql-init\init.sql
    echo Ban co the commit va push file nay len Git de chia se cho ca nhom.
) else (
    echo.
    echo [LOI] Co loi xay ra trong qua trinh xuat database!
)

echo =======================================================
pause

