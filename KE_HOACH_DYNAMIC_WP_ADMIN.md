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

### ☕ 2. TRANG CÀ PHÊ (Coffee Collection - `/coffee/`) - [HOÀN THÀNH 100%]
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

### ⚙️ 3. TRANG DỤNG CỤ PHA (Brew Gear - `/brew-gear/`) - [HOÀN THÀNH 100%]
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

### 📦 4. TRANG GÓI ĐỊNG KỲ (Subscriptions - `/subscriptions/`) - [HOÀN THÀNH 100%]
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

### 👕 5. TRANG HÀNG LƯU NIỆM (Merch - `/merch/`) - [HOÀN THÀNH 100%]
File pattern: `wp-content/themes/coffee-cafe-corner/patterns/merch.php`  
Nơi quản trị: `wp-admin -> Giao diện -> Cài đặt Hàng lưu niệm (Merch)` HOẶC `wp-admin -> Pages (Trang) -> Merch` (qua Custom Meta Box)

- [x] **Hero Banner & Breadcrumbs:**
  - [x] Tiêu đề banner (*"Merch"*).
  - [x] Chọn Ảnh nền banner qua Media Library + Nút Khôi phục mặc định.
  - [x] Chữ Breadcrumbs (*"Home / Merch"*).
- [x] **Thanh công cụ & Nhãn nút bấm:**
  - [x] Nhãn thanh sắp xếp (*"Sort by:"*).
  - [x] Chữ trên nút thêm giỏ hàng (*"ADD TO CART"*).
  - [x] Chữ hiển thị khi sản phẩm hết hàng (*"SOLD OUT"*).
  - [x] Thông báo khi không có sản phẩm (*"No products found."*).
- [x] **Danh sách sản phẩm Merch:** Đã kết nối tự động với tùy chọn size áo/mũ từ WooCommerce.

---

### 🤝 6. TRANG BÁN BUÔN & HỢP TÁC (Wholesale - `/wholesale/`) - [HOÀN THÀNH 100%]
File pattern: `wp-content/themes/coffee-cafe-corner/patterns/wholesale.php`  
Nơi quản trị: `wp-admin -> Giao diện -> Cài đặt Bán buôn (Wholesale)` HOẶC `wp-admin -> Pages (Trang) -> Wholesale` (qua Custom Meta Box)

- [x] **Hero Banner:**
  - [x] Tiêu đề Hero (*"Wholesale Coffee Roasting"*).
- [x] **Mục Video Wistia & Câu chuyện giới thiệu:**
  - [x] ID video Wistia (`zihbfybcjm`) và phụ đề video.
  - [x] Tiêu đề câu chuyện của Michael (*"Hey there! I'm Michael."*).
  - [x] Đoạn văn mở đầu nổi bật và 3 đoạn văn chi tiết.
- [x] **Form yêu cầu gửi mẫu thử (Sample Request Form):**
  - [x] Chế độ form: Direct Form hoặc Typeform Embed (ID Typeform tùy chỉnh).
  - [x] Tiêu đề khung (*"Request your samples"*).
  - [x] Đoạn mô tả phụ (*"Tell us a little about you and your business"*).
  - [x] Ước tính thời gian (*"Takes 1 minute"*).
  - [x] Chữ trên nút bắt đầu (*"Get started"*), nút gửi (*"Send Sample Request"*), thông báo thành công.

---

### 🎁 7. TRANG THẺ QUÀ TẶNG (Gift Cards - `/gift-cards/`) - [HOÀN THÀNH 100%]
File pattern: `wp-content/themes/coffee-cafe-corner/patterns/gift-cards.php`  
Nơi quản trị: `wp-admin -> Giao diện -> Cài đặt Thẻ quà tặng (Gift Cards)` HOẶC `wp-admin -> Pages (Trang) -> Gift Cards` (qua Custom Meta Box)

- [x] **Header trang:**
  - [x] Tiêu đề trang (*"Gift Cards"*).
  - [x] Đoạn văn hướng dẫn phân biệt 2 loại thẻ online và tại quán (hỗ trợ 2 đoạn dẫn).
- [x] **Cột 1: Thẻ Quà Tặng Mua Sắm Online (Online Store Gift Card)**
  - [x] Tên thẻ (*"ONLINE STORE GIFT CARD"*).
  - [x] Đoạn mô tả công dụng (dòng 1 & dòng 2, hỗ trợ thẻ HTML).
  - [x] Chọn ảnh thẻ qua Media Library + Nút Khôi phục.
  - [x] Nhập link mua tùy chỉnh hoặc liên kết tự động tới sản phẩm Gift Card trên WooCommerce.
  - [x] Chữ trên nút bấm (*"CLICK HERE TO PURCHASE"*).
- [x] **Cột 2: Thẻ Quà Tặng Dùng Tại Quán (Cafe / In Store Gift Card)**
  - [x] Tên thẻ (*"CAFE / IN STORE GIFT CARD"*).
  - [x] Đoạn mô tả dùng tại quầy (dòng 1 & dòng 2, hỗ trợ thẻ HTML).
  - [x] Chọn ảnh thẻ qua Media Library + Nút Khôi phục.
  - [x] Đường link thanh toán Square / POS (*mặc định: link Square của quán*).
  - [x] Chữ trên nút bấm (*"CLICK HERE TO PURCHASE"*).

