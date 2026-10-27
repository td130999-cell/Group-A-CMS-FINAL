# KẾ HOẠCH TOÀN DIỆN: CHUYỂN ĐỔI 100% NỘI DUNG TĨNH THÀNH ĐỘNG QUA WP-ADMIN

> **Mục đích tài liệu:** Đây là file kim chỉ nam lưu tại thư mục gốc của dự án. Mọi tác vụ code sau này bắt buộc phải bám sát tài liệu này để triển khai từng trang, đảm bảo không bỏ sót bất kỳ phần tử nào trên giao diện và tuân thủ các nguyên tắc bất biến.

---

## ⛔ 2 NGUYÊN TẮC BẤT BIẾN (BẮT BUỘC TUÂN THỦ TUYỆT ĐỐI)

1. **KHÔNG ĐƯỢC ĐỤNG ĐẾN GIT:**
   - Tuyệt đối không chạy các lệnh git (`git add`, `git commit`, `git push`, `git checkout`, `git reset`,...).
   - Mọi thao tác chỉ diễn ra trên mã nguồn cục bộ và database container.

2. **GIỮ NGUYÊN 100% LAYOUT, GIAO DIỆN VÀ FONT CHỮ:**
   - Giao diện, bố cục (layout HTML/CSS), khoảng cách (padding/margin), màu sắc và font chữ hiện tại đang **chuẩn xác và rất đẹp**.
   - **Tuyệt đối không thay đổi cấu trúc thẻ HTML, class CSS hay file style**.
   - Chỉ thay thế các đoạn chữ/đường dẫn ảnh tĩnh (hardcode) bằng các biến PHP đọc từ Database (`get_option()`, `get_post_meta()`).
   - Mọi trường dữ liệu đều phải có **Fallback (giá trị mặc định)** chính là nội dung hiện tại, đảm bảo nếu admin chưa nhập hoặc xóa trống thì giao diện vẫn giữ nguyên thiết kế đẹp mắt ban đầu, không bao giờ vỡ giao diện hay lỗi PHP.

---

## 🎯 CƠ CHẾ KỸ THUẬT CHUNG

1. **Quản trị trực quan trên Trình duyệt (wp-admin):**
   - Sử dụng các trang cài đặt chuyên dụng (Submenu trong **Giao diện**) hoặc **Custom Meta Box** chuẩn WordPress khi chỉnh sửa từng trang trong **Pages (Trang)**.
   - Hỗ trợ chọn/tải ảnh trực quan qua **WordPress Media Library** (trình quản lý tệp có sẵn của WordPress).

2. **Lưu trữ chuẩn vào Cơ sở dữ liệu:**
   - Các cấu hình chung toàn trang / toàn site: Lưu vào bảng `wp_options` thông qua `update_option()`.
   - Các thuộc tính gắn liền với từng Trang / Sản phẩm: Lưu vào bảng `wp_postmeta` thông qua `update_post_meta()`.
   - Luôn sử dụng `wp_verify_nonce()` và lọc dữ liệu đầu vào an toàn (`sanitize_text_field`, `wp_kses_post`, `esc_url_raw`).

3. **Cập nhật hiển thị ra ngoài ngay lập tức (Real-time Sync):**
   - Mỗi khi admin nhấn **Lưu (Save / Update)**, hook lưu dữ liệu sẽ tự động thực thi lệnh xóa transient cache (`delete_transient()`, `clean_post_cache()`).
   - Khách xem web hoặc admin chỉ cần bấm **F5 (Tải lại trang)** là thấy ngay dữ liệu mới nhất mà không bị vướng bộ nhớ đệm.

---

## 📋 CHECKLIST KẾ HOẠCH CHI TIẾT TỪNG TRANG

### 🏠 1. TRANG CHỦ (Home Page - `/`) - [HOÀN THÀNH 100%]
File pattern: `wp-content/themes/coffee-cafe-corner/patterns/home-quills.php`  
Nơi quản trị: `wp-admin -> Giao diện -> Cài đặt Trang chủ (Home)`

