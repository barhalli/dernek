SET NAMES utf8mb4;
SET time_zone = '+00:00';

CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','teacher','parent','student') NOT NULL DEFAULT 'teacher',
  status ENUM('active','disabled') NOT NULL DEFAULT 'active',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS parents (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  phone VARCHAR(30),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_parents_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS classes (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(80) NOT NULL,
  grade_level VARCHAR(50) NOT NULL,
  year VARCHAR(10) NOT NULL,
  teacher_id INT UNSIGNED,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_classes_teacher FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS students (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  number VARCHAR(50),
  first_name VARCHAR(80) NOT NULL,
  last_name VARCHAR(80) NOT NULL,
  birthdate DATE,
  gender VARCHAR(10),
  parent_id INT UNSIGNED,
  status VARCHAR(20) DEFAULT 'active',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_students_parent FOREIGN KEY (parent_id) REFERENCES parents(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS enrollments (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  class_id INT UNSIGNED NOT NULL,
  student_id INT UNSIGNED NOT NULL,
  year VARCHAR(10) NOT NULL,
  active TINYINT(1) DEFAULT 1,
  CONSTRAINT fk_enrollments_class FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
  CONSTRAINT fk_enrollments_student FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
  UNIQUE KEY uq_enrollment (class_id, student_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS subjects (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  code VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS class_subjects (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  class_id INT UNSIGNED NOT NULL,
  subject_id INT UNSIGNED NOT NULL,
  teacher_id INT UNSIGNED,
  CONSTRAINT fk_class_subjects_class FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
  CONSTRAINT fk_class_subjects_subject FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
  CONSTRAINT fk_class_subjects_teacher FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS attendances (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  class_id INT UNSIGNED NOT NULL,
  student_id INT UNSIGNED NOT NULL,
  date DATE NOT NULL,
  status ENUM('Present','Late','Absent','Excused') NOT NULL DEFAULT 'Present',
  note VARCHAR(255),
  CONSTRAINT fk_attendance_class FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
  CONSTRAINT fk_attendance_student FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
  UNIQUE KEY uq_attendance (class_id, student_id, date),
  KEY idx_attendance_class_date (class_id, date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS assessments (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  class_id INT UNSIGNED NOT NULL,
  subject_id INT UNSIGNED NOT NULL,
  title VARCHAR(120) NOT NULL,
  type ENUM('Test','Homework','Project') NOT NULL DEFAULT 'Test',
  max_score INT NOT NULL,
  date DATE NOT NULL,
  CONSTRAINT fk_assessment_class FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
  CONSTRAINT fk_assessment_subject FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS grades (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  assessment_id INT UNSIGNED NOT NULL,
  student_id INT UNSIGNED NOT NULL,
  score DECIMAL(5,2) NOT NULL,
  note VARCHAR(255),
  CONSTRAINT fk_grades_assessment FOREIGN KEY (assessment_id) REFERENCES assessments(id) ON DELETE CASCADE,
  CONSTRAINT fk_grades_student FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
  UNIQUE KEY uq_grade (assessment_id, student_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS announcements (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  class_id INT UNSIGNED,
  title VARCHAR(150) NOT NULL,
  body TEXT NOT NULL,
  visible_from DATETIME,
  visible_to DATETIME,
  attachment_path VARCHAR(255),
  CONSTRAINT fk_announcements_class FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS timetable (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  class_id INT UNSIGNED NOT NULL,
  subject_id INT UNSIGNED NOT NULL,
  weekday TINYINT NOT NULL,
  start_time TIME NOT NULL,
  end_time TIME NOT NULL,
  CONSTRAINT fk_timetable_class FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
  CONSTRAINT fk_timetable_subject FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS files (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  owner_user_id INT UNSIGNED NOT NULL,
  class_id INT UNSIGNED,
  path VARCHAR(255) NOT NULL,
  filename VARCHAR(255) NOT NULL,
  size INT,
  mime VARCHAR(100),
  visibility ENUM('private','class','public') DEFAULT 'private',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_files_owner FOREIGN KEY (owner_user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_files_class FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS messages (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  from_user_id INT UNSIGNED NOT NULL,
  to_user_id INT UNSIGNED NOT NULL,
  class_id INT UNSIGNED,
  subject VARCHAR(150) NOT NULL,
  body TEXT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  read_at DATETIME,
  parent_id INT UNSIGNED,
  CONSTRAINT fk_messages_from FOREIGN KEY (from_user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_messages_to FOREIGN KEY (to_user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS settings (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `key` VARCHAR(120) NOT NULL UNIQUE,
  value TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS password_resets (
  user_id INT UNSIGNED NOT NULL,
  token VARCHAR(120) NOT NULL UNIQUE,
  expires_at DATETIME NOT NULL,
  PRIMARY KEY (user_id),
  CONSTRAINT fk_password_resets_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO users (id, name, email, password_hash, role, status, created_at, updated_at) VALUES
(1, 'Sistem Yöneticisi', 'admin@okul.local', '$2y$12$395pnXx1vSx.bm1XDyonI.KfxvAO12a9RqFaIGUmtj3wKrCtHKajS', 'admin', 'active', NOW(), NOW()),
(2, 'Merve Öğretmen', 'merve@okul.local', '$2y$12$Qi0pulHHT/G1XkLWMOXmZ.4PFDdvreGGyIW76fKayjZ8NeQVN8OFO', 'teacher', 'active', NOW(), NOW()),
(3, 'Ali Veli', 'veli@okul.local', '$2y$12$Xx84cGePx9hM29ZjCUDU1eptcQyLqzUT.Yrm2TR8ig7QoY493jwM.', 'parent', 'active', NOW(), NOW()),
(4, 'Ayşe Öğrenci', 'ayse@okul.local', '$2y$12$5sZn6cqRRPNNIY816yZuQeQIKSrOwByDNAxnjfXSpDEGwKjTfq8X2', 'student', 'active', NOW(), NOW());

INSERT INTO parents (id, user_id, phone, created_at) VALUES
(1, 3, '+90 532 000 0000', NOW());

INSERT INTO classes (id, name, grade_level, year, teacher_id, created_at, updated_at) VALUES
(1, '5-A', '5', '2024', 2, NOW(), NOW()),
(2, '6-B', '6', '2024', 2, NOW(), NOW());

INSERT INTO students (id, number, first_name, last_name, birthdate, gender, parent_id, status, created_at) VALUES
(1, '501', 'Ahmet', 'Yılmaz', '2013-09-12', 'M', 1, 'active', NOW()),
(2, '502', 'Ayşe', 'Demir', '2013-04-21', 'F', 1, 'active', NOW()),
(3, '503', 'Mehmet', 'Kaya', '2013-02-11', 'M', NULL, 'active', NOW()),
(4, '601', 'Selin', 'Arslan', '2012-05-02', 'F', NULL, 'active', NOW()),
(5, '602', 'Emre', 'Taş', '2012-11-18', 'M', NULL, 'active', NOW());

INSERT INTO enrollments (id, class_id, student_id, year, active) VALUES
(1, 1, 1, '2024', 1),
(2, 1, 2, '2024', 1),
(3, 1, 3, '2024', 1),
(4, 2, 4, '2024', 1),
(5, 2, 5, '2024', 1);

INSERT INTO subjects (id, name, code) VALUES
(1, 'Matematik', 'MAT'),
(2, 'Fen Bilimleri', 'FEN'),
(3, 'Türkçe', 'TRK');

INSERT INTO class_subjects (id, class_id, subject_id, teacher_id) VALUES
(1, 1, 1, 2),
(2, 1, 2, 2),
(3, 2, 1, 2);

INSERT INTO assessments (id, class_id, subject_id, title, type, max_score, date) VALUES
(1, 1, 1, 'Matematik Yazılı 1', 'Test', 100, '2024-04-15'),
(2, 1, 2, 'Fen Projesi', 'Project', 50, '2024-04-25');

INSERT INTO grades (id, assessment_id, student_id, score, note) VALUES
(1, 1, 1, 88.00, 'Başarılı'),
(2, 1, 2, 76.00, 'Gayet iyi'),
(3, 1, 3, 45.00, 'Destek gerekli'),
(4, 2, 1, 42.00, 'Proje tamamlandı'),
(5, 2, 2, 39.00, 'Eksikler var');

INSERT INTO attendances (id, class_id, student_id, date, status, note) VALUES
(1, 1, 1, '2024-04-01', 'Present', NULL),
(2, 1, 2, '2024-04-01', 'Late', 'Sabah trafiği'),
(3, 1, 3, '2024-04-01', 'Absent', 'Hastalık');

INSERT INTO announcements (id, class_id, title, body, visible_from, visible_to, attachment_path) VALUES
(1, 1, 'Veli Toplantısı', '5-A sınıfı veli toplantısı 10 Mayıs tarihinde yapılacaktır.', '2024-04-01 08:00:00', '2024-05-15 17:00:00', NULL),
(2, NULL, 'Okul Gezisi', 'Tüm öğrencilerimiz için Ankara Bilim Müzesi gezisi planlanmıştır.', '2024-04-05 08:00:00', NULL, NULL);

INSERT INTO timetable (id, class_id, subject_id, weekday, start_time, end_time) VALUES
(1, 1, 1, 0, '09:00:00', '09:40:00'),
(2, 1, 2, 2, '10:00:00', '10:40:00'),
(3, 2, 1, 1, '11:00:00', '11:40:00');

INSERT INTO files (id, owner_user_id, class_id, path, filename, size, mime, visibility, created_at) VALUES
(1, 2, 1, '/user_2/ornek.pdf', 'ornek.pdf', 20480, 'application/pdf', 'class', NOW());

INSERT INTO messages (id, from_user_id, to_user_id, class_id, subject, body, created_at, read_at, parent_id) VALUES
(1, 2, 3, 1, 'Ödev Hk.', 'Merhaba, öğrencimizin ödevi tamamlandı mı?', NOW(), NULL, NULL),
(2, 3, 2, 1, 'RE: Ödev Hk.', 'Merhaba öğretmenim, bu akşam tamamlayacağız.', NOW(), NULL, 1);

INSERT INTO settings (id, `key`, value) VALUES
(1, 'school_year', '2023-2024'),
(2, 'term', '2');
