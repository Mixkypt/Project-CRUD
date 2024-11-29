-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2024 at 07:56 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thanakarn_thanajai`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `account_id` int(25) NOT NULL,
  `account_type` varchar(25) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`account_id`, `account_type`, `balance`, `customer_id`) VALUES
(1, 'Savings', '0.00', NULL),
(2, 'Lottery', '0.00', NULL),
(3, 'Checking', '1000.00', 9),
(4, 'Checking', '10000.00', 9);

-- --------------------------------------------------------

--
-- Table structure for table `atm`
--

CREATE TABLE `atm` (
  `atm_id` varchar(25) NOT NULL,
  `location` varchar(50) NOT NULL,
  `brch_id` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `atm`
--

INSERT INTO `atm` (`atm_id`, `location`, `brch_id`) VALUES
('1', 'Downtown Main St', '1'),
('10', 'Airport Terminal', '3'),
('2', 'East Side Plaza', '2'),
('3', 'West End Mall', '1'),
('4', 'Central Park Entrance', '3'),
('5', 'City Hall', '1'),
('6', 'University Campus', '2'),
('7', 'Train Station', '3'),
('8', 'Suburban Shopping Center', '1'),
('9', 'Community Center', '2');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `brch_id` varchar(25) NOT NULL,
  `brch_name` varchar(25) NOT NULL,
  `brch_location` varchar(50) DEFAULT NULL,
  `brch_phone` char(10) DEFAULT NULL,
  `emp_id` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`brch_id`, `brch_name`, `brch_location`, `brch_phone`, `emp_id`) VALUES
('1', 'Main Branch', NULL, NULL, NULL),
('2', 'Secondary Branch', NULL, NULL, NULL),
('3', 'Tertiary Branch', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `creditcard`
--

CREATE TABLE `creditcard` (
  `card_id` int(11) NOT NULL,
  `card_type` varchar(25) NOT NULL,
  `expire_date` date NOT NULL,
  `limits` decimal(10,2) NOT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `creditcard`
--

INSERT INTO `creditcard` (`card_id`, `card_type`, `expire_date`, `limits`, `customer_id`) VALUES
(1, 'Gold', '2029-11-05', '100000.00', 2),
(2, 'Platinum', '2029-11-05', '1000000.00', 9),
(4, 'Gold', '2029-11-05', '100000.00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(25) NOT NULL,
  `customer_name` varchar(25) NOT NULL,
  `customer_address` varchar(50) DEFAULT NULL,
  `customer_phone` char(10) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `date_join` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_address`, `customer_phone`, `email`, `date_join`) VALUES
(1, 'Alice Smith', '123 Maple St, Cityville', '555-0123', 'alice.smith@example.com', '2023-01-09 17:00:00'),
(2, 'Bob Johnson', '456 Oak Ave, Townsville', '555-2345', 'bob.johnson@example.com', '2023-02-13 17:00:00'),
(3, 'Carol Brown', '789 Pine Rd, Village', '555-5678', 'carol.brown@example.com', '2023-03-19 17:00:00'),
(4, 'David Williams', '101 Birch Blvd, Hamlet', '555-8765', 'david.williams@example.com', '2023-04-24 17:00:00'),
(5, 'Emma Jones', '102 Elm St, Metropolis', '555-3456', 'emma.jones@example.com', '2023-05-04 17:00:00'),
(6, 'Frank Thomas', '103 Cedar Ln, Smalltown', '555-4567', 'frank.thomas@example.com', '2023-06-14 17:00:00'),
(9, 'Chatree', 'Tni soi 24', '0985875577', 'Chatree@tni.ac.th', '2024-11-05 06:36:55');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `emp_id` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(200) NOT NULL,
  `emp_name` varchar(25) NOT NULL,
  `emp_surname` varchar(25) NOT NULL,
  `emp_ic` varchar(25) NOT NULL,
  `emp_address` varchar(25) NOT NULL,
  `emp_age` int(5) DEFAULT NULL,
  `emp_position` varchar(50) DEFAULT NULL,
  `emp_salary` int(255) DEFAULT NULL,
  `branch_id` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`emp_id`, `email`, `password`, `emp_name`, `emp_surname`, `emp_ic`, `emp_address`, `emp_age`, `emp_position`, `emp_salary`, `branch_id`) VALUES