- [x] **Section 1: Hero Banner**
  - [x] Đã có: Tiêu đề, Phụ đề, Chữ nút CTA, Link nút CTA, Dòng đánh giá sao, Câu trích dẫn khách hàng.
  - [x] Ô chọn ảnh nền Hero Banner qua Media Library (kèm nút Khôi phục mặc định).
  - [x] Ô chọn 4 ảnh Logo báo chí đối tác (*Garden & Gun, Cosmopolitan, Food & Wine, Courier Journal*).
  - [x] Nhãn báo chí (*"Featured in"*).

- [x] **Section 2: Đội ngũ ("NO ROBOTS. JUST PEOPLE.")**
  - [x] Đã có: Tiêu đề mục, 5 đoạn văn giới thiệu, Nút CTA chữ & link, Lời trích dẫn.
  - [x] Ô chọn ảnh đại diện đội ngũ (anh Nathan) qua Media Library.

- [x] **Section 3: Gói đăng ký định kỳ 3 bước ("Coffee subscriptions...")**
  - [x] Tiêu đề chính của phần (*"Coffee subscriptions. Change, pause, or cancel anytime."*).
  - [x] Bước 1: Icon/Ảnh, Tiêu đề bước (*"1. PICK YOUR SUBSCRIPTION"*), Đoạn văn mô tả.
  - [x] Bước 2: Icon/Ảnh, Tiêu đề bước (*"2. PICK HOW OFTEN"*), Đoạn văn mô tả.
  - [x] Bước 3: Icon/Ảnh, Tiêu đề bước (*"3. ENJOY IT FROM NOW ON"*), Đoạn văn mô tả.
  - [x] Chữ và Link nút CTA (*"FIND THE SUBSCRIPTION FOR YOU"*).
  - [x] Lời trích dẫn đánh giá và Tên khách hàng (*Athena S.*).

- [x] **Section 4: Xưởng rang ("ROASTED LOCALLY BY US")**
  - [x] Ảnh xưởng rang / thợ rang (Justin) chọn qua Media Library.
  - [x] Tiêu đề mục (*"ROASTED LOCALLY BY US"*).
  - [x] 5 đoạn văn kể chuyện về quy trình rang hạt thủ công.
  - [x] Chữ & Link nút CTA (*"SEARCH BY ROAST"*).
  - [x] Lời trích dẫn và nguồn trích dẫn (*Crema Guru*).

- [x] **Section 5: Nguồn gốc hạt tuyển chọn ("HAND-PICKED BY FARMERS, HAND SELECTED BY US")**
  - [x] Ảnh nông trại cà phê chọn qua Media Library.
  - [x] Tiêu đề mục (*"HAND-PICKED BY FARMERS, HAND SELECTED BY US"*).
  - [x] 5 đoạn văn kể chuyện về tiêu chuẩn 15% hạt đặc sản.
  - [x] Chữ & Link nút CTA (*"SEE WHAT WE FOUND FOR YOU"*).
  - [x] Lời trích dẫn và Tên người đánh giá (*Preston S.*).

- [x] **Section 6: Huy hiệu tròn ("COFFEE CONNECT PEOPLE")**
  - [x] Ô chọn ảnh huy hiệu tròn qua Media Library.

- [x] **Section 7: Sản phẩm bán chạy ("Our Bestsellers")**
  - [x] Tiêu đề mục (*"Our Bestsellers"*) & Phụ đề (*"The ones people keep coming back for."*).
  - [x] Quản lý 3 sản phẩm bán chạy qua `wp-admin -> Products` (Tên, Giá, Ảnh trước/sau, Tag, Màu sắc Tag, Mô tả Tag, Tasting Notes, Xuất xứ, Sơ chế).

- [x] **Section 8: Buổi thử nếm cà phê ("TASTE-TESTED TWICE A WEEK")**
  - [x] Ảnh buổi thử nếm Cupping chọn qua Media Library.
  - [x] Tiêu đề mục (*"TASTE-TESTED TWICE A WEEK"*).
  - [x] 3 đoạn văn giới thiệu kiểm định chất lượng hàng tuần.
  - [x] Chữ & Link nút CTA (*"SHOW ME THE COFFEE"*).
  - [x] Lời trích dẫn và Tên người đánh giá (*Amie M*).

