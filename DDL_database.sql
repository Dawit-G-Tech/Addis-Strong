/*

---------------------------------------------- Part01 -------------------------------------------
						Check Database Existence & Create Database with Attributes
-----------------------------------------------------------------------------------------------------
*/

CREATE DATABASE IF NOT EXISTS GMS CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE GMS;
/*
------------------------------ Part02 ------------------------------
		          Create Tables with Column Definition 
-------------------------------------------------------------------------
---------- Table with IDENTITY, PRIMARY KEY & nullability CONSTRAINT ----------
*/

--USE SCHEMA
CREATE TABLE city
(
	cityid INT AUTO_INCREMENT PRIMARY KEY,
	cityname CHAR(15) NOT NULL,
);

CREATE TABLE country
(
	countryId INT AUTO_INCREMENT PRIMARY KEY,
	countryName VARCHAR(15) NOT NULL
);

CREATE TABLE Gender 
(
	gen_Id INT AUTO_INCREMENT PRIMARY KEY,
	gen_name VARCHAR(15) UNIQUE NOT NULL
);

CREATE TABLE gym (
  gym_id CHAR(36) PRIMARY KEY,
  gym_name VARCHAR(100) NOT NULL,
  address VARCHAR(70) NOT NULL,
  countryId INT,
  cityId INT,
  gym_type VARCHAR(10) DEFAULT 'Man',
  gym_website VARCHAR(30),
  FOREIGN KEY (countryId) REFERENCES country(countryId),
  FOREIGN KEY (cityId) REFERENCES city(cityid)
);

CREATE TABLE supply (
  eqSupplier_ID VARCHAR(10) PRIMARY KEY,
  eqSupplier_name VARCHAR(30),
  eqSupplier_phone CHAR(11),
  eqMechanic_phone CHAR(11),
  comment VARCHAR(20)
);

---------------- Table With Primary Key & Foreign Key, Unique Identifier & Default Constraint --------------
CREATE TABLE Users --gym owner's information
(
	Us_ID VARCHAR(10) PRIMARY KEY, 
	admin_name VARCHAR(30) NOT NULL, --owneer/manager
	email VARCHAR(20) UNIQUE NOT NULL,
	us_name VARCHAR(20),  --for log-in
	password VARCHAR(64), --for log-in
    gym_id CHAR(36),
	FOREIGN KEY (gym_id) REFERENCES gym (gym_id)
);

CREATE TABLE Employee --Trainers & others Employee information
(
	Emp_Id VARCHAR(10) PRIMARY KEY,
	Emp_name VARCHAR(50) NOT NULL,
	Emp_role VARCHAR(20) NOT NULL,
	address VARCHAR(70) NOT NULL,
	Emp_mobile CHAR(11) NOT NULL,
	shift VARCHAR(10),
    gen_name VARCHAR(15),
	FOREIGN KEY (gen_name) REFERENCES Gender(gen_name)
);

CREATE TABLE Equipment (
  eq_ID VARCHAR(10) PRIMARY KEY,
  eq_name VARCHAR(30) NOT NULL,
  quantity INT,
  eq_catagory VARCHAR(30),
  eq_status VARCHAR(30) DEFAULT 'usable',
  date_of_buy DATE,
  eqSupplier_ID VARCHAR(10),
  comment VARCHAR(20),
  FOREIGN KEY (eqSupplier_ID) REFERENCES supply (eqSupplier_ID)
);

CREATE TABLE gym_products
(
	product_Id INT PRIMARY KEY,
	product_name VARCHAR(20) NOT NULL
);

--------------Table with CHECK CONSTRAINT & set CONSTRAINT Name--------------
CREATE TABLE Trainer (
  tr_Id VARCHAR(10) PRIMARY KEY,
  tr_name VARCHAR(50) UNIQUE NOT NULL,
  address VARCHAR(70) NOT NULL,
  countryId INT,
  cityId INT,
  tr_mobile CHAR(11) UNIQUE,
  email VARCHAR(40) UNIQUE,
  NID_number CHAR(13) UNIQUE,
  shift VARCHAR(10),
  availability VARCHAR(3) DEFAULT 'Yes', 
  gender_name VARCHAR(15),
  gym_id CHAR(36),
  FOREIGN KEY (countryId) REFERENCES country(countryId),
  FOREIGN KEY (cityId) REFERENCES city(cityId),
  FOREIGN KEY (gender_name) REFERENCES Gender(gen_name),
  FOREIGN KEY (gym_id) REFERENCES Gym (gym_id),
  CHECK (email LIKE '%@%'),
  CHECK (tr_mobile REGEXP '^[0-9]{11}$'),
  CHECK (NID_number REGEXP '^[0-9]{13}$')
);

