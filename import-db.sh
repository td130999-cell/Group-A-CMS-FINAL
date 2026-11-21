#!/usr/bin/env bash
set -e

echo "======================================================="
echo "  Đang nạp (Import) dữ liệu vào Database WordPress..."
echo "======================================================="

if [ ! -f "docker/mysql-init/init.sql" ]; then
    echo "[LỖI] Không tìm thấy file 'docker/mysql-init/init.sql'!"
    exit 1
fi

if ! docker ps | grep -qi "group_a_db"; then
    echo "[LỖI] Container 'group_a_db' chưa được khởi chạy!"
    echo "Vui lòng chạy: docker compose up -d"
    exit 1
fi

docker exec -i group_a_db mariadb -u wordpress -pwordpress wordpress < docker/mysql-init/init.sql

echo ""
echo "[THÀNH CÔNG] Đã nạp toàn bộ dữ liệu từ init.sql vào Database!"
echo "Bạn có thể truy cập ngay: http://localhost:8000"
echo "======================================================="

