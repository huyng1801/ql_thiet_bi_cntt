CREATE TABLE quan_huyen (
    ma_quan_huyen VARCHAR(10) PRIMARY KEY,
    ten_quan_huyen VARCHAR(100) NOT NULL
);

CREATE TABLE buu_cuc (
    ma_buu_cuc VARCHAR(10) PRIMARY KEY,
    ten_buu_cuc VARCHAR(100) NOT NULL,
    ma_quan_huyen VARCHAR(10),
    FOREIGN KEY (ma_quan_huyen) REFERENCES quan_huyen(ma_quan_huyen) ON DELETE CASCADE
);

CREATE TABLE danh_muc_thiet_bi (  
    ma_danh_muc INT AUTO_INCREMENT PRIMARY KEY,
    ten_danh_muc VARCHAR(100) NOT NULL
);

CREATE TABLE thiet_bi (
    ma_thiet_bi INT AUTO_INCREMENT PRIMARY KEY,
    ten_thiet_bi VARCHAR(100) NOT NULL,
    ma_sn VARCHAR(20) NOT NULL,
    hinh_anh TEXT,
    ma_buu_cuc VARCHAR(10),
    ghi_chu TEXT,
    ma_danh_muc INT,
    FOREIGN KEY (ma_danh_muc) REFERENCES danh_muc_thiet_bi(ma_danh_muc) ON DELETE CASCADE,
    FOREIGN KEY (ma_buu_cuc) REFERENCES buu_cuc(ma_buu_cuc) ON DELETE CASCADE
);

CREATE TABLE users (
    ten_nguoi_dung VARCHAR(50) PRIMARY KEY,
    mat_khau VARCHAR(128) NOT NULL
);

CREATE TABLE nhap ( 
    ma_nhap INT AUTO_INCREMENT PRIMARY KEY,
    thoi_gian_nhan TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    noi_xuat VARCHAR(100) NOT NULL,
    ma_buu_cuc VARCHAR(10),
    user_nhan VARCHAR(50),
    FOREIGN KEY (user_nhan) REFERENCES users(ten_nguoi_dung) ON DELETE CASCADE,
    FOREIGN KEY (ma_buu_cuc) REFERENCES buu_cuc(ma_buu_cuc) ON DELETE CASCADE
);

CREATE TABLE chi_tiet_nhap (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ma_nhap INT,
    ten_thiet_bi VARCHAR(100) NOT NULL,
    hinh_anh TEXT,
    xuat_xu VARCHAR(100),
    ma_danh_muc INT,
    ma_sn VARCHAR(20),
    FOREIGN KEY (ma_danh_muc) REFERENCES danh_muc_thiet_bi(ma_danh_muc) ON DELETE CASCADE,
    FOREIGN KEY (ma_nhap) REFERENCES nhap(ma_nhap) ON DELETE CASCADE
);

CREATE TABLE xuat ( 
    ma_xuat INT AUTO_INCREMENT PRIMARY KEY,
    thoi_gian_xuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  
    noi_nhan VARCHAR(100) NOT NULL,
    ma_buu_cuc VARCHAR(10),
    user_xuat VARCHAR(50),
    FOREIGN KEY (user_xuat) REFERENCES users(ten_nguoi_dung) ON DELETE CASCADE,
    FOREIGN KEY (ma_buu_cuc) REFERENCES buu_cuc(ma_buu_cuc) ON DELETE CASCADE
);

CREATE TABLE chi_tiet_xuat (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ma_xuat INT,
    ten_thiet_bi VARCHAR(100) NOT NULL,
    hinh_anh TEXT,
    xuat_xu VARCHAR(100),
    ma_danh_muc INT,
    ma_sn VARCHAR(20),
    FOREIGN KEY (ma_danh_muc) REFERENCES danh_muc_thiet_bi(ma_danh_muc) ON DELETE CASCADE,
    FOREIGN KEY (ma_xuat) REFERENCES xuat(ma_xuat) ON DELETE CASCADE
);
CREATE TABLE cap_thiet_bi (
    ma_cap_thiet_bi INT AUTO_INCREMENT PRIMARY KEY,
    thoi_gian_cap TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    noi_cap VARCHAR(100) NOT NULL,
    ma_buu_cuc VARCHAR(10),
    user_cap VARCHAR(50),
    FOREIGN KEY (user_cap) REFERENCES users(ten_nguoi_dung) ON DELETE CASCADE,
    FOREIGN KEY (ma_buu_cuc) REFERENCES buu_cuc(ma_buu_cuc) ON DELETE CASCADE
);

CREATE TABLE chi_tiet_cap_thiet_bi (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ma_cap_thiet_bi INT,
    ten_thiet_bi VARCHAR(100) NOT NULL,
    hinh_anh TEXT,
    xuat_xu VARCHAR(100),
    ma_danh_muc INT,
    ma_sn VARCHAR(20),
    FOREIGN KEY (ma_danh_muc) REFERENCES danh_muc_thiet_bi(ma_danh_muc) ON DELETE CASCADE,
    FOREIGN KEY (ma_cap_thiet_bi) REFERENCES cap_thiet_bi(ma_cap_thiet_bi) ON DELETE CASCADE
);

INSERT INTO quan_huyen (ma_quan_huyen, ten_quan_huyen) VALUES
('9010', 'Ninh Kiều'),
('9028', 'Bình Thủy'),
('9037', 'Cái Răng'),
('9040', 'Ô Môn'),
('9042', 'Thốt Nốt'),
('9044', 'Phong Điền'),
('9046', 'Cờ Đỏ'),
('9056', 'Thới Lai'),
('9050', 'Vĩnh Thạnh');