CREATE TABLE Package (
  pack_ID VARCHAR(10) PRIMARY KEY,
  pack_name VARCHAR(20) UNIQUE NOT NULL,
  duration VARCHAR(20),
  pack_fee DECIMAL(10,2),
  discount FLOAT DEFAULT 0.10,
  pack_Goal VARCHAR(20),
  tr_id VARCHAR(10) REFERENCES Trainer (tr_id)
);

CREATE TABLE Member (
  mem_ID VARCHAR(10) PRIMARY KEY,
  mem_name VARCHAR(50) NOT NULL,
  address VARCHAR(70) NOT NULL,
  cityId INT,
  countryId INT,
  gender_name VARCHAR(15),
  mem_mobile CHAR(11) UNIQUE,
  email VARCHAR(40) UNIQUE,
  NID_number CHAR(13),
  photo LONGBLOB NULL,
  reference VARCHAR(70) DEFAULT 'N/A',
  age INT,
  weight DECIMAL(5,2),
  height DECIMAL(5,2),
  body_mass_index DECIMAL(5,2),
  tr_id VARCHAR(10),
  pack_name VARCHAR(20),
  FOREIGN KEY (cityId) REFERENCES city(cityId),
  FOREIGN KEY (countryId) REFERENCES country(countryId),
  FOREIGN KEY (gender_name) REFERENCES Gender(gen_name),
  FOREIGN KEY (tr_id) REFERENCES Trainer(tr_id),
  FOREIGN KEY (pack_name) REFERENCES Package(pack_name)
);

CREATE TABLE payment (
  pay_Id VARCHAR(10) PRIMARY KEY,
  package_name VARCHAR(20) NOT NULL,
  pack_fee DECIMAL(10,2),
  PayAmount DECIMAL(10,2) DEFAULT NULL,
  PackageSalesDate DATE,
  mem_id VARCHAR(10),
  pack_ID VARCHAR(10),
  DuePayment DECIMAL(10,2) DEFAULT 0.00,
  FOREIGN KEY (mem_id) REFERENCES Member(mem_ID),
  FOREIGN KEY (pack_ID) REFERENCES Package(pack_ID)
);

CREATE TABLE Employee_salary (
  ES_ID VARCHAR(20) PRIMARY KEY,
  salary DECIMAL(10,2),
  salary_date DATE,
  tr_ID VARCHAR(10),
  Emp_ID VARCHAR(10),
  FOREIGN KEY (tr_ID) REFERENCES Trainer(tr_ID),
  FOREIGN KEY (Emp_ID) REFERENCES Employee(Emp_ID)
);


CREATE TABLE Attendence --attendence of everyone will be count with PunchCard press
(
    punch_Date DATE,
    punch_IN_time TIME,
    punch_out_time TIME,
    mem_ID VARCHAR(10),
    tr_ID VARCHAR(10),
    Emp_ID VARCHAR(10),
    FOREIGN KEY (mem_ID) REFERENCES Member(mem_ID),
    FOREIGN KEY (tr_ID) REFERENCES Trainer(tr_ID),
    FOREIGN KEY (Emp_ID) REFERENCES Employee(Emp_ID)
);

--might not need this
CREATE SCHEMA gym;
CREATE TABLE gym.membership_info (
  mem_ID VARCHAR(10),
  pack_ID VARCHAR(10),
  pack_name VARCHAR(20),
  pay_id VARCHAR(10),
  pack_StartDate DATE,
  pack_EndDate DATE,
  tr_name VARCHAR(50),
  PRIMARY KEY (pack_name, tr_name),
  FOREIGN KEY (mem_ID) REFERENCES Member(mem_ID),
  FOREIGN KEY (pack_ID) REFERENCES Package(pack_ID),
  FOREIGN KEY (pack_name) REFERENCES Package(pack_name),
  FOREIGN KEY (pay_id) REFERENCES Payment(pay_id),
  FOREIGN KEY (tr_name) REFERENCES Trainer(tr_name)
);

/*
------------------------------ Part03 ------------------------------
		          Alter, Drop And Modify Tables & Columns
--------------------------------------------------------------------------
*/
---------------- Alter Table Schema--------------

/*
------------------------------  Part04  ------------------------------
		          Create Index
--------------------------------------------------------------------------
*/
-- Create an index on 'punch_Date' column in 'Attendence' table
CREATE INDEX IX_punch_Date
ON Attendence (punch_Date);

-- Create a UNIQUE index on 'nid_number' and 'tr_mobile' columns in 'trainer' table
CREATE UNIQUE INDEX IX_trainer
ON trainer (nid_number, tr_mobile);

