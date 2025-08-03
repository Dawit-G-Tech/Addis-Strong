-- 1. Role Table: Manages all user roles (Member, Trainer, Admin, etc.)
CREATE TABLE roles (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) UNIQUE NOT NULL
);

-- 2. Users Table: All types of users (members, trainers, staff, admin, etc.)
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    gender ENUM('Male', 'Female', 'Rather Not Say'),
    dob DATE,
    address TEXT,
    registration_date DATE DEFAULT CURRENT_DATE,
    hashed_password VARCHAR(255) NOT NULL,
    profile_picture VARCHAR(255),
    role_id INT NOT NULL,
    status ENUM('Active', 'Inactive', 'Banned') DEFAULT 'Active',
    FOREIGN KEY (role_id) REFERENCES roles(role_id)
);

-- 3. Membership Plans
CREATE TABLE memberships (
    membership_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    duration_months INT,
    price DECIMAL(10,2),
    access_level ENUM('Basic', 'Standard', 'Premium'),
    status ENUM('active', 'expired', 'renewal')
);

-- 4. Members Table (extends users)
CREATE TABLE members (
    member_id INT PRIMARY KEY, -- same as user_id
    membership_id INT,
    weight DECIMAL(5,2),
    height DECIMAL(5,2),
    FOREIGN KEY (member_id) REFERENCES users(user_id),
    FOREIGN KEY (membership_id) REFERENCES memberships(membership_id)
);

-- 5. Staff Table (extends users)
CREATE TABLE staff (
    staff_id INT PRIMARY KEY, -- same as user_id
    hire_date DATE,
    salary DECIMAL(10,2),
    FOREIGN KEY (staff_id) REFERENCES users(user_id)
);

-- 6. Payments
CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT,
    amount DECIMAL(10,2),
    payment_method ENUM('Cash', 'Card', 'Mobile', 'Bank Transfer'),
    payment_date DATE DEFAULT CURRENT_DATE,
    start_date DATE,
    end_date DATE,
    FOREIGN KEY (member_id) REFERENCES members(member_id)
);

-- 7. Group Classes
CREATE TABLE classes (
    class_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    description TEXT,
    trainer_id INT,
    schedule_time DATETIME,
    duration_minutes INT,
    capacity INT,
    FOREIGN KEY (trainer_id) REFERENCES users(user_id)
);

-- 8. Class Bookings
CREATE TABLE class_bookings (
    member_id INT,
    class_id INT,
    status ENUM('Booked', 'Cancelled', 'Waitlisted'),
    booking_date DATE DEFAULT CURRENT_DATE,
    PRIMARY KEY(member_id, class_id),
    FOREIGN KEY (member_id) REFERENCES members(member_id),
    FOREIGN KEY (class_id) REFERENCES classes(class_id)
);

-- 9. Personal Training Sessions
CREATE TABLE training_sessions (
    session_id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT,
    trainer_id INT,
    session_time DATETIME,
    status ENUM('Scheduled', 'Completed', 'Cancelled'),
    notes TEXT,
    FOREIGN KEY (member_id) REFERENCES members(member_id),
    FOREIGN KEY (trainer_id) REFERENCES users(user_id)
);

-- 10. Equipment Inventory
CREATE TABLE equipment (
    eq_id VARCHAR(10) PRIMARY KEY,
    eq_name VARCHAR(30) NOT NULL,
    quantity INT,
    eq_category VARCHAR(30),
    eq_status VARCHAR(30) DEFAULT 'Usable',
    date_of_buy DATE
);

-- 11. Attendance Tracking
CREATE TABLE attendance (
    attendance_id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT,
    check_in DATETIME DEFAULT CURRENT_TIMESTAMP,
    check_out DATETIME,
    method ENUM('Card', 'QR'),
    FOREIGN KEY (member_id) REFERENCES members(member_id)
);

-- 12. Staff Schedules
CREATE TABLE staff_schedule (
    schedule_id INT AUTO_INCREMENT PRIMARY KEY,
    staff_id INT,
    work_date DATE,
    start_time TIME,
    end_time TIME,
    FOREIGN KEY (staff_id) REFERENCES staff(staff_id)
);

-- 13. Performance Reports
CREATE TABLE performance_reports (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    report_date DATE,
    total_members INT,
    new_signups INT,
    total_revenue DECIMAL(10,2),
    class_attendance INT,
    notes TEXT
);

-- 14. Notifications (Portal, SMS, Email)
CREATE TABLE notifications (
    notification_id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT,
    title VARCHAR(100),
    message TEXT,
    method ENUM('Email', 'SMS', 'Portal'),
    sent_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES members(member_id)
);

-- 15. Access Control
CREATE TABLE access_control (
    access_id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT,
    area_name VARCHAR(100),
    access_granted BOOLEAN DEFAULT TRUE,
    reason TEXT,
    FOREIGN KEY (member_id) REFERENCES members(member_id)
);


--Indexes 
-- Improve lookups and joins on users
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_role_id ON users(role_id);

-- For frequent filtering by role (Trainer, Member, etc.)
CREATE INDEX idx_roles_name ON roles(role_name);

-- Improve member-related queries
CREATE INDEX idx_members_membership_id ON members(membership_id);

-- Improve trainer search and scheduling
CREATE INDEX idx_classes_trainer_id ON classes(trainer_id);
CREATE INDEX idx_training_sessions_trainer_id ON training_sessions(trainer_id);

-- Optimize class booking lookups
CREATE INDEX idx_class_bookings_class_id ON class_bookings(class_id);

-- Optimize payment and attendance queries
CREATE INDEX idx_payments_member_id ON payments(member_id);
CREATE INDEX idx_attendance_member_id ON attendance(member_id);

-- Speed up notifications lookup
CREATE INDEX idx_notifications_member_id ON notifications(member_id);

-- Faster access control filtering
CREATE INDEX idx_access_control_area_name ON access_control(area_name);
