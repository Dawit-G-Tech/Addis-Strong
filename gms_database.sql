--core user table 
CREATE TABLE members (
    member_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20),
    gender ENUM('Male', 'Female', 'Rather Not Say'),
    dob DATE,
    address TEXT,
    registration_date DATE DEFAULT CURRENT_DATE,
    membership_id INT,
    portal_password VARCHAR(255),
    profile_picture VARCHAR(255),
    weight DECIMAL(5,2),
    height DECIMAL(5,2),
    status ENUM('Active', 'Inactive', 'Banned') DEFAULT 'Active',
    FOREIGN KEY (membership_id) REFERENCES memberships(membership_id)
);


--staff – Gym staff (trainers, front desk, admin, etc.)
CREATE TABLE staff (
    staff_id INT AUTO_INCREMENT PRIMARY KEY,
    staff_name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20),
    gender ENUM('Male', 'Female'),
    address VARCHAR(255),
    role ENUM('Admin','Cleaner', 'Receptionist', 'Manager'),
    hire_date DATE,
    salary DECIMAL(10,2),
    password VARCHAR(255)
);

--memberships – Membership types, status,renewals and pricing
CREATE TABLE memberships (
    membership_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    duration_months INT,
    price DECIMAL(10,2),
    access_level ENUM('Basic', 'Standard', 'Premium'),
    status ENUM('active', 'expired', 'renewal') 
);

CREATE TABLE Trainer (
  tr_Id VARCHAR(10) PRIMARY KEY,
  tr_name VARCHAR(50) UNIQUE NOT NULL,
  address VARCHAR(70) NOT NULL,
  tr_mobile CHAR(11) UNIQUE,
  email VARCHAR(40) UNIQUE,
  availability VARCHAR(3) DEFAULT 'Yes', 
  gender ENUM('Male', 'Female'),
  CHECK (email LIKE '%@%'),
  CHECK (tr_mobile REGEXP '^[0-9]{11}$')
);
--payments – Payment tracking
CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT,
    amount DECIMAL(10,2),
    payment_method ENUM('Cash', 'Card', 'Mobile', 'Bank Transfer'),
    payment_date DATE DEFAULT CURRENT_DATE,
    subscription_period VARCHAR(50),
    duepayment DECIMAL(10,2) DEFAULT 0.00,
    is_for VARCHAR(100),
    FOREIGN KEY (member_id) REFERENCES members(member_id)
);


--classes – Group classes (e.g., Yoga, Zumba,aerobics)
CREATE TABLE classes (
    class_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    description TEXT,
    trainer_id INT,
    schedule_time DATETIME,
    duration_minutes INT,
    capacity INT,
    FOREIGN KEY (trainer_id) REFERENCES staff(staff_id)
);


--class_bookings – Member bookings for classes
CREATE TABLE class_bookings (
    member_id INT,
    class_id INT,
    status ENUM('Booked', 'Cancelled', 'Waitlisted'),
    booking_date DATE DEFAULT CURRENT_DATE,
    PRIMARY KEY(member_id,class_id),
    FOREIGN KEY (member_id) REFERENCES members(member_id),
    FOREIGN KEY (class_id) REFERENCES classes(class_id)
);


--training_sessions – Personal training bookings
CREATE TABLE training_sessions (
    member_id INT,
    trainer_id INT,
    session_time DATETIME,
    status ENUM('Scheduled', 'Completed', 'Cancelled'),
    notes TEXT,
    PRIMARY KEY(member_id,trainer_id),
    FOREIGN KEY (member_id) REFERENCES members(member_id),
    FOREIGN KEY (trainer_id) REFERENCES staff(staff_id)
);

CREATE TABLE Equipment (
  eq_ID VARCHAR(10) PRIMARY KEY,
  eq_name VARCHAR(30) NOT NULL,
  quantity INT,
  eq_catagory VARCHAR(30),
  eq_status VARCHAR(30) DEFAULT 'usable',
  date_of_buy DATE,
);

--attendance – Check-in/check-out records
CREATE TABLE attendance (
    attendance_id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT,
    check_in DATETIME DEFAULT CURRENT_TIMESTAMP,
    check_out DATETIME,
    method ENUM('Card', 'QR'),
    FOREIGN KEY (member_id) REFERENCES members(member_id)
);

--staff_schedule – Staff shift scheduling
CREATE TABLE staff_schedule (
    schedule_id INT AUTO_INCREMENT PRIMARY KEY,
    staff_id INT,
    work_date DATE,
    start_time TIME,
    end_time TIME,
    FOREIGN KEY (staff_id) REFERENCES staff(staff_id)
);


--performance_reports – Analytics & KPIs
CREATE TABLE performance_reports (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    report_date DATE,
    total_members INT,
    new_signups INT,
    total_revenue DECIMAL(10,2),
    class_attendance INT,
    notes TEXT
);

--notifications – Email/SMS/portal alerts
CREATE TABLE notifications (
    notification_id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT,
    title VARCHAR(100),
    message TEXT,
    method ENUM('Email', 'SMS', 'Portal'),
    sent_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES members(member_id)
);

--access_control – Area permissions
CREATE TABLE access_control (
    access_id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT,
    area_name VARCHAR(100),
    access_granted BOOLEAN DEFAULT TRUE,
    reason TEXT,
    FOREIGN KEY (member_id) REFERENCES members(member_id)
);