- [x] **Section 9: Câu hỏi thường gặp (FAQ Accordion)**
  - [x] Tiêu đề mục (*"FAQ"*).
  - [x] Quản lý 4 câu hỏi và câu trả lời trong mục FAQ Accordion (hỗ trợ HTML / liên kết tuyển dụng).

- [x] **Section 10: Đăng ký nhận bản tin ("THE HOOT")**
  - [x] Tiêu đề (*"THE HOOT"*), Icon cú vọ qua Media Library.
  - [x] Toàn bộ 5 đoạn văn mô tả thư ngỏ thứ Sáu.
  - [x] Số lượng người đăng ký nổi bật (*"8,212 kind folks"*).
  - [x] Cấu hình ID form Contact Form 7 hoặc nút bấm fallback (*"TRY IT"*).

---

### ☕ 2. TRANG CÀ PHÊ (Coffee Collection - `/coffee/`)
File pattern: `wp-content/themes/coffee-cafe-corner/patterns/coffee.php`  
Nơi quản trị: `wp-admin -> Giao diện -> Cài đặt Trang Cà phê (Coffee)` HOẶC `wp-admin -> Pages (Trang) -> Coffee` (qua Custom Meta Box)

- [x] **Hero Banner & Breadcrumbs:**
  - [x] Tiêu đề trang (mặc định: "Coffee").
  - [x] Ảnh nền Hero Banner qua Media Library + Nút Khôi phục mặc định.
  - [x] Chữ Breadcrumbs ("Home / Coffee").
- [x] **Khung thông báo lịch rang (Roasting Announcement):**
  - [x] Tiêu đề thông báo cam kết độ tươi.
  - [x] Chi tiết lịch chốt đơn và ngày xuất xưởng (chủ nhật giao thứ 4, thứ ba giao thứ 6 - hỗ trợ `<br>`).
- [x] **Slider đánh giá khách hàng (Top Testimonial Slider):**
  - [x] 3 Slide đánh giá: Nội dung trích dẫn & Tên khách hàng (Tracy S., Michael K., Amanda L.).
  - [x] Đồng bộ tự động với cả mã HTML máy chủ và JavaScript slider (`window.quillsTopQuotes`).
- [x] **Các tab lọc nhanh (Category Pills):**
  - [x] Tùy chỉnh 4 nhãn hiển thị: Blends, Single Origin, Espresso, Decaf.
- [x] **Khối đánh giá khách hàng cuối trang (Bottom Customer Testimonials):**
  - [x] Tiêu đề mục ("More kind words from customers").
  - [x] 3 Slide đánh giá: Nội dung trích dẫn & Tên tác giả (Mitchell George, Sarah Jenkins, David R.).
  - [x] Đồng bộ tự động với JavaScript slider (`window.quillsBottomQuotes`).
- [x] **Danh sách sản phẩm & Bộ lọc Accordion:** Đã hoạt động tự động từ Database WooCommerce.

---

### ⚙️ 3. TRANG DỤNG CỤ PHA (Brew Gear - `/brew-gear/`)
File pattern: `wp-content/themes/coffee-cafe-corner/patterns/brew-gear.php`  
Nơi quản trị: `wp-admin -> Giao diện -> Cài đặt Dụng cụ (Brew Gear)` HOẶC `wp-admin -> Pages (Trang) -> Brew Gear` (qua Custom Meta Box)

- [x] **Hero Banner & Breadcrumbs:**
  - [x] Tiêu đề banner (*mặc định: "Brew Gear"*).
  - [x] Chọn Ảnh nền banner qua Media Library + Nút Khôi phục mặc định.
  - [x] Chữ Breadcrumbs (*"Home / Brew Gear"*).
- [x] **Thanh công cụ & Nút bấm:**
  - [x] Nhãn thanh sắp xếp (*mặc định: "Sort by:"*).
  - [x] Chữ trên nút thêm giỏ hàng (*mặc định: "ADD TO CART"*).
  - [x] Thông báo khi không có sản phẩm (*mặc định: "No products found."*).
