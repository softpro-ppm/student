-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2020 at 08:51 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `srms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `updationDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', '2017-05-13 11:18:49'),
(3, 'admin123', '827ccb0eea8a706c4c34a16891f84e7b', NULL),
(4, 'rajesh', '81dc9bdb52d04dc20036dbd8313ed055', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblassignjobroll`
--

CREATE TABLE `tblassignjobroll` (
  `id` int(10) NOT NULL,
  `trainingcenter_id` int(10) NOT NULL,
  `scheme_id` int(10) NOT NULL,
  `sector_id` int(10) NOT NULL,
  `jobroll_id` int(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblassignjobroll`
--

INSERT INTO `tblassignjobroll` (`id`, `trainingcenter_id`, `scheme_id`, `sector_id`, `jobroll_id`, `date`) VALUES
(1, 3, 17, 8, 2, '2020-06-01 19:28:43'),
(2, 5, 22, 10, 1, '2020-06-02 07:56:34'),
(3, 6, 27, 11, 6, '2020-06-28 07:17:03');

-- --------------------------------------------------------

--
-- Table structure for table `tblassignscheme`
--

CREATE TABLE `tblassignscheme` (
  `id` int(10) NOT NULL,
  `scheme_id` int(10) NOT NULL,
  `trainingcenter_id` int(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblassignscheme`
--

INSERT INTO `tblassignscheme` (`id`, `scheme_id`, `trainingcenter_id`, `date`) VALUES
(1, 17, 3, '2020-06-01 07:18:52'),
(2, 17, 3, '2020-06-01 17:11:49'),
(3, 21, 3, '2020-06-01 17:12:00'),
(4, 22, 5, '2020-06-02 07:55:22'),
(5, 27, 6, '2020-06-28 07:15:14');

-- --------------------------------------------------------

--
-- Table structure for table `tblassignsector`
--

CREATE TABLE `tblassignsector` (
  `id` int(11) NOT NULL,
  `trainingcenter_id` int(10) NOT NULL,
  `scheme_id` int(10) NOT NULL,
  `sector_id` int(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblassignsector`
--

INSERT INTO `tblassignsector` (`id`, `trainingcenter_id`, `scheme_id`, `sector_id`, `date`) VALUES
(1, 3, 17, 1, '2020-06-01 17:49:31'),
(2, 3, 17, 8, '2020-06-01 18:59:28'),
(3, 3, 17, 1, '2020-06-01 18:59:35'),
(4, 5, 22, 10, '2020-06-02 07:56:08'),
(5, 6, 27, 11, '2020-06-28 07:15:58');

-- --------------------------------------------------------

--
-- Table structure for table `tblbatch`
--

CREATE TABLE `tblbatch` (
  `id` int(10) NOT NULL,
  `training_centre_id` int(10) DEFAULT NULL,
  `scheme_id` int(10) DEFAULT NULL,
  `sector_id` int(10) DEFAULT NULL,
  `job_roll_id` int(10) DEFAULT NULL,
  `batch_name` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblbatch_candidate`
--

CREATE TABLE `tblbatch_candidate` (
  `id` int(10) NOT NULL,
  `candidate_id` int(10) NOT NULL,
  `batch_id` int(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblcandidate`
--

CREATE TABLE `tblcandidate` (
  `CandidateId` int(11) NOT NULL,
  `candidatename` varchar(55) DEFAULT NULL,
  `fathername` varchar(55) DEFAULT NULL,
  `aadharnumber` bigint(12) DEFAULT NULL,
  `phonenumber` bigint(10) DEFAULT NULL,
  `qualification` varchar(55) DEFAULT NULL,
  `dateofbirth` varchar(30) DEFAULT NULL,
  `gender` varchar(55) DEFAULT NULL,
  `maritalstatus` varchar(55) DEFAULT NULL,
  `religion` varchar(55) DEFAULT NULL,
  `category` varchar(55) DEFAULT NULL,
  `village` varchar(55) DEFAULT NULL,
  `mandal` varchar(55) DEFAULT NULL,
  `district` varchar(55) DEFAULT NULL,
  `state` varchar(55) DEFAULT NULL,
  `pincode` int(55) DEFAULT NULL,
  `candidatephoto` varchar(255) DEFAULT NULL,
  `aadhaarphoto` varchar(255) DEFAULT NULL,
  `qualificationphoto` varchar(255) DEFAULT NULL,
  `applicationphoto` varchar(255) DEFAULT NULL,
  `DateCreated` timestamp NULL DEFAULT current_timestamp(),
  `DateModified` timestamp NULL DEFAULT NULL,
  `tblbatch_id` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tblcandidatecertification`
--

CREATE TABLE `tblcandidatecertification` (
  `id` int(30) NOT NULL,
  `candidate_id` int(30) DEFAULT NULL,
  `batch_id` int(30) DEFAULT NULL,
  `certification` varchar(30) DEFAULT NULL,
  `certificatedoc` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcandidatecertification`
--

INSERT INTO `tblcandidatecertification` (`id`, `candidate_id`, `batch_id`, `certification`, `certificatedoc`, `date`) VALUES
(1, 23, 3, 'certified', NULL, '2020-06-21 19:43:02'),
(2, 24, 3, 'not certified', NULL, '2020-06-21 19:43:02'),
(3, 25, 3, 'certified', NULL, '2020-06-21 19:43:02'),
(8, 22, 6, 'not certified', NULL, '2020-06-29 14:20:55'),
(9, 26, 6, 'not certified', '5.jpeg', '2020-06-29 14:20:55');

-- --------------------------------------------------------

--
-- Table structure for table `tblcandidateresults`
--

CREATE TABLE `tblcandidateresults` (
  `id` int(30) NOT NULL,
  `candidate_id` int(30) DEFAULT NULL,
  `batch_id` int(30) DEFAULT NULL,
  `result` varchar(40) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcandidateresults`
--

INSERT INTO `tblcandidateresults` (`id`, `candidate_id`, `batch_id`, `result`, `date`) VALUES
(48, 23, 3, 'Pass', '2020-06-21 19:24:53'),
(49, 24, 3, 'Pass', '2020-06-21 19:24:53'),
(50, 25, 3, 'fail', '2020-06-21 19:24:53'),
(51, 22, 6, 'Pass', '2020-06-28 07:45:36'),
(52, 26, 6, 'Pass', '2020-06-28 07:45:36');

-- --------------------------------------------------------

--
-- Table structure for table `tblclasses`
--

CREATE TABLE `tblclasses` (
  `id` int(11) NOT NULL,
  `ClassName` varchar(80) DEFAULT NULL,
  `ClassNameNumeric` varchar(80) DEFAULT NULL,
  `Section` varchar(50) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblclasses`
--

INSERT INTO `tblclasses` (`id`, `ClassName`, `ClassNameNumeric`, `Section`, `CreationDate`, `UpdationDate`) VALUES
(17, 'Class X', '10', 'A', '2020-05-01 23:56:40', '2020-05-01 23:56:40'),
(18, 'New Batch', 'Retail', 'DelhiSoftpro', '2020-05-03 11:16:02', '2020-05-03 11:16:02'),
(19, 'test batch', 'test', 'test center', '2020-05-03 11:24:48', '2020-05-03 11:24:48'),
(20, 'FTCP', 'PMKVY', 'Softpro-YTC-Saluru', '2020-05-07 11:33:02', '2020-05-07 11:33:02'),
(21, NULL, NULL, NULL, '2020-05-07 15:20:07', '2020-05-07 15:20:07');

-- --------------------------------------------------------

--
-- Table structure for table `tblinvoice`
--

CREATE TABLE `tblinvoice` (
  `invoiceID` int(30) NOT NULL,
  `invoiceNo` int(30) DEFAULT NULL,
  `invoiceDate` date DEFAULT NULL,
  `manualbatchID` int(30) DEFAULT NULL,
  `trainingcenterID` int(30) DEFAULT NULL,
  `schemeID` int(30) DEFAULT NULL,
  `sectorID` int(30) DEFAULT NULL,
  `jobrollID` int(30) DEFAULT NULL,
  `batchID` int(30) DEFAULT NULL,
  `tranche` varchar(30) DEFAULT NULL,
  `invoiceAmount` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblinvoice`
--

INSERT INTO `tblinvoice` (`invoiceID`, `invoiceNo`, `invoiceDate`, `manualbatchID`, `trainingcenterID`, `schemeID`, `sectorID`, `jobrollID`, `batchID`, `tranche`, `invoiceAmount`) VALUES
(2, 61079682, '2020-07-04', 323232, 6, 27, 11, 6, 8, '2ND', '22221100');

-- --------------------------------------------------------

--
-- Table structure for table `tbljobroll`
--

CREATE TABLE `tbljobroll` (
  `JobrollId` int(12) NOT NULL,
  `jobrollname` varchar(55) NOT NULL,
  `CreationDate` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedDate` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbljobroll`
--

INSERT INTO `tbljobroll` (`JobrollId`, `jobrollname`, `CreationDate`, `UpdatedDate`) VALUES
(7, 'FIELD TECHNICIAN COMPUTING AND PERIPHERALS', '2020-07-12 11:38:37', NULL),
(8, 'FOOD AND BEVERAGES SERVICE STEWARD', '2020-07-12 11:39:29', NULL),
(9, 'SELF EMPLOYED TAILOR', '2020-07-12 11:39:43', NULL),
(10, 'DOMESTIC DATA ENTRY OPERATOR', '2020-07-12 11:39:56', NULL),
(11, 'FIELD TECHNICIAN NETWORKING STORAGE', '2020-07-12 11:40:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblplacement`
--

CREATE TABLE `tblplacement` (
  `placement_id` int(30) NOT NULL,
  `org_name` varchar(100) DEFAULT NULL,
  `salary` int(20) DEFAULT NULL,
  `doj` date DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `hr_contact_no` bigint(20) DEFAULT NULL,
  `date` timestamp NULL DEFAULT current_timestamp(),
  `candidate_id` int(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblplacement`
--

INSERT INTO `tblplacement` (`placement_id`, `org_name`, `salary`, `doj`, `location`, `hr_contact_no`, `date`, `candidate_id`) VALUES
(1, 'virtusa consulting', 21211, '2020-06-17', 'wqwqw', 21212121233, '2020-06-22 06:51:33', 22);

-- --------------------------------------------------------

--
-- Table structure for table `tblresult`
--

CREATE TABLE `tblresult` (
  `id` int(11) NOT NULL,
  `StudentId` int(11) DEFAULT NULL,
  `ClassId` int(11) DEFAULT NULL,
  `SubjectId` int(11) DEFAULT NULL,
  `marks` int(11) DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblscheme`
--

CREATE TABLE `tblscheme` (
  `SchemeId` int(11) NOT NULL,
  `SchemeName` varchar(55) CHARACTER SET latin1 NOT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `tblscheme`
--

INSERT INTO `tblscheme` (`SchemeId`, `SchemeName`, `CreationDate`, `UpdationDate`) VALUES
(29, 'PMKVY 2.0', '2020-07-12 05:43:20', '2020-07-12 05:43:20'),
(30, 'SC', '2020-07-12 05:44:10', '2020-07-12 05:44:10'),
(31, 'YTC', '2020-07-12 05:44:16', '2020-07-12 05:44:16'),
(32, 'PILOT', '2020-07-12 05:44:35', '2020-07-12 05:44:35'),
(33, 'NEW INITIATIVE', '2020-07-12 05:45:00', '2020-07-12 05:45:00'),
(34, 'CHRISTIAN MINORITY', '2020-07-12 05:45:37', '2020-07-12 05:45:37'),
(35, 'DUMMY', '2020-07-12 06:46:51', '2020-07-12 06:46:51');

-- --------------------------------------------------------

--
-- Table structure for table `tblsector`
--

CREATE TABLE `tblsector` (
  `SectorId` int(11) NOT NULL,
  `SectorName` varchar(55) NOT NULL,
  `DateCreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblsector`
--

INSERT INTO `tblsector` (`SectorId`, `SectorName`, `DateCreated`) VALUES
(12, 'APPAREL', '2020-07-12 06:05:15'),
(13, 'IT&ITES', '2020-07-12 06:05:30'),
(14, 'ELECTRONICS', '2020-07-12 06:05:42'),
(15, 'TOURISH & HOSPITALITY', '2020-07-12 06:05:57');

-- --------------------------------------------------------

--
-- Table structure for table `tblstudents`
--

CREATE TABLE `tblstudents` (
  `StudentId` int(11) NOT NULL,
  `StudentName` varchar(100) DEFAULT NULL,
  `RollId` varchar(100) DEFAULT NULL,
  `AadharId` varchar(100) DEFAULT NULL,
  `StudentEmail` varchar(100) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `DOB` varchar(100) DEFAULT NULL,
  `ClassId` int(11) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL,
  `Status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblstudents`
--

INSERT INTO `tblstudents` (`StudentId`, `StudentName`, `RollId`, `AadharId`, `StudentEmail`, `Gender`, `DOB`, `ClassId`, `RegDate`, `UpdationDate`, `Status`) VALUES
(1234567899, 'Raju', '01254', '5555555565', '55465drtrt@gmail.com', 'Male', '01-08-1980', 1, '2020-05-09 21:36:08', NULL, NULL),
(1234567901, 'fdgfdgf', 'gfgfd5564', '54545455', 'vhvhhgvhv@gmail.com', 'Male', '1980-08-01', 17, '2020-05-09 21:38:02', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblsubjectcombination`
--

CREATE TABLE `tblsubjectcombination` (
  `id` int(11) NOT NULL,
  `ClassId` int(11) DEFAULT NULL,
  `SubjectId` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `Updationdate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblsubjectcombination`
--

INSERT INTO `tblsubjectcombination` (`id`, `ClassId`, `SubjectId`, `status`, `CreationDate`, `Updationdate`) VALUES
(35, 17, 18, 1, '2020-05-01 23:57:15', NULL),
(36, 17, 18, 1, '2020-05-02 01:02:10', NULL),
(37, 19, 19, 1, '2020-05-03 11:25:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblsubjects`
--

CREATE TABLE `tblsubjects` (
  `id` int(11) NOT NULL,
  `SubjectName` varchar(100) NOT NULL,
  `SubjectCode` varchar(100) DEFAULT NULL,
  `Creationdate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblsubjects`
--

INSERT INTO `tblsubjects` (`id`, `SubjectName`, `SubjectCode`, `Creationdate`, `UpdationDate`) VALUES
(18, 'Maths000000001', '01', '2020-05-01 23:57:05', NULL),
(19, 'test subject', '01', '2020-05-03 11:25:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbltrainingcenter`
--

CREATE TABLE `tbltrainingcenter` (
  `TrainingcenterId` int(11) NOT NULL,
  `trainingcentername` varchar(55) NOT NULL,
  `tclocation` varchar(55) NOT NULL,
  `tcaddress` varchar(55) NOT NULL,
  `spocname` varchar(55) NOT NULL,
  `spoccontact` bigint(12) NOT NULL,
  `spocemailaddress` varchar(200) NOT NULL,
  `DateCreated` datetime NOT NULL DEFAULT current_timestamp(),
  `DateModified` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `id` int(30) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`id`, `name`, `email`) VALUES
(1, ':name', ':email'),
(2, ':name', ':email'),
(3, ':name', ':email'),
(6, 'discussdesk', 'discussdesk@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblassignjobroll`
--
ALTER TABLE `tblassignjobroll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblassignscheme`
--
ALTER TABLE `tblassignscheme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblassignsector`
--
ALTER TABLE `tblassignsector`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblbatch`
--
ALTER TABLE `tblbatch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblbatch_candidate`
--
ALTER TABLE `tblbatch_candidate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcandidate`
--
ALTER TABLE `tblcandidate`
  ADD PRIMARY KEY (`CandidateId`);

--
-- Indexes for table `tblcandidatecertification`
--
ALTER TABLE `tblcandidatecertification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcandidateresults`
--
ALTER TABLE `tblcandidateresults`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblclasses`
--
ALTER TABLE `tblclasses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblinvoice`
--
ALTER TABLE `tblinvoice`
  ADD PRIMARY KEY (`invoiceID`);

--
-- Indexes for table `tbljobroll`
--
ALTER TABLE `tbljobroll`
  ADD PRIMARY KEY (`JobrollId`);

--
-- Indexes for table `tblplacement`
--
ALTER TABLE `tblplacement`
  ADD PRIMARY KEY (`placement_id`);

--
-- Indexes for table `tblresult`
--
ALTER TABLE `tblresult`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblscheme`
--
ALTER TABLE `tblscheme`
  ADD PRIMARY KEY (`SchemeId`);

--
-- Indexes for table `tblsector`
--
ALTER TABLE `tblsector`
  ADD PRIMARY KEY (`SectorId`);

--
-- Indexes for table `tblstudents`
--
ALTER TABLE `tblstudents`
  ADD PRIMARY KEY (`StudentId`);

--
-- Indexes for table `tblsubjectcombination`
--
ALTER TABLE `tblsubjectcombination`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblsubjects`
--
ALTER TABLE `tblsubjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbltrainingcenter`
--
ALTER TABLE `tbltrainingcenter`
  ADD PRIMARY KEY (`TrainingcenterId`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblassignjobroll`
--
ALTER TABLE `tblassignjobroll`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblassignscheme`
--
ALTER TABLE `tblassignscheme`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblassignsector`
--
ALTER TABLE `tblassignsector`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblbatch`
--
ALTER TABLE `tblbatch`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblbatch_candidate`
--
ALTER TABLE `tblbatch_candidate`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcandidate`
--
ALTER TABLE `tblcandidate`
  MODIFY `CandidateId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tblcandidatecertification`
--
ALTER TABLE `tblcandidatecertification`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblcandidateresults`
--
ALTER TABLE `tblcandidateresults`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `tblclasses`
--
ALTER TABLE `tblclasses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tblinvoice`
--
ALTER TABLE `tblinvoice`
  MODIFY `invoiceID` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbljobroll`
--
ALTER TABLE `tbljobroll`
  MODIFY `JobrollId` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblplacement`
--
ALTER TABLE `tblplacement`
  MODIFY `placement_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblresult`
--
ALTER TABLE `tblresult`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblscheme`
--
ALTER TABLE `tblscheme`
  MODIFY `SchemeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tblsector`
--
ALTER TABLE `tblsector`
  MODIFY `SectorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tblstudents`
--
ALTER TABLE `tblstudents`
  MODIFY `StudentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1234567902;

--
-- AUTO_INCREMENT for table `tblsubjectcombination`
--
ALTER TABLE `tblsubjectcombination`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tblsubjects`
--
ALTER TABLE `tblsubjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbltrainingcenter`
--
ALTER TABLE `tbltrainingcenter`
  MODIFY `TrainingcenterId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