---

### 📖 8. TRANG GIỚI THIỆU (About Us) & QUÁN CAFE (Cafes/Visit) - [HOÀN THÀNH 100%]
File pattern: `patterns/about.php`, `patterns/visit.php`, `patterns/cafe-detail.php`  
Nơi quản trị: `wp-admin -> Giao diện -> Cài đặt Giới thiệu (About Us)`, `Cài đặt Chi nhánh (Visit)`, `Pages -> About Us / Visit`, và Menu **Quán Cafe (Cafes)**

- [x] **Trang Giới thiệu (About Us):**
  - [x] Quản trị toàn bộ 10 phần: Hero Banner, Lịch sử Where We Started, Sứ mệnh Why We're Here, Phương thức How We Work, Thẻ định nghĩa Terroir, 3 Giá trị cốt lõi (Genuine Care, Continuous Craft, Creative Education), Tầm nhìn Where We're Going, và Ảnh đội ngũ cuối trang.
  - [x] Tích hợp trọn bộ bộ chọn ảnh WordPress Media Library + Xem trước ảnh thực tế + Nút khôi phục cho toàn bộ 7 hình ảnh (*about-hero.jpg, why-were-here.jpg, terroir.png, genuine-care.png, continuous-craft.jpg, creative-education.jpg, where-were-going.jpg*).
  - [x] Đồng bộ 2 chiều giữa `wp_options` và `wp_postmeta` của cả 2 trang `about-us` và `about`.
- [x] **Trang Chi nhánh & Giờ mở cửa (Visit / Locations & Hours):**
  - [x] Quản lý chữ Breadcrumb (*"Locations & Hours"*), Tiêu đề Hero (*"Our Cafes"*), Ảnh nền Banner qua Media Library, Lời giới thiệu chung và Tiêu đề danh sách quán (*"LOCATIONS & HOURS"*).
- [x] **Quản lý Chi tiết 7 Chi nhánh Quán Cafe:**
  - [x] Menu chuyên dụng **Quán Cafe (Cafes)** với 7 tab: Nulu, Highlands, Indianapolis, St. Matthews, J-Town, Norton Commons, Frankfort Avenue.
  - [x] Chọn ảnh chính (Main Banner) và 3 ảnh bộ sưu tập (Gallery 1, 2, 3) qua WordPress Media Library.
  - [x] Tự động xóa bộ nhớ đệm (RAM cache & File cache) ngay khi bấm Lưu quán.

---

### 🌐 9. HEADER & FOOTER TOÀN WEBSITE - [HOÀN THÀNH 100%]
File: `wp-content/themes/coffee-cafe-corner/patterns/footer.php` và `parts/header.html`  
Nơi quản trị: Menu chuyên dụng **Giao diện -> Cài đặt Chân trang (Footer Settings)**

- [x] **Chân trang (Footer):**
  - [x] Tên thương hiệu (*"QUILLS COFFEE"*).
  - [x] Địa chỉ dòng 1 (Tên đường), Địa chỉ dòng 2 (Thành phố, Bang, Mã Zip).
  - [x] Số điện thoại liên hệ, Email hỗ trợ khách hàng.
  - [x] Mã tiền tệ hiển thị (mặc định: "USD"), Ngôn ngữ mặc định (hỗ trợ chuyển đổi song ngữ EN / VI).
  - [x] Link mạng xã hội: Facebook, Instagram.
  - [x] Dòng chữ bản quyền chân trang (*hỗ trợ token `{year}` tự động nhảy năm hiện tại*).
  - [x] Hướng dẫn và liên kết trực tiếp tới quản lý 2 menu chân trang (Quick Links và Company) qua **Giao diện -> Menus**.
- [x] **Đầu trang (Header):**
  - [x] Quản lý Logo và Menu điều hướng chuẩn qua **Giao diện -> Menus**.

---

## 🔍 QUY TRÌNH KIỂM THỬ SAU KHI LÀM TỪNG TRANG
Với mỗi trang sau khi code xong:
1. Vào `wp-admin` trên trình duyệt $\rightarrow$ Mở trang quản trị của trang đó.
2. Thử thay đổi 1 đoạn text và 1 ảnh $\rightarrow$ Bấm nút **Lưu / Cập nhật**.
3. Mở tab trình duyệt ẩn danh (hoặc tải lại trang ngoài frontend bằng `Ctrl + F5`).
4. Kiểm tra xem dữ liệu mới đã hiển thị ngay lập tức chưa.
5. Kiểm tra layout, khoảng cách, font chữ xem có bị xô lệch hay mất định dạng không (phải khớp 100% với giao diện gốc).
6. Thử xóa trắng ô dữ liệu $\rightarrow$ Bấm Lưu $\rightarrow$ Kiểm tra xem cơ chế Fallback mặc định có tự động hiện ra nguyên vẹn không.

