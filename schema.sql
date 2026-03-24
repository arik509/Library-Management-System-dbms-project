DROP DATABASE IF EXISTS library_admin_dib;
CREATE DATABASE library_admin_dib;
USE library_admin_dib;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('Admin','Student','Teacher') NOT NULL,
    status ENUM('Active','Inactive') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(150) NOT NULL,
    isbn VARCHAR(30) UNIQUE,
    category_id INT NULL,
    total_copies INT NOT NULL DEFAULT 1,
    available_copies INT NOT NULL DEFAULT 1,
    status ENUM('Active','Inactive') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT chk_total_copies CHECK (total_copies > 0),
    CONSTRAINT chk_available_copies CHECK (available_copies >= 0),
    CONSTRAINT fk_books_category FOREIGN KEY (category_id) REFERENCES categories(id)
        ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE issued_books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    issue_date DATE NOT NULL,
    due_date DATE NOT NULL,
    return_date DATE NULL,
    fine_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    status ENUM('Issued','Returned','Overdue') DEFAULT 'Issued',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_issued_user FOREIGN KEY (user_id) REFERENCES users(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_issued_book FOREIGN KEY (book_id) REFERENCES books(id)
        ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE book_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_title VARCHAR(255) NOT NULL,
    request_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Pending','Approved','Rejected') DEFAULT 'Pending',
    CONSTRAINT fk_request_user FOREIGN KEY (user_id) REFERENCES users(id)
        ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE request_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    book_title VARCHAR(255),
    action_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_request_logs_user FOREIGN KEY (user_id) REFERENCES users(id)
        ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE login_audit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    email VARCHAR(100),
    user_type VARCHAR(50),
    login_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Success','Failed') NOT NULL,
    CONSTRAINT fk_login_audit_user FOREIGN KEY (user_id) REFERENCES users(id)
        ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE login_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    email VARCHAR(100),
    user_type VARCHAR(50),
    login_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Success','Failed') NOT NULL
);

CREATE TABLE logout_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    user_type ENUM('Admin','Student','Teacher'),
    logout_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_logout_user FOREIGN KEY (user_id) REFERENCES users(id)
        ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_type VARCHAR(50),
    user_id INT NULL,
    details VARCHAR(255),
    action_time DATETIME DEFAULT CURRENT_TIMESTAMP
);

DELIMITER $$
CREATE TRIGGER trg_after_book_request
AFTER INSERT ON book_requests
FOR EACH ROW
BEGIN
    INSERT INTO request_logs (user_id, book_title)
    VALUES (NEW.user_id, NEW.book_title);
END$$

CREATE TRIGGER trg_after_login_audit
AFTER INSERT ON login_audit
FOR EACH ROW
BEGIN
    INSERT INTO login_logs (user_id, email, user_type, login_time, status)
    VALUES (NEW.user_id, NEW.email, NEW.user_type, NEW.login_time, NEW.status);
END$$

CREATE TRIGGER trg_after_logout_insert
AFTER INSERT ON logout_logs
FOR EACH ROW
BEGIN
    INSERT INTO audit_logs (event_type, user_id, details)
    VALUES ('logout', NEW.user_id, CONCAT('User type: ', NEW.user_type));
END$$

CREATE TRIGGER trg_before_issue_book
BEFORE INSERT ON issued_books
FOR EACH ROW
BEGIN
    DECLARE v_available INT;
    SELECT available_copies INTO v_available FROM books WHERE id = NEW.book_id FOR UPDATE;
    IF v_available IS NULL OR v_available <= 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No available copies for this book';
    ELSE
        UPDATE books SET available_copies = available_copies - 1 WHERE id = NEW.book_id;
    END IF;
END$$

CREATE TRIGGER trg_after_return_book
AFTER UPDATE ON issued_books
FOR EACH ROW
BEGIN
    IF NEW.status = 'Returned' AND OLD.status <> 'Returned' THEN
        UPDATE books SET available_copies = available_copies + 1 WHERE id = NEW.book_id;
    END IF;
END$$
DELIMITER ;

INSERT INTO categories (name) VALUES
('Fiction'),('Science'),('History'),('Technology'),('Business');

INSERT INTO users (name, email, password, user_type, status) VALUES
('Admin User', 'admin@test.com', 'admin123', 'Admin', 'Active'),
('Student One', 'student1@test.com', 'student123', 'Student', 'Active'),
('Student Two', 'student2@test.com', 'student123', 'Student', 'Active'),
('Teacher One', 'teacher1@test.com', 'student123', 'Teacher', 'Active');

INSERT INTO books (title, author, isbn, category_id, total_copies, available_copies, status) VALUES
('Database System Concepts', 'Silberschatz', '9780073523323', 2, 5, 5, 'Active'),
('Clean Code', 'Robert C. Martin', '9780132350884', 4, 3, 3, 'Active'),
('The Great Gatsby', 'F. Scott Fitzgerald', '9780743273565', 1, 4, 4, 'Active'),
('A Brief History of Time', 'Stephen Hawking', '9780553380163', 2, 2, 2, 'Active'),
('Rich Dad Poor Dad', 'Robert Kiyosaki', '9781612680194', 5, 2, 2, 'Active');