/*
------------------------------  Part05  ------------------------------
							 Create Sequence
--------------------------------------------------------------------------

------------------------------  Part06  ------------------------------
							  Create A View
--------------------------------------------------------------------------
*/
-- View 1: Membership info (basic)
CREATE OR REPLACE VIEW V_membership_info AS
SELECT mem_id, pack_name, tr_name
FROM membership_info;

-- View 2: Today's gym package sales
CREATE OR REPLACE VIEW V_TodayPackageSales AS
SELECT mem_id, pack_name, pay_id, pack_StartDate
FROM membership_info
WHERE DATE(pack_StartDate) = CURDATE()
WITH CHECK OPTION;

/*
------------------------------  Part07  ------------------------------
							 Stored Procedure
--------------------------------------------------------------------------
*/
---------------- Stored Procedure For Insert Data Using Parameter --------------
CREATE PROCEDURE spInsertMember		@mem_id VARCHAR(10),
									@mem_name NVARCHAR(50),
									@address NVARCHAR(70),
									@gender_name VARCHAR(10),
									@cityId INT,
									@countryId INT,
									@mem_mobile CHAR (11),
									@NID_number CHAR(13),
									@email VARCHAR(40),
									@photo VARBINARY(MAX),
									@age int,
									@weight VARCHAR(10),
									@height VARCHAR(10),
									@body_mass_index float,
									@reference VARCHAR(70)
AS
BEGIN
	INSERT INTO Member(mem_id, mem_name,[address], gender_name, cityId, countryId, mem_mobile,NID_number, email, photo, age, [weight], height, body_mass_index, reference) 
	VALUES(@mem_id, @mem_name, @address, @gender_name, @cityId, @countryId, @mem_mobile, @NID_number, @email, @photo, @age, @weight, @height, @body_mass_index, @reference)
END
GO
---------------- Stored Procedure For Insert Data With Output Parameter --------------
CREATE PROCEDURE spInsertInstructor	@tr_id VARCHAR(10),
									@tr_name NVARCHAR(50) ,
									@address NVARCHAR(70),
									@countryId INT,
									@cityId INT ,
									@tr_mobile CHAR (11),
									@email VARCHAR(40),
									@NID_number CHAR(13),
									@shift VARCHAR(10),
									@availability VARCHAR(3),
									@gym_name NVARCHAR (100),
									@Id INT 
									OUTPUT
AS
BEGIN
	INSERT INTO Trainer (tr_id,tr_name, [address], countryId, cityId, tr_mobile, email, NID_number, [shift], [availability]) 
	VALUES(@tr_id, @tr_name, @address, @countryId, @cityId, @tr_mobile, @email, @NID_number, @shift, @availability)
	SELECT @Id = IDENT_CURRENT('instructor')
END
GO
---------------- Stored Procedure For Update Data --------------
CREATE PROCEDURE spUpdateMemberPayment	@mem_Id INT,
										@PayAmount MONEY
AS
BEGIN
	UPDATE payment
	SET
	PayAmount = @PayAmount
	WHERE mem_Id = @mem_Id
END
GO
---------------- Stored Procedure For Delete Table Data --------------
CREATE PROCEDURE spDeletePackage @pack_Id INT
AS
BEGIN
	DELETE FROM package
	WHERE pack_Id = @pack_Id
END
GO
---------------- Try Catch In A Stored Procedure & Raiserror With Error Number And Error Message --------------
CREATE PROCEDURE spRaisError
AS
BEGIN
	BEGIN TRY
		DELETE FROM equipment
	END TRY
	BEGIN CATCH
		DECLARE @Error VARCHAR(200) = 'Error' + CONVERT(varchar, ERROR_NUMBER(), 1) + ' : ' + ERROR_MESSAGE()
		RAISERROR(@Error, 1, 1)
	END CATCH
END
GO
---------------- Alter Stored Procedure --------------
ALTER PROCEDURE spUpdateMemberPayment	
									@mem_Id VARCHAR(10),
									@PayAmount MONEY,
									@pack_name VARCHAR(20)
AS
BEGIN
	UPDATE member
	SET
	pack_name = @pack_name
	WHERE mem_Id = @mem_Id
END
GO
/*
------------------------------  Part08  ------------------------------
								 Function
--------------------------------------------------------------------------
*/

---------------- A Scalar Function --------------
CREATE FUNCTION fn_thisYearSales()
RETURNS MONEY
AS
BEGIN
	DECLARE @totalPackageSales MONEY

	SELECT @totalPackageSales = SUM((PayAmount))
	FROM payment
	WHERE YEAR(payment.PackageSalesDate) = YEAR(GETDATE())
	RETURN @totalPackageSales
END
GO
---------------- A Simple Table Valued Function --------------
CREATE FUNCTION fn_MonthlyPackageSales
									(@year INT, 
									 @month INT)