- [x] **Quản lý nhanh 3 thiết bị dụng cụ pha:** Cho phép sửa nhanh tên, giá thiết bị và link trực tiếp sang WooCommerce.
- [x] **Danh sách sản phẩm dụng cụ:** Đã tự động lọc từ danh mục `brew-gear` của WooCommerce.

---

### 📦 4. TRANG GÓI ĐỊNG KỲ (Subscriptions - `/subscriptions/`)
File pattern: `wp-content/themes/coffee-cafe-corner/patterns/subscriptions.php`  
Nơi quản trị: `wp-admin -> Giao diện -> Cài đặt Gói định kỳ (Subscriptions)` HOẶC `wp-admin -> Pages (Trang) -> Subscriptions` (qua Custom Meta Box)

- [x] **Hero Banner & Breadcrumbs:**
  - [x] Tiêu đề banner (*"Subscriptions"*).
  - [x] Chọn Ảnh nền banner qua Media Library + Nút Khôi phục mặc định.
  - [x] Chữ Breadcrumbs (*"Home / Subscriptions"*).
- [x] **Khung ưu đãi túi quà tặng (Free Bag Intro):**
  - [x] Tiêu đề ưu đãi (*"Get a free 12oz bag of Inkwell when you subscribe."*).
  - [x] Đoạn văn mô tả ưu đãi.
  - [x] Dòng ghi chú điều kiện (*"(Free bag offer valid for new subscribers only.)"*).
- [x] **Slider đánh giá phía trên (Top Testimonial Slider):**
  - [x] Quản lý 3 đánh giá khách hàng (Nội dung trích dẫn, Tác giả: C. Diller, Brianne E., Kelly Davis).
- [x] **Mục đánh giá phía dưới ("More kind words from customers"):**
  - [x] Tiêu đề mục (*"More kind words from customers"*).
  - [x] Quản lý 3 đánh giá khách hàng phía dưới (Nội dung trích dẫn, Tác giả: Jamie W., Lisa Peters, Sarah R.).
- [x] **Danh sách sản phẩm gói định kỳ & Bộ lọc:** Đã kết nối tự động từ WooCommerce.

---

### 👕 5. TRANG HÀNG LƯU NIỆM (Merch - `/merch/`)
File pattern: `wp-content/themes/coffee-cafe-corner/patterns/merch.php`  
Nơi quản trị: `wp-admin -> Pages (Trang) -> Merch` (qua Custom Meta Box)

- [ ] **Hero Banner:**
  - [ ] Tiêu đề banner (*"Merch"*).
  - [ ] Chọn Ảnh nền banner qua Media Library.
  - [ ] Đoạn giới thiệu bộ sưu tập thời trang / phụ kiện Quills.
- [x] **Danh sách sản phẩm Merch:** Đã kết nối tự động với tùy chọn size áo/mũ từ WooCommerce.

---

### 🤝 6. TRANG BÁN BUÔN & HỢP TÁC (Wholesale - `/wholesale/`)
File pattern: `wp-content/themes/coffee-cafe-corner/patterns/wholesale.php`  
Nơi quản trị: `wp-admin -> Pages (Trang) -> Wholesale` (qua Custom Meta Box)

- [ ] **Hero Banner:**
  - [ ] Tiêu đề Hero (*"Wholesale Coffee Roasting"*).
- [ ] **Mục Video & Câu chuyện giới thiệu:**
  - [ ] ID video Wistia (hoặc link nhúng video).
  - [ ] Tiêu đề câu chuyện của Michael.
  - [ ] Đoạn văn mở đầu nổi bật và các đoạn văn chi tiết.
- [ ] **Form yêu cầu gửi mẫu thử (Sample Request Form):**
  - [ ] Tiêu đề khung (*"Request Free Samples"*).
  - [ ] Đoạn mô tả phụ.
  - [ ] Ước tính thời gian (*"Takes 2 minutes"*).
  - [ ] Chữ trên nút bắt đầu (*"Get started"*).

---

### 🎁 7. TRANG THẺ QUÀ TẶNG (Gift Cards - `/gift-cards/`)
File pattern: `wp-content/themes/coffee-cafe-corner/patterns/gift-cards.php`  
Nơi quản trị: `wp-admin -> Pages (Trang) -> Gift Cards` (qua Custom Meta Box)