INSERT INTO buu_cuc (ma_buu_cuc, ten_buu_cuc, ma_quan_huyen) VALUES
('902430', 'An Bình', '9010'),
('901150', 'An Hòa', '9010'),
('902510', 'An Khánh', '9010'),
('900000', 'Cần Thơ', '9010'),
('901745', 'Hành Chính Công', '9010'),
('902220', 'Hưng Lợi', '9010'),
('901737', 'Tổ Phát Thư CPN', '9010'),
('902506', 'KDC 91B', '9010'),
('902070', 'Mậu Thân', '9010'),
('901000', 'Cái Khế', '9010'),
('902240', 'Ủy Thác', '9010'),
('901750', 'BCP Cần Thơ', '9010'),
('901740', 'KHL', '9010'),
('905420', 'TMĐT', '9010'),
('902870', 'An Thới', '9028'),
('902800', 'Bình Thủy', '9028'),
('903100', 'VHX Long Hòa', '9028'),
('903240', 'Long Tuyền', '9028'),
('903380', 'Thới An Đông', '9028'),
('906040', 'Trà An (BCP Bình Thủy)', '9028'),
('902980', 'BCP Trà Nóc', '9028'),
('903040', 'Trà Nóc', '9028'),
('903670', 'Cái Răng', '9037'),
('905340', 'Phú Thứ (BCP Phú Thứ)', '9037'),
('903720', 'Thường Thạnh', '9037'),
('905390', 'BCP Cái Răng', '9037'),
('903740', 'VHX Phú Thứ', '9037'),
('903885', 'Ba Láng', '9037'),
('905510', 'Long Hưng', '9040'),
('904120', 'Trường Lạc', '9040'),
('904060', 'Phước Thới', '9040'),
('904130', 'Thới Long', '9040'),
('904110', 'BCP Ô Môn', '9040'),
('904000', 'Ô Môn', '9040'),
('904200', 'Thốt Nốt', '9042'),
('904390', 'BCP Thốt Nốt', '9042'),
('904340', 'KT Thốt Nốt', '9042'),
('904250', 'Thới Thuận', '9042'),
('904230', 'Tân Lộc', '9042'),
('904311', 'Thuận Hưng', '9042'),
('904287', 'Trung Kiên', '9042'),
('904270', 'Trung Nhứt', '9042'),
('904245', 'Tân Lộc 1', '9042'),
('904310', 'Thuận Hưng 1', '9042'),
('904362', 'Thơm Rơm', '9042'),
('904490', 'Nhơn Nghĩa', '9044'),
('904510', 'Trường Long', '9044'),
('904430', 'Tân Thới', '9044'),
('904420', 'Giai Xuân', '9044'),
('904401', 'Mỹ Khánh', '9044'),
('904400', 'Phong Điền', '9044'),
('904560', 'BCP Phong Điền', '9044'),
('904477', 'Nhơn Ái', '9044'),
('904830', 'Sông Hậu', '9046'),
('905110', 'Thạnh Phú', '9046'),
('904841', 'Thới Hưng', '9046'),
('904705', 'Thới Đông', '9046'),
('905170', 'Trung Hưng', '9046'),
('904338', 'Trung Thạnh', '9046'),
('905111', 'Nông Trường Cờ Đỏ', '9046'),
('905119', 'KV NT Cờ Đỏ', '9046'),
('904850', 'Đông Hiệp', '9046'),
('904727', 'VHX Đông Thắng', '9046'),
('904910', 'BCP Cờ Đỏ', '9046'),
('904660', 'Cờ Đỏ', '9046'),
('904300', 'Trung An', '9046'),
('904730', 'Trường Xuân', '9056'),
('904787', 'Xuân Thắng', '9056'),
('904770', 'Đông Thuận', '9056'),
('904640', 'Định Môn', '9056'),
('904790', 'VHX Thới Lai (Thới Tân)', '9056'),
('904620', 'Thới Thạnh', '9056'),
('904810', 'Đông Bình', '9056'),
('904710', 'Trường Thành', '9056'),
('904600', 'Thới Lai', '9056'),
('905796', 'Trường Xuân B', '9056'),
('905610', 'BCP Thới Lai', '9056'),
('904762', 'Trường Xuân A', '9056'),
('905080', 'BCP Vĩnh Thạnh', '9050'),
('905010', 'Thạnh An', '9050'),
('905040', 'Thạnh Lộc', '9050'),
('905151', 'Thạnh Quới 1', '9050'),
('905020', 'Thạnh Thắng', '9050'),
('905001', 'TT Thạnh An', '9050'),
('905060', 'VHX Thạnh An', '9050'),
('905130', 'VHX Thạnh Mỹ', '9050'),
('905090', 'Vĩnh Trinh', '9050'),
('905102', 'Vĩnh Trinh 1', '9050'),
('905000', 'Vĩnh Thạnh', '9050'),
('905138', 'Thạnh Mỹ 1', '9050'),
('905123', 'Vĩnh Bình', '9050'),
('905197', 'Thạnh Tiến', '9050'),
('905116', 'VHX Thạnh Lợi', '9050');

INSERT INTO danh_muc_thiet_bi (ma_danh_muc, ten_danh_muc) VALUES
(1, 'Màn hình'),
(2, 'Máy in'),
(3, 'Máy in nhiệt'),
(4, 'CPU');
INSERT INTO users (ten_nguoi_dung, mat_khau) VALUES
('admin', '123'), -- Password: admin (MD5 hashed)
('user1', '123'), -- Password: user1 (MD5 hashed)
('user2', '123'); -- Password: user2 (MD5 hashed)