RETURNS TABLE
AS
RETURN
(
	SELECT 
			SUM(pack_fee) AS 'Net Sales',
			SUM(PayAmount) AS 'Total Sales'
	FROM payment
WHERE 
	YEAR(payment.PackageSalesDate) = @year AND 
	MONTH(payment.PackageSalesDate) = @month
)
GO

---------------- A Multistatement Table Valued Function --------------
CREATE FUNCTION fn_MonthlyPackageSale
										(@year INT, 
										 @month INT)
RETURNS @sales TABLE
(
	pay_Id INT,
	package_name VARCHAR(20),
	PackageSalesDate DATE,
	PayAmount MONEY
)
AS
BEGIN	
	INSERT INTO @sales
	SELECT
	payment.pay_Id INT,
	payment.package_name,
	payment.PackageSalesDate,
	payment.PayAmount
	FROM payment
	INNER JOIN member ON member.mem_Id = payment.mem_Id 
	INNER JOIN package ON package.pack_Id = payment.pack_Id
WHERE 
	YEAR(payment.PackageSalesDate) = @year AND 
	MONTH(payment.PackageSalesDate) = @month
	RETURN
END
GO

---------------- Alter Function --------------
ALTER FUNCTION fn_MonthlyPackageSales
									(@year INT, 
									 @month INT)
RETURNS TABLE
AS
RETURN
(
	SELECT 
			SUM(pack_fee) AS 'Total Sales',
			SUM(PayAmount) AS 'Net Sales'
	FROM payment
WHERE 
	YEAR(payment.PackageSalesDate) = @year AND 
	MONTH(payment.PackageSalesDate) = @month
)
GO
/*
------------------------------  Part09  ------------------------------
							For/After Trigger
--------------------------------------------------------------------------
*/
-- Creating trigger for payment table and update in membership_info table
CREATE TRIGGER trPaymentClear
ON Payment
FOR INSERT
AS
BEGIN
	DECLARE @pid INT
	DECLARE @soldToMember MONEY

	SELECT
	@pid = pay_ID,
	@soldToMember = inserted.pack_fee
	FROM inserted

	UPDATE membership_info
	SET pack_fee = pack_fee + @soldToMember
	WHERE pay_ID = @pid
	PRINT 'package sold to new member'
END
GO
---------------- An After/For Trigger For Insert, Update, Delete --------------
--Creating trigger for payment table and update in membership_info table
CREATE TRIGGER trPaymentClears
ON payment
FOR INSERT, UPDATE, DELETE
AS
	BEGIN
		DECLARE @pid INT
		DECLARE @soldToMember MONEY
				-- Check if this trigger is executed only for updated
		IF (EXISTS(SELECT * FROM INSERTED) AND EXISTS(SELECT * FROM DELETED))
					BEGIN
						UPDATE membership_info
						SET pack_fee = pack_fee + @soldToMember
						WHERE Package.pack_ID = membership_info.pack_ID
						PRINT 'membership updated '
					END
--Check if this trigger is for only for inserted
		ELSE IF (EXISTS(SELECT * FROM INSERTED) AND NOT EXISTS(SELECT * FROM DELETED))
					BEGIN
						SELECT
						@pid = pay_ID,
						@soldToMember = inserted.PayAmount
						FROM inserted

						UPDATE membership_info
						SET pack_fee = pack_fee + @soldToMember
						WHERE Package.pack_ID = membership_info.pack_ID
						PRINT 'membership updated '
					END
-- Check if this trigger is executed only for deleted
				ELSE IF (EXISTS(SELECT * FROM DELETED) AND NOT EXISTS(SELECT * FROM INSERTED))
					BEGIN
						SELECT
						@pid = pay_ID,
						@soldToMember = inserted.PayAmount
						FROM inserted

						UPDATE membership_info
						SET pack_fee = pack_fee - @soldToMember
						WHERE Package.pack_ID = membership_info.pack_ID
						PRINT 'membership updated '
					END
-- If not match any condition then rollback the transaction
				ELSE ROLLBACK TRANSACTION
		END
GO
-- 
/*
------------------------------  Part10  ------------------------------
							Instead Of Trigger
--------------------------------------------------------------------------
*/
---------------- An Instead Of Trigger On View --------------
CREATE TRIGGER trViewInsteadInsert
ON V_membership_info
INSTEAD OF INSERT
AS
BEGIN
	INSERT INTO payment(pay_Id, PayAmount)
	SELECT i.pay_Id, i.PayAmount FROM inserted i
END
GO

---------------- Alter Trigger --------------
ALTER TRIGGER trViewInsteadInsert
ON V_membership_info
INSTEAD OF INSERT
AS
BEGIN
	INSERT INTO membership_info(mem_name, mem_ID, pay_id)
	SELECT i.mem_name, i.mem_ID , i.pay_id FROM inserted i
END
GO