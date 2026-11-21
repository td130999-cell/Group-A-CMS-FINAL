# Group-A-CMS-FINAL

Dự án WordPress CMS được đóng gói và cấu hình sẵn với **Docker & Docker Compose**, hỗ trợ chạy mượt mà trên mọi hệ điều hành (**Windows**, **macOS Intel / Apple Silicon M1/M2/M3/M4**, **Linux**) mà không cần cài đặt PHP, Apache hay MySQL trực tiếp trên máy.

---

## 🚀 Hướng dẫn khởi chạy nhanh (Quick Start)

### 1. Yêu cầu tiên quyết
- Cài đặt **Docker Desktop** (trên Windows/macOS) hoặc **Docker Engine & Docker Compose** (trên Linux).
- Đảm bảo Docker đang chạy.

### 2. Khởi chạy dự án
Chỉ cần mở terminal tại thư mục gốc của dự án và chạy:

```bash
docker compose up -d
```
*(Nếu dùng Docker Compose đời cũ: `docker-compose up -d`)*

> [!NOTE]
> Database đã được đính kèm sẵn trong `docker/mysql-init/init.sql`. Khi khởi chạy lần đầu tiên, MariaDB sẽ **tự động nạp toàn bộ dữ liệu mẫu, cấu hình và tài khoản admin**, bạn không cần phải qua bước cài đặt WordPress!

### 3. Truy cập hệ thống
Sau khi các container khởi động hoàn tất:

| Dịch vụ | Địa chỉ truy cập | Ghi chú |
| :--- | :--- | :--- |
| **WordPress Web** | [http://localhost:8000](http://localhost:8000) | Giao diện website & quản trị WordPress |
| **phpMyAdmin** | [http://localhost:8081](http://localhost:8081) | Quản lý cơ sở dữ liệu qua giao diện web |
| **MariaDB (Port ngoài)** | `localhost:3307` | Dùng nếu kết nối qua DBeaver / Navicat / HeidiSQL |

---

## 🔄 Quy trình đồng bộ Database khi làm việc nhóm (Team Workflow)

Để tất cả các thành viên luôn có dữ liệu mới nhất khi code (bài viết, sản phẩm, cài plugin, menu...):

### 📤 1. Khi bạn làm xong và muốn ĐẨY DỮ LIỆU LÊN (Export trước khi Git Push)
Mỗi khi bạn tạo thêm bài viết, cài theme/plugin, hoặc thay đổi database và chuẩn bị `git push`:
- **Trên Windows:** Nháy đúp file `export-db.bat` (hoặc chạy `.\export-db.bat` trong terminal).
- **Trên Mac / Linux:** Chạy `./export-db.sh`.
- *Script sẽ tự động dump database hiện tại vào file `docker/mysql-init/init.sql`.*
- Sau đó bạn chỉ cần:
  ```bash
  git add docker/mysql-init/init.sql
  git commit -m "Cập nhật dữ liệu database"
  git push
  ```

### 📥 2. Khi bạn KÉO CODE VỀ và muốn CẬP NHẬT DỮ LIỆU MỚI (Import sau khi Git Pull)
Sau khi bạn chạy `git pull` và thấy có cập nhật trong file `docker/mysql-init/init.sql`:
- **Trên Windows:** Nháy đúp file `import-db.bat` (hoặc chạy `.\import-db.bat` trong terminal).
- **Trên Mac / Linux:** Chạy `./import-db.sh`.
- *Script sẽ nạp ngay dữ liệu mới nhất vào database mà không cần tắt hay xóa container.*

> Hoặc nếu muốn reset hoàn toàn về bản mới nhất trên repo:
> ```bash
> docker compose down -v
> docker compose up -d
> ```

---

## 🔑 Thông tin kết nối mặc định

### Tài khoản Quản trị WordPress:
- **Trang đăng nhập:** [http://localhost:8000/wp-login.php](http://localhost:8000/wp-login.php)
- **Tên đăng nhập:** `admin`

### Cơ sở dữ liệu (MariaDB):
- **Host (nội bộ container):** `db`
- **Port (nội bộ container):** `3306`
- **Host (từ máy tính của bạn):** `localhost:3307`
- **Database Name:** `wordpress`
- **Username:** `wordpress`
- **Password:** `wordpress`
- **Root Password:** `root_password`

### Đăng nhập phpMyAdmin:
- Truy cập: [http://localhost:8081](http://localhost:8081)
- Tài khoản:
  - **Username:** `wordpress`
  - **Password:** `wordpress`
  *(Hoặc `root` / `root_password`)*

---

## ⚙️ Tùy chỉnh cổng & cấu hình (`.env`)

Mặc định dự án có sẵn cấu hình trong `.env` (hoặc tạo từ `.env.example`). Nếu cổng `8000`, `8081` hoặc `3307` trên máy bạn bị trùng với ứng dụng khác, bạn chỉ cần sửa trong file `.env`:

```env
# Đổi cổng truy cập
WORDPRESS_PORT=8000    # Đổi thành 8080 nếu 8000 bận
PMA_PORT=8081          # Đổi thành 8082 nếu 8081 bận
DB_PORT=3307           # Đổi thành 3308 nếu 3307 bận

# Thông tin cơ sở dữ liệu
DB_NAME=wordpress
DB_USER=wordpress
DB_PASSWORD=wordpress
DB_ROOT_PASSWORD=root_password
```

Sau khi sửa, khởi động lại container:
```bash
docker compose up -d
```

---

## 🛠️ Các lệnh Docker thường dùng

| Thao tác | Lệnh |
| :--- | :--- |
| **Khởi chạy nền** | `docker compose up -d` |
| **Xem trạng thái containers** | `docker compose ps` |
| **Xem logs WordPress** | `docker compose logs -f wordpress` |
| **Dừng hệ thống** | `docker compose stop` |
| **Tắt và dọn dẹp containers** | `docker compose down` |
| **Xóa sạch cả database để cài lại từ đầu** | `docker compose down -v` |
| **Khởi động lại một dịch vụ** | `docker compose restart wordpress` |

---

## 💡 Các tính năng cấu hình đặc biệt đã được tối ưu sẵn

1. **Tự động nhận diện Domain/Port (`WP_SITEURL` & `WP_HOME`)**:
   - Dù bạn mở bằng `localhost:8000`, `127.0.0.1:8000` hay IP mạng LAN `192.168.x.x:8000`, WordPress đều tự thích ứng, không bị lỗi chuyển hướng (redirect loop) hay lỗi vỡ giao diện.
2. **Cài đặt Plugin / Theme trực tiếp**:
   - Đã cấu hình `FS_METHOD = 'direct'` để WordPress không yêu cầu nhập tài khoản FTP khi cài đặt plugin, theme hoặc tải ảnh lên.
3. **Tăng giới hạn upload file PHP**:
   - Đã tăng `upload_max_filesize` và `post_max_size` lên **128MB**, `memory_limit` lên **512MB** (trong `docker/php/uploads.ini`) để thoải mái cài theme nặng.
4. **Healthcheck DB chống lỗi race-condition**:
   - WordPress chỉ khởi động sau khi MariaDB đã hoàn tất khởi tạo và sẵn sàng nhận kết nối, loại bỏ triệt để lỗi *"Error establishing a database connection"* khi lần đầu chạy `docker compose up`.