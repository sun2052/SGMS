/*
Navicat MySQL Data Transfer

Source Server         : MySQL
Source Server Version : 50512
Source Host           : localhost:3306
Source Database       : sgms

Target Server Type    : MYSQL
Target Server Version : 50512
File Encoding         : 65001

Date: 2011-05-30 21:11:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `course`
-- ----------------------------
DROP TABLE IF EXISTS `course`;
CREATE TABLE `course` (
  `CourseID` int(11) NOT NULL AUTO_INCREMENT,
  `CourseName` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `CourseCredit` int(11) NOT NULL,
  PRIMARY KEY (`CourseID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of course
-- ----------------------------
INSERT INTO `course` VALUES ('2', 'PHP', '4');
INSERT INTO `course` VALUES ('6', 'HTML5', '6');
INSERT INTO `course` VALUES ('7', 'CSS3', '5');
INSERT INTO `course` VALUES ('8', 'XHTML2', '3');
INSERT INTO `course` VALUES ('9', 'SQL', '4');
INSERT INTO `course` VALUES ('10', 'Ajax', '4');
INSERT INTO `course` VALUES ('11', 'jQuery', '2');

-- ----------------------------
-- Table structure for `grade`
-- ----------------------------
DROP TABLE IF EXISTS `grade`;
CREATE TABLE `grade` (
  `GradeID` int(11) NOT NULL AUTO_INCREMENT,
  `Grade` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  PRIMARY KEY (`GradeID`)
) ENGINE=InnoDB AUTO_INCREMENT=237 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of grade
-- ----------------------------
INSERT INTO `grade` VALUES ('202', '98', '10', '3');
INSERT INTO `grade` VALUES ('203', '99', '7', '3');
INSERT INTO `grade` VALUES ('204', '75', '6', '3');
INSERT INTO `grade` VALUES ('205', '48', '11', '3');
INSERT INTO `grade` VALUES ('206', '98', '2', '3');
INSERT INTO `grade` VALUES ('207', '77', '9', '3');
INSERT INTO `grade` VALUES ('208', '74', '8', '3');
INSERT INTO `grade` VALUES ('209', '98', '10', '4');
INSERT INTO `grade` VALUES ('210', '78', '7', '4');
INSERT INTO `grade` VALUES ('211', '78', '6', '4');
INSERT INTO `grade` VALUES ('212', '99', '11', '4');
INSERT INTO `grade` VALUES ('213', '67', '2', '4');
INSERT INTO `grade` VALUES ('214', '84', '9', '4');
INSERT INTO `grade` VALUES ('215', '80', '8', '4');
INSERT INTO `grade` VALUES ('216', '73', '10', '8');
INSERT INTO `grade` VALUES ('217', '69', '7', '8');
INSERT INTO `grade` VALUES ('218', '81', '6', '8');
INSERT INTO `grade` VALUES ('219', '85', '11', '8');
INSERT INTO `grade` VALUES ('220', '79', '2', '8');
INSERT INTO `grade` VALUES ('221', '88', '9', '8');
INSERT INTO `grade` VALUES ('222', '90', '8', '8');
INSERT INTO `grade` VALUES ('230', '78', '10', '9');
INSERT INTO `grade` VALUES ('231', '78', '7', '9');
INSERT INTO `grade` VALUES ('232', '99', '6', '9');
INSERT INTO `grade` VALUES ('233', '56', '11', '9');
INSERT INTO `grade` VALUES ('234', '76', '2', '9');
INSERT INTO `grade` VALUES ('235', '73', '9', '9');
INSERT INTO `grade` VALUES ('236', '34', '8', '9');

-- ----------------------------
-- Table structure for `student`
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `StudentID` int(11) NOT NULL AUTO_INCREMENT,
  `Gender` int(11) NOT NULL,
  `StudentName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `StudentNumber` int(11) NOT NULL,
  PRIMARY KEY (`StudentID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of student
-- ----------------------------
INSERT INTO `student` VALUES ('3', '1', '赵', '2007070273');
INSERT INTO `student` VALUES ('4', '2', '钱', '2007070274');
INSERT INTO `student` VALUES ('8', '2', '孙', '2007070275');
INSERT INTO `student` VALUES ('9', '2', '李', '2007070276');
INSERT INTO `student` VALUES ('11', '1', '周', '2007070277');
INSERT INTO `student` VALUES ('12', '1', '吴', '2007070278');
INSERT INTO `student` VALUES ('13', '1', '郑', '2007070279');
INSERT INTO `student` VALUES ('14', '1', '王', '2007070280');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `Salt` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `Privilege` int(11) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('8', 'admin', 'fd5ddba74e5ac706f3ae0b65e38cb964', '05f6d42b8ec4dd6516f1bbcfb5ce1186', '1');
INSERT INTO `user` VALUES ('13', 'student', 'd0f3589861c1a7011672583967302acb', '84f641d904701a43d0eeffea4e48a20a', '2');
INSERT INTO `user` VALUES ('14', 'a', '626abced9ba345fff8fa6a4b4201f110', '2acda8477cab7c42ee3543d4f7222015', '1');
INSERT INTO `user` VALUES ('20', 'b', 'd5fe7ee075b602af01aaf7bcbcbcc11e', 'c13b86d5aa366acf8e38309ecf53dd3d', '2');
