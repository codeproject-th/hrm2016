-- phpMyAdmin SQL Dump
-- version 2.9.2
-- http://www.phpmyadmin.net
-- 
-- โฮสต์: localhost
-- เวลาในการสร้าง: 
-- รุ่นของเซิร์ฟเวอร์: 5.0.27
-- รุ่นของ PHP: 5.3.29
-- 
-- ฐานข้อมูล: `hrm2016`
-- 

-- --------------------------------------------------------

-- 
-- โครงสร้างตาราง `employees`
-- 

CREATE TABLE `employees` (
  `emp_id` int(11) NOT NULL auto_increment,
  `emp_code` varchar(50) NOT NULL COMMENT 'รหัสผนักงาน',
  `emp_prefix` varchar(20) NOT NULL COMMENT 'คำนำหน้าชื่อ',
  `emp_name` varchar(100) NOT NULL COMMENT 'ชื่ิอ',
  `emp_last_name` varchar(100) NOT NULL COMMENT 'นามสกุล',
  `emp_sex` int(1) NOT NULL COMMENT 'เพศ',
  `emp_religion` varchar(100) NOT NULL COMMENT 'ศาสนา',
  `emp_nationality` varchar(100) NOT NULL COMMENT 'สัฐชาติ',
  `emp_nation` varchar(100) NOT NULL COMMENT 'เชื่อชาติ',
  `emp_birthday` date NOT NULL COMMENT 'วันเกิด',
  `emp_idcard` varchar(20) NOT NULL COMMENT 'บัตรประชาชน',
  `emp_status_people` varchar(100) NOT NULL COMMENT 'สถานะภาพการสมรส',
  `emp_img` varchar(100) NOT NULL COMMENT 'รูปพนักงาน',
  `emp_academy` varchar(100) NOT NULL COMMENT 'สถานศึกษา',
  `emp_education` varchar(100) NOT NULL COMMENT 'ระดับการศึกษา',
  `emp_subjects` varchar(100) NOT NULL COMMENT 'สาขาวิชา',
  `emp_yearend` varchar(10) NOT NULL COMMENT 'ปีที่จบ',
  `emp_party` int(10) NOT NULL COMMENT 'ฝ่าย',
  `emp_department` int(10) NOT NULL COMMENT 'แผนก',
  `emp_office` int(10) NOT NULL COMMENT 'ตำแหน่งงาน',
  `emp_jobstart` date NOT NULL COMMENT 'วันที่เริ่มงาน',
  `emp_salary` float NOT NULL COMMENT 'เงินเดือน',
  `emp_status` int(1) NOT NULL COMMENT 'สถานะพนักงาน',
  `emp_address1` varchar(200) NOT NULL COMMENT 'ที่อยู่ตามทะเบียนบ้าน',
  `emp_sub_district1` varchar(100) NOT NULL COMMENT 'ตำบล',
  `emp_district1` varchar(100) NOT NULL COMMENT 'อำเภอ',
  `emp_province1` varchar(100) NOT NULL COMMENT 'จังหวัดตามทะเบียนบ้าน',
  `emp_zipcod1` varchar(10) NOT NULL COMMENT 'รหัสไปรษณีย์',
  `emp_address2` varchar(200) NOT NULL COMMENT 'ที่อยู่ปัจจุบัน',
  `emp_sub_district2` varchar(100) NOT NULL COMMENT 'ตำบล',
  `emp_district2` varchar(100) NOT NULL COMMENT 'อำเภอ',
  `emp_province2` varchar(100) NOT NULL COMMENT 'จังหวัดปัจจุบัน',
  `emp_zipcod2` varchar(10) NOT NULL COMMENT 'รหัสไปรษณีปัจจุบัน',
  `create_date` datetime NOT NULL,
  `emp_level` text COMMENT 'ระดับพนักงาน',
  PRIMARY KEY  (`emp_id`),
  FULLTEXT KEY `employees_address1` (`emp_address1`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- 
-- dump ตาราง `employees`
-- 

INSERT INTO `employees` VALUES (1, '58105', '1', 'อำพล', 'เทียมนุช', 1, '', '', '', '1987-08-28', 'dada', '2', '20160301083417-3.jpg', '', '', 'a', '', 1, 3, 1, '2011-12-01', 20000, 0, 'sd', '', '', 'dddd', 'a', 'd', '', '', 'a', 'dd', '2011-12-16 09:09:32', '03');
INSERT INTO `employees` VALUES (5, '', '1', 'สรศัก', 'สมมุติ', 1, '', '', '', '0000-00-00', '', '', '', '', '', '', '', 0, 0, 0, '0000-00-00', 0, 0, '', '', '', '', '', '', '', '', '', '', '2016-03-08 13:38:04', '01');

-- --------------------------------------------------------

-- 
-- โครงสร้างตาราง `holiday`
-- 

CREATE TABLE `holiday` (
  `holiday_id` int(11) NOT NULL auto_increment,
  `holiday_name` varchar(100) NOT NULL COMMENT 'ชื่อวันหยุด',
  `holiday_date` date NOT NULL COMMENT 'วันที่หยุด',
  `holiday_comment` text NOT NULL COMMENT 'หมายเหตุ',
  `create_date` datetime NOT NULL,
  PRIMARY KEY  (`holiday_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='วันหยุด' AUTO_INCREMENT=5 ;

-- 
-- dump ตาราง `holiday`
-- 

INSERT INTO `holiday` VALUES (1, 'ปีใหม่', '2016-02-29', '555', '2011-12-17 14:30:40');

-- --------------------------------------------------------

-- 
-- โครงสร้างตาราง `leave`
-- 

CREATE TABLE `leave` (
  `leave_id` int(11) NOT NULL auto_increment,
  `emp_id` int(11) NOT NULL COMMENT 'รหัสพนักงาน',
  `leave_type` int(11) NOT NULL COMMENT 'ประเภทการลา',
  `leave_start_day` date NOT NULL COMMENT 'วันที่เริ่มลา',
  `leave_end_day` date NOT NULL COMMENT 'วันที่สิ้นสุด',
  `leave_comment` text NOT NULL COMMENT 'หมาเหตุการลา',
  `leave_status` int(1) NOT NULL COMMENT '0=รอ 1=อนุมัติ 2=ไม่อนุมัติ 3=ยกเลิก',
  `leave_endorser_emp` int(11) NOT NULL COMMENT 'id พนักงานผู้อนุมัติ',
  `leave_n` float(10,2) NOT NULL COMMENT 'จำนวนวันที่ลา',
  `leave_full` int(1) NOT NULL COMMENT '1=เตมวัน 2=ครึ่งวันเช้า 3=ครึ่งวันบ่าย',
  `create_date` datetime NOT NULL,
  `leave_approve_date` date default NULL COMMENT 'วันที่อนุมัติ',
  `leave_approve_comment` text NOT NULL COMMENT 'หมายเหตุที่ไม่อนุมัติ',
  PRIMARY KEY  (`leave_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- dump ตาราง `leave`
-- 

INSERT INTO `leave` VALUES (1, 1, 1, '2016-03-07', '2016-03-07', '', 1, 1, 1.00, 1, '2016-03-07 10:46:00', NULL, '');
INSERT INTO `leave` VALUES (2, 1, 3, '2016-03-16', '2016-03-18', '', 2, 1, 1.50, 2, '2016-03-07 10:46:30', '2016-03-07', 'ไม่ให้ไป');
INSERT INTO `leave` VALUES (3, 1, 3, '2016-03-01', '2016-03-03', 'ปวดหัว', 1, 1, 1.50, 2, '2016-03-07 18:10:12', NULL, '');

-- --------------------------------------------------------

-- 
-- โครงสร้างตาราง `leave_detail`
-- 

CREATE TABLE `leave_detail` (
  `leave_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL COMMENT 'id พนักงาน',
  `leave_date` date NOT NULL COMMENT 'วันที่ลา',
  `status` int(1) NOT NULL COMMENT '0=รอ 1=อนุมัติ 2=ไม่อนุมัติ 3=ยกเลิก'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='รายละเอียดวันที่ลา';

-- 
-- dump ตาราง `leave_detail`
-- 

INSERT INTO `leave_detail` VALUES (1, 1, '2016-03-07', 1);
INSERT INTO `leave_detail` VALUES (3, 1, '2016-03-03', 1);
INSERT INTO `leave_detail` VALUES (2, 1, '2016-03-18', 2);
INSERT INTO `leave_detail` VALUES (2, 1, '2016-03-17', 2);
INSERT INTO `leave_detail` VALUES (2, 1, '2016-03-16', 2);
INSERT INTO `leave_detail` VALUES (3, 1, '2016-03-02', 1);
INSERT INTO `leave_detail` VALUES (3, 1, '2016-03-01', 1);

-- --------------------------------------------------------

-- 
-- โครงสร้างตาราง `leave_endorser`
-- 

CREATE TABLE `leave_endorser` (
  `leave_endorser_id` int(11) NOT NULL auto_increment,
  `emp_id` int(11) NOT NULL COMMENT 'รหัสพนักงาน',
  `leave_endorser_emp` int(11) NOT NULL COMMENT 'ผู้อนุมัติ',
  PRIMARY KEY  (`leave_endorser_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='ผู้อนุมัติ' AUTO_INCREMENT=5 ;

-- 
-- dump ตาราง `leave_endorser`
-- 

INSERT INTO `leave_endorser` VALUES (4, 1, 1);

-- --------------------------------------------------------

-- 
-- โครงสร้างตาราง `master_department`
-- 

CREATE TABLE `master_department` (
  `department_id` int(11) NOT NULL auto_increment,
  `party_id` int(11) NOT NULL COMMENT 'ฝ่าย',
  `department_name` varchar(100) NOT NULL COMMENT 'ชื่อแผนก',
  PRIMARY KEY  (`department_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='แผนก' AUTO_INCREMENT=4 ;

-- 
-- dump ตาราง `master_department`
-- 

INSERT INTO `master_department` VALUES (3, 1, 'ทดสอบ');

-- --------------------------------------------------------

-- 
-- โครงสร้างตาราง `master_leave_type`
-- 

CREATE TABLE `master_leave_type` (
  `leave_type_id` int(11) NOT NULL auto_increment,
  `leave_type_name` varchar(255) NOT NULL,
  `leave_number` int(11) NOT NULL COMMENT 'จำนวนวันที่ใช้ได้',
  `leave_cut_day` int(11) NOT NULL COMMENT 'วันที่ตัดรอบ',
  `leave_cut_month` int(11) NOT NULL COMMENT 'เดือนที่ตัดรอบ',
  PRIMARY KEY  (`leave_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='ประเภทการลา' AUTO_INCREMENT=5 ;

-- 
-- dump ตาราง `master_leave_type`
-- 

INSERT INTO `master_leave_type` VALUES (1, 'ลากิจ', 7, 31, 12);
INSERT INTO `master_leave_type` VALUES (3, 'ลาป่วย', 30, 31, 12);
INSERT INTO `master_leave_type` VALUES (4, 'ลาพักร้อน', 7, 31, 12);

-- --------------------------------------------------------

-- 
-- โครงสร้างตาราง `master_list`
-- 

CREATE TABLE `master_list` (
  `list_id` int(11) NOT NULL auto_increment,
  `list_name` varchar(200) NOT NULL COMMENT 'ชื่อรายการ',
  PRIMARY KEY  (`list_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='รายละเอียดที่หักหรือเพิ่มของเงินเดือน' AUTO_INCREMENT=6 ;

-- 
-- dump ตาราง `master_list`
-- 

INSERT INTO `master_list` VALUES (1, 'เงินเดือน');
INSERT INTO `master_list` VALUES (3, 'ค่าประกันสังคม');

-- --------------------------------------------------------

-- 
-- โครงสร้างตาราง `master_office`
-- 

CREATE TABLE `master_office` (
  `office_id` int(11) NOT NULL auto_increment,
  `office_name` varchar(100) NOT NULL COMMENT 'ชื่อตำแหน่ง',
  PRIMARY KEY  (`office_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='ตำแหน่ง' AUTO_INCREMENT=4 ;

-- 
-- dump ตาราง `master_office`
-- 

INSERT INTO `master_office` VALUES (1, 'หัวหน้า33');

-- --------------------------------------------------------

-- 
-- โครงสร้างตาราง `master_party`
-- 

CREATE TABLE `master_party` (
  `party_id` int(11) NOT NULL auto_increment,
  `party_name` varchar(255) NOT NULL COMMENT 'ชื่อฝ่าย',
  PRIMARY KEY  (`party_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='ฝ่าย' AUTO_INCREMENT=3 ;

-- 
-- dump ตาราง `master_party`
-- 

INSERT INTO `master_party` VALUES (1, 'ทรัพยากรมนุษย์');

-- --------------------------------------------------------

-- 
-- โครงสร้างตาราง `salary`
-- 

CREATE TABLE `salary` (
  `salary_id` int(11) NOT NULL auto_increment,
  `employees_id` int(11) NOT NULL COMMENT 'id พนักงาน',
  `salary_month` varchar(2) NOT NULL COMMENT 'เดือนที่จ่ายเงิน',
  `salary_year` varchar(4) NOT NULL COMMENT 'ปีที่จ่ายเงิน',
  `salary_money` float NOT NULL COMMENT 'จำนวนเงินที่จ่าย',
  `create_user` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY  (`salary_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- dump ตาราง `salary`
-- 

INSERT INTO `salary` VALUES (1, 1, '12', '2011', 19300, 1, '2011-12-19 21:54:32');

-- --------------------------------------------------------

-- 
-- โครงสร้างตาราง `salary_detail`
-- 

CREATE TABLE `salary_detail` (
  `month` varchar(2) NOT NULL COMMENT 'เดือนที่จ้่าย',
  `year` varchar(4) NOT NULL COMMENT 'ปีที่จ่าย',
  `list_id` int(11) NOT NULL COMMENT 'รายการ จาก master',
  `employess_id` int(11) NOT NULL COMMENT 'id พนักงาน',
  `salary_type` int(11) NOT NULL COMMENT 'ประเภทเงินเดือน',
  `money` float NOT NULL COMMENT 'เงิน',
  `create_date` datetime NOT NULL COMMENT 'วันที่สร้าง'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- dump ตาราง `salary_detail`
-- 

INSERT INTO `salary_detail` VALUES ('12', '2011', 1, 1, 1, 20000, '2011-12-19 21:54:32');
INSERT INTO `salary_detail` VALUES ('12', '2011', 3, 1, 2, 700, '2011-12-19 21:54:32');

-- --------------------------------------------------------

-- 
-- โครงสร้างตาราง `time_attendance`
-- 

CREATE TABLE `time_attendance` (
  `time_att_id` int(11) NOT NULL auto_increment,
  `emp_id` int(11) NOT NULL COMMENT 'id พนักงาน',
  `time_att_date` datetime NOT NULL COMMENT 'เวลา',
  `time_att_type` varchar(10) NOT NULL COMMENT 'in,out',
  `time_att_late` varchar(2) NOT NULL COMMENT 'ืn=ไม่สาย y=สาย',
  PRIMARY KEY  (`time_att_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='เวลาเข่างาน' AUTO_INCREMENT=13 ;

-- 
-- dump ตาราง `time_attendance`
-- 

INSERT INTO `time_attendance` VALUES (1, 1, '2016-03-23 17:06:53', 'out', 'y');
INSERT INTO `time_attendance` VALUES (2, 1, '2016-03-24 07:00:36', 'in', 'n');
INSERT INTO `time_attendance` VALUES (3, 1, '2016-03-24 17:06:22', 'out', 'y');
INSERT INTO `time_attendance` VALUES (4, 1, '2016-03-25 06:51:59', 'in', 'n');
INSERT INTO `time_attendance` VALUES (5, 1, '2016-03-25 17:10:39', 'out', 'y');
INSERT INTO `time_attendance` VALUES (6, 1, '2016-03-26 07:00:36', 'in', 'n');
INSERT INTO `time_attendance` VALUES (7, 1, '2016-03-26 17:02:30', 'out', 'y');
INSERT INTO `time_attendance` VALUES (8, 1, '2016-03-27 07:07:20', 'in', 'n');
INSERT INTO `time_attendance` VALUES (9, 1, '2016-03-27 17:24:40', 'out', 'y');
INSERT INTO `time_attendance` VALUES (10, 1, '2016-03-29 06:57:19', 'in', 'n');
INSERT INTO `time_attendance` VALUES (11, 1, '2016-03-29 17:00:17', 'out', 'y');
INSERT INTO `time_attendance` VALUES (12, 1, '2016-03-30 07:08:47', 'in', 'n');

-- --------------------------------------------------------

-- 
-- โครงสร้างตาราง `user`
-- 

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL auto_increment,
  `user_name` varchar(50) NOT NULL COMMENT 'ีusername',
  `user_pwd` varchar(50) NOT NULL COMMENT 'password',
  `user_type` int(1) NOT NULL COMMENT 'ประเภทผู้ใช้งาน',
  `employees_id` int(11) NOT NULL COMMENT 'id พนักงาน',
  `create_date` datetime NOT NULL COMMENT 'วันที่สร้าง',
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='ผู้ใช้งาน' AUTO_INCREMENT=7 ;

-- 
-- dump ตาราง `user`
-- 

INSERT INTO `user` VALUES (1, 'admin', 'admin', 1, 1, '0000-00-00 00:00:00');
INSERT INTO `user` VALUES (6, 'test', '11111', 3, 5, '2016-03-08 13:38:39');

-- --------------------------------------------------------

-- 
-- โครงสร้างตาราง `weekend`
-- 

CREATE TABLE `weekend` (
  `monday` int(1) NOT NULL,
  `tuesday` int(1) NOT NULL,
  `wednesday` int(1) NOT NULL,
  `thursday` int(1) NOT NULL,
  `friday` int(1) NOT NULL,
  `saturday` int(1) NOT NULL,
  `sunday` int(1) NOT NULL,
  `job_in` varchar(10) NOT NULL,
  `job_out` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- dump ตาราง `weekend`
-- 

INSERT INTO `weekend` VALUES (1, 1, 1, 1, 1, 1, 0, '08:00', '17:30');
