CREATE DATABASE IF NOT EXISTS student_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE student_management;

DROP TABLE IF EXISTS attendance;
DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS courses;
DROP TABLE IF EXISTS admins;

CREATE TABLE admins (
 id INT AUTO_INCREMENT PRIMARY KEY,
 username VARCHAR(50) NOT NULL UNIQUE,
 password_hash VARCHAR(255) NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE courses (
 id INT AUTO_INCREMENT PRIMARY KEY,
 course_name VARCHAR(120) NOT NULL,
 course_code VARCHAR(30) UNIQUE,
 description TEXT,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE students (
 id INT AUTO_INCREMENT PRIMARY KEY,
 roll_no VARCHAR(40) NOT NULL UNIQUE,
 name VARCHAR(120) NOT NULL,
 email VARCHAR(150) UNIQUE,
 phone VARCHAR(25),
 gender VARCHAR(20),
 dob DATE NULL,
 address TEXT,
 course_id INT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_student_course FOREIGN KEY(course_id) REFERENCES courses(id) ON DELETE SET NULL
);

CREATE TABLE attendance (
 id INT AUTO_INCREMENT PRIMARY KEY,
 student_id INT NOT NULL,
 attendance_date DATE NOT NULL,
 status ENUM('Present','Absent','Late') NOT NULL DEFAULT 'Present',
 remarks VARCHAR(255),
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 UNIQUE KEY unique_student_day(student_id, attendance_date),
 CONSTRAINT fk_attendance_student FOREIGN KEY(student_id) REFERENCES students(id) ON DELETE CASCADE
);

-- Demo login: admin / password
INSERT INTO admins(username,password_hash) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.');

INSERT INTO courses(course_name,course_code,description) VALUES
('Bachelor of Computer Applications','BCA','Undergraduate computer applications programme'),
('Bachelor of Business Administration','BBA','Undergraduate business administration programme');

INSERT INTO students(roll_no,name,email,phone,gender,course_id) VALUES
('BCA001','Aarav Sharma','aarav@example.com','9876543210','Male',1),
('BCA002','Diya Verma','diya@example.com','9876543211','Female',1);