('1', 'john.doe@example.com', 'pass1234', 'John', 'Doe', '123456-78-9101', '123 Main St', 28, 'Manager', 60000, '1'),
('10', 'hank.williams@example.com', 'pass1234', 'Hank', 'Williams', '456123-78-9101', '123 Willow St', 27, 'Graphic Designer', 43000, '2'),
('11', 'ivy.perez@example.com', 'pass1234', 'Ivy', 'Perez', '789123-45-6789', '456 Chestnut St', 24, 'Project Coordinator', 47000, '1'),
('12', 'jack.hall@example.com', 'pass1234', 'Jack', 'Hall', '963852-74-3210', '789 Palm St', 35, 'Operations Manager', 60000, '3'),
('13', 'kate.lopez@example.com', 'pass1234', 'Kate', 'Lopez', '147258-36-8954', '234 Aspen St', 31, 'Recruiter', 42000, '2'),
('14', 'luke.rodriguez@example.com', 'pass1234', 'Luke', 'Rodriguez', '369258-74-5123', '567 Acacia St', 40, 'Finance Manager', 70000, '1'),
('15', 'mona.scott@example.com', 'pass1234', 'Mona', 'Scott', '741852-96-3571', '890 Cypress St', 26, 'Content Writer', 38000, '2'),
('16', 'nate.morris@example.com', 'pass1234', 'Nate', 'Morris', '951357-68-7890', '123 Yew St', 34, 'Customer Service', 39000, '3'),
('17', 'olivia.hughes@example.com', 'pass1234', 'Olivia', 'Hughes', '357951-12-6547', '456 Sequoia St', 29, 'Software Engineer', 58000, '1'),
('18', 'peter.adams@example.com', 'pass1234', 'Peter', 'Adams', '123789-45-6123', '789 Redwood St', 36, 'Network Engineer', 60000, '2'),
('19', 'quinn.ramirez@example.com', 'pass1234', 'Quinn', 'Ramirez', '852963-14-7985', '234 Poplar St', 28, 'Product Manager', 61000, '3'),
('2', 'jane.smith@example.com', 'pass1234', 'Jane', 'Smith', '987654-32-1098', '456 Oak St', 32, 'Senior Developer', 55000, '2'),
('20', 'rachel.sanders@example.com', 'pass1234', 'Rachel', 'Sanders', '369258-97-8520', '567 Juniper St', 30, 'UX Designer', 44000, '1'),
('21', 'steve.baker@example.com', 'pass1234', 'Steve', 'Baker', '741963-25-8745', '890 Hemlock St', 32, 'QA Tester', 42000, '2'),
('22', 'tina.james@example.com', 'pass1234', 'Tina', 'James', '258147-63-1597', '123 Willow St', 41, 'Chief Executive Officer', 100000, '3'),
('23', 'ursula.henderson@example.com', 'pass1234', 'Ursula', 'Henderson', '963258-74-1567', '456 Elm St', 39, 'Legal Advisor', 80000, '1'),
('24', 'victor.miller@example.com', 'pass1234', 'Victor', 'Miller', '753159-47-2589', '789 Pine St', 44, 'Warehouse Manager', 55000, '2'),
('25', 'wendy.cook@example.com', 'pass1234', 'Wendy', 'Cook', '369741-25-9813', '234 Maple St', 29, 'Data Scientist', 65000, '3'),
('26', 'xander.ward@example.com', 'pass1234', 'Xander', 'Ward', '456258-14-7896', '567 Fir St', 37, 'Technical Writer', 47000, '1'),
('27', 'yasmine.reyes@example.com', 'pass1234', 'Yasmine', 'Reyes', '258147-96-7534', '890 Birch St', 30, 'IT Consultant', 59000, '2'),
('28', 'zachary.bell@example.com', 'pass1234', 'Zachary', 'Bell', '147258-63-9512', '123 Spruce St', 38, 'Executive Assistant', 45000, '3'),
('29', 'aaron.lee@example.com', 'pass1234', 'Aaron', 'Lee', '963852-79-4563', '456 Palm St', 26, 'Marketing Analyst', 43000, '1'),
('3', 'alice.jones@example.com', 'pass1234', 'Alice', 'Jones', '321654-98-7654', '789 Pine St', 25, 'HR Executive', 40000, '1'),
('30', 'bella.wood@example.com', 'pass1234', 'Bella', 'Wood', '258963-47-2583', '789 Acacia St', 35, 'Research Analyst', 62000, '2'),
('4', 'bob.brown@example.com', 'pass1234', 'Bob', 'Brown', '654321-12-3456', '234 Maple St', 45, 'IT Support', 35000, '3'),
('5', 'carol.white@example.com', 'pass1234', 'Carol', 'White', '456789-01-2345', '567 Cedar St', 38, 'Accountant', 50000, '2'),
('6', 'david.green@example.com', 'pass1234', 'David', 'Green', '654987-12-3456', '890 Birch St', 30, 'Data Analyst', 45000, '1'),
('7', 'ella.black@example.com', 'pass1234', 'Ella', 'Black', '159753-45-6897', '123 Elm St', 29, 'Marketing Specialist', 48000, '2'),
('8', 'frank.thompson@example.com', 'pass1234', 'Frank', 'Thompson', '753951-24-6875', '456 Spruce St', 37, 'Sales Executive', 52000, '3'),
('9', 'grace.martin@example.com', 'pass1234', 'Grace', 'Martin', '258963-14-1234', '789 Fir St', 33, 'Web Developer', 62000, '1');

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `loan_id` int(11) NOT NULL,
  `loan_type` varchar(25) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `interest_rate` decimal(5,2) NOT NULL,
  `loan_duration` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loan`
--

INSERT INTO `loan` (`loan_id`, `loan_type`, `amount`, `interest_rate`, `loan_duration`, `customer_id`) VALUES
(1, 'Home loan', '457987.00', '10.00', 8, 1),
(2, 'Personal loan', '10000.00', '999.99', 10, 9),
(3, 'Personal loan', '10000.00', '10.00', 10, 9);

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `position_id` varchar(25) NOT NULL,
  `position_name` varchar(25) NOT NULL,
  `emp_id` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`position_id`, `position_name`, `emp_id`) VALUES
('1', 'Manager', '1'),
('2', 'Assistant Manager', '2'),
('3', 'Assistant Manager', '3'),
('4', 'Security Guard', '4'),
('5', 'Staff', '5'),
('6', 'Staff', '6'),
('7', 'Staff', '7'),
('8', 'Staff', '8'),
('9', 'Staff', '9');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`account_id`),
  ADD KEY `fk_customer_account` (`customer_id`);

--
-- Indexes for table `atm`
--
ALTER TABLE `atm`
  ADD PRIMARY KEY (`atm_id`),
  ADD KEY `fk_branch_atm` (`brch_id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`brch_id`),
  ADD KEY `fk_employee_branch` (`emp_id`);

