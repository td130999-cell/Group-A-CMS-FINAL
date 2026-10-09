# Database Initialization Scripts

Đặt các file `.sql` hoặc `.sql.gz` vào thư mục này nếu bạn muốn tự động import database khi khởi động container MariaDB lần đầu tiên.

Lưu ý:
- Container chỉ tự động chạy các script trong thư mục này khi database volume (`db_data`) **chưa từng được khởi tạo** (lần chạy đầu tiên).
- Nếu muốn chạy lại file init, bạn cần xóa volume cũ bằng lệnh:
  `docker compose down -v`
  sau đó chạy lại:
  `docker compose up -d`

