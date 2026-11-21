#!/usr/bin/env bash
set -e

echo "======================================================="
echo "  Đang xuất (Export) dữ liệu Database WordPress..."
echo "======================================================="

if ! docker ps | grep -qi "group_a_db"; then
    echo "[LỖI] Container 'group_a_db' chưa được khởi chạy!"
    echo "Vui lòng chạy: docker compose up -d"
    exit 1
fi

mkdir -p docker/mysql-init
docker exec group_a_db mariadb-dump -u wordpress -pwordpress wordpress > docker/mysql-init/init.sql

echo ""
echo "[THÀNH CÔNG] Đã xuất Database ra file: docker/mysql-init/init.sql"
echo "Bạn có thể commit và push file này lên Git để chia sẻ cho cả nhóm."
echo "======================================================="