--
-- Indexes for table `creditcard`
--
ALTER TABLE `creditcard`
  ADD PRIMARY KEY (`card_id`),
  ADD KEY `fk_customer_card` (`customer_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`emp_id`),
  ADD UNIQUE KEY `emp_ic` (`emp_ic`),
  ADD KEY `fk_branch_employee` (`branch_id`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`loan_id`),
  ADD KEY `fk_customer_loan` (`customer_id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`position_id`),
  ADD KEY `fk_employee_position` (`emp_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `account_id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `creditcard`
--
ALTER TABLE `creditcard`
  MODIFY `card_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `fk_customer_account` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `atm`
--
ALTER TABLE `atm`
  ADD CONSTRAINT `fk_branch_atm` FOREIGN KEY (`brch_id`) REFERENCES `branch` (`brch_id`);

--
-- Constraints for table `branch`
--
ALTER TABLE `branch`
  ADD CONSTRAINT `fk_employee_branch` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`emp_id`);

--
-- Constraints for table `creditcard`
--
ALTER TABLE `creditcard`
  ADD CONSTRAINT `fk_customer_card` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `fk_branch_employee` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`brch_id`);

--
-- Constraints for table `loan`
--
ALTER TABLE `loan`
  ADD CONSTRAINT `fk_customer_loan` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `position`
--
ALTER TABLE `position`
  ADD CONSTRAINT `fk_employee_position` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`emp_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