- [ ] **Header trang:**
  - [ ] Tiêu đề trang (*"Gift Cards"*).
  - [ ] Đoạn văn hướng dẫn phân biệt 2 loại thẻ online và tại quán.
- [ ] **Cột 1: Thẻ Quà Tặng Mua Sắm Online (Online Store Gift Card)**
  - [ ] Tên thẻ (*"ONLINE STORE GIFT CARD"*).
  - [ ] Đoạn mô tả công dụng.
  - [ ] Chọn ảnh thẻ qua Media Library.
  - [ ] Chọn sản phẩm WooCommerce liên kết hoặc nhập link mua.
  - [ ] Chữ trên nút bấm (*"CLICK HERE TO PURCHASE"*).
- [ ] **Cột 2: Thẻ Quà Tặng Dùng Tại Quán (Cafe / In Store Gift Card)**
  - [ ] Tên thẻ (*"CAFE GIFT CARD"*).
  - [ ] Đoạn mô tả dùng tại quầy.
  - [ ] Chọn ảnh thẻ qua Media Library.
  - [ ] Đường link thanh toán Square / POS (*mặc định: link Square của quán*).
  - [ ] Chữ trên nút bấm (*"CLICK HERE TO PURCHASE"*).

---

### 📖 8. TRANG GIỚI THIỆU (About Us) & QUÁN CAFE (Cafes/Visit)
File pattern: `patterns/about.php`, `patterns/visit.php`, `patterns/cafe-detail.php`  
Nơi quản trị: `wp-admin -> Pages -> About Us` và Menu **Quán Cafe (Cafes)**

- [x] Đã có hệ thống quản lý rất tốt các nội dung chính.
- [ ] Cần rà soát và bổ sung:
  - [ ] Trang About Us: Thêm ô chọn ảnh Media Library cho các hình minh họa (*about-hero.jpg, terroir.png, genuine-care.png, continuous-craft.png, creative-education.png*).
  - [ ] Trang Quán Cafe: Đảm bảo toàn bộ 7 quán đều có thể chọn ảnh từ Media Library mà không cần hardcode tên file.

---

### 🌐 9. HEADER & FOOTER TOÀN WEBSITE
File: `wp-content/themes/coffee-cafe-corner/patterns/footer.php` và `parts/header.html`  
Nơi quản trị: Tạo trang riêng **Giao diện $\rightarrow$ Cài đặt Chân trang (Footer Settings)**

- [ ] **Chân trang (Footer):**
  - [ ] Tên thương hiệu (*"QUILLS COFFEE"*).
  - [ ] Địa chỉ dòng 1 (Tên đường), Địa chỉ dòng 2 (Thành phố, Bang, Mã Zip).
  - [ ] Số điện thoại liên hệ, Email hỗ trợ khách hàng.
  - [ ] Link mạng xã hội: Facebook, Instagram.
  - [ ] Dòng chữ bản quyền chân trang (*hỗ trợ token `{year}` tự động nhảy năm hiện tại*).
- [ ] **Đầu trang (Header):**
  - [ ] Quản lý Logo và Menu điều hướng chuẩn qua **Giao diện $\rightarrow$ Menus**.

---

## 🔍 QUY TRÌNH KIỂM THỬ SAU KHI LÀM TỪNG TRANG
Với mỗi trang sau khi code xong:
1. Vào `wp-admin` trên trình duyệt $\rightarrow$ Mở trang quản trị của trang đó.
2. Thử thay đổi 1 đoạn text và 1 ảnh $\rightarrow$ Bấm nút **Lưu / Cập nhật**.
3. Mở tab trình duyệt ẩn danh (hoặc tải lại trang ngoài frontend bằng `Ctrl + F5`).
4. Kiểm tra xem dữ liệu mới đã hiển thị ngay lập tức chưa.
5. Kiểm tra layout, khoảng cách, font chữ xem có bị xô lệch hay mất định dạng không (phải khớp 100% với giao diện gốc).
6. Thử xóa trắng ô dữ liệu $\rightarrow$ Bấm Lưu $\rightarrow$ Kiểm tra xem cơ chế Fallback mặc định có tự động hiện ra nguyên vẹn không.

