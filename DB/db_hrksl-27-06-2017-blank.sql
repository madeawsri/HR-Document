-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for hrksl_db
CREATE DATABASE IF NOT EXISTS `hrksl_db` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `hrksl_db`;

-- Dumping structure for table hrksl_db.gmenu
CREATE TABLE IF NOT EXISTS `gmenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pmid` tinyint(4) DEFAULT NULL,
  `mid` int(11) DEFAULT NULL,
  `open` tinyint(4) DEFAULT NULL,
  `add` tinyint(4) DEFAULT NULL,
  `edit` tinyint(4) DEFAULT NULL,
  `del` tinyint(4) DEFAULT NULL,
  `pdf` tinyint(4) DEFAULT NULL,
  `kslid` varchar(3) NOT NULL,
  `exp` tinyint(4) DEFAULT NULL,
  `ass` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=90 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_ability
CREATE TABLE IF NOT EXISTS `hr_ability` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` varchar(13) NOT NULL,
  `abname1` varchar(100) NOT NULL,
  `abname2` varchar(100) NOT NULL,
  `abname3` varchar(100) NOT NULL,
  `abname4` varchar(100) NOT NULL,
  `refid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=334 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_agtype
CREATE TABLE IF NOT EXISTS `hr_agtype` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_appjob
CREATE TABLE IF NOT EXISTS `hr_appjob` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aptype1` tinyint(4) NOT NULL,
  `aptype2` tinyint(4) NOT NULL,
  `uid` int(11) NOT NULL,
  `datein` varchar(10) NOT NULL,
  `grtype` int(11) NOT NULL,
  `sutype` int(11) NOT NULL,
  `pptype` int(11) NOT NULL,
  `ndate` varchar(10) NOT NULL,
  `ns` int(11) NOT NULL,
  `ptype` int(11) NOT NULL,
  `satype` int(11) NOT NULL,
  `sxtype` int(11) NOT NULL,
  `agtype` int(11) NOT NULL,
  `etypes` varchar(100) NOT NULL,
  `note` text NOT NULL,
  `fupload` tinyint(4) NOT NULL DEFAULT '0',
  `fuppath` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `kslid` varchar(4) NOT NULL,
  `dtime` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_aptype1
CREATE TABLE IF NOT EXISTS `hr_aptype1` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_aptype2
CREATE TABLE IF NOT EXISTS `hr_aptype2` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_asm
CREATE TABLE IF NOT EXISTS `hr_asm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `fsore` tinyint(4) DEFAULT '3',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_company
CREATE TABLE IF NOT EXISTS `hr_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` varchar(13) NOT NULL,
  `cname` varchar(100) NOT NULL,
  `cwork` varchar(100) NOT NULL,
  `ctype` int(11) NOT NULL,
  `refid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=334 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_ctype
CREATE TABLE IF NOT EXISTS `hr_ctype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_dec_job
CREATE TABLE IF NOT EXISTS `hr_dec_job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pptype` int(11) NOT NULL,
  `ptype` int(11) NOT NULL,
  `agtype` int(11) NOT NULL,
  `sxtype` int(11) NOT NULL,
  `etypes` varchar(50) NOT NULL,
  `vtypes` varchar(50) NOT NULL,
  `attb` text NOT NULL,
  `satype` varchar(100) NOT NULL,
  `kslid` varchar(3) NOT NULL,
  `grtype` tinyint(4) NOT NULL,
  `sutype` tinyint(4) NOT NULL,
  `note` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_docref
CREATE TABLE IF NOT EXISTS `hr_docref` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` varchar(13) NOT NULL,
  `dtime` varchar(20) NOT NULL,
  `tbname` varchar(20) NOT NULL,
  `kslid` varchar(3) NOT NULL,
  `filename` varchar(50) NOT NULL,
  `detail` varchar(200) NOT NULL,
  `owner` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=358 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_do_asm
CREATE TABLE IF NOT EXISTS `hr_do_asm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asdate` varchar(20) DEFAULT NULL,
  `interview_id` int(11) DEFAULT NULL,
  `asid` int(11) DEFAULT NULL,
  `wval` tinyint(4) NOT NULL DEFAULT '0',
  `wvals` varchar(255) NOT NULL,
  `lasids` varchar(255) DEFAULT NULL,
  `scores` varchar(255) DEFAULT NULL,
  `score` varchar(5) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `notype` tinyint(4) NOT NULL DEFAULT '0',
  `sid` int(11) DEFAULT NULL,
  `sname` varchar(255) DEFAULT NULL,
  `kslid` varchar(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_driver
CREATE TABLE IF NOT EXISTS `hr_driver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` varchar(13) NOT NULL,
  `dtype` int(11) NOT NULL,
  `did` varchar(20) NOT NULL,
  `dout` varchar(10) NOT NULL,
  `dexp` varchar(10) NOT NULL,
  `refid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=334 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_dtype
CREATE TABLE IF NOT EXISTS `hr_dtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_education
CREATE TABLE IF NOT EXISTS `hr_education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` varchar(13) NOT NULL,
  `cer` varchar(30) NOT NULL,
  `suc` varchar(20) NOT NULL,
  `gra` varchar(5) NOT NULL,
  `edu` varchar(100) NOT NULL,
  `refid` int(11) NOT NULL,
  `skk` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=345 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_etype
CREATE TABLE IF NOT EXISTS `hr_etype` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_eutype
CREATE TABLE IF NOT EXISTS `hr_eutype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=227 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_grtype
CREATE TABLE IF NOT EXISTS `hr_grtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_interview
CREATE TABLE IF NOT EXISTS `hr_interview` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notype` tinyint(4) NOT NULL,
  `rpid` int(11) NOT NULL,
  `cid` varchar(13) NOT NULL,
  `kslid` varchar(3) NOT NULL,
  `ddate` varchar(15) NOT NULL,
  `ssite` varchar(100) NOT NULL,
  `sname` varchar(100) NOT NULL,
  `rtype` tinyint(4) NOT NULL,
  `note` varchar(500) NOT NULL,
  `approved` tinyint(4) NOT NULL DEFAULT '0',
  `sotype` tinyint(4) NOT NULL,
  `score` varchar(3) NOT NULL,
  `rdate` varchar(20) NOT NULL,
  `idate` varchar(20) NOT NULL,
  `note2` varchar(200) NOT NULL,
  `asids` varchar(255) DEFAULT NULL,
  `scores` varchar(255) DEFAULT NULL,
  `asdate` varchar(255) DEFAULT NULL,
  `asid` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=326 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_job
CREATE TABLE IF NOT EXISTS `hr_job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kslid` varchar(3) NOT NULL,
  `jtype` tinyint(4) NOT NULL DEFAULT '3',
  `djob` int(11) NOT NULL,
  `din` varchar(20) NOT NULL,
  `dexp` varchar(20) NOT NULL,
  `nn` tinyint(4) NOT NULL DEFAULT '1',
  `nx` tinyint(4) NOT NULL DEFAULT '0',
  `dtime` varchar(30) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `approved` tinyint(4) NOT NULL DEFAULT '0',
  `appr1` tinyint(4) NOT NULL DEFAULT '0',
  `appr2` tinyint(4) NOT NULL DEFAULT '0',
  `appr3` tinyint(4) NOT NULL DEFAULT '0',
  `appr4` tinyint(4) NOT NULL DEFAULT '0',
  `note` text NOT NULL,
  `grtype` tinyint(4) NOT NULL,
  `sutype` tinyint(4) NOT NULL,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_jtype
CREATE TABLE IF NOT EXISTS `hr_jtype` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_license
CREATE TABLE IF NOT EXISTS `hr_license` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` varchar(13) NOT NULL,
  `lid` varchar(20) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `lout` varchar(11) NOT NULL,
  `lexp` varchar(11) NOT NULL,
  `refid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_lst_asm
CREATE TABLE IF NOT EXISTS `hr_lst_asm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) DEFAULT NULL,
  `asid` int(11) DEFAULT NULL,
  `wval` tinyint(4) NOT NULL DEFAULT '1',
  `tname` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_notype
CREATE TABLE IF NOT EXISTS `hr_notype` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(90) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_person
CREATE TABLE IF NOT EXISTS `hr_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` varchar(13) DEFAULT NULL,
  `pname` varchar(10) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `bdate` varchar(10) NOT NULL,
  `addr` varchar(500) NOT NULL,
  `tel` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `lineid` varchar(20) NOT NULL,
  `kslid` varchar(3) NOT NULL,
  `iorder` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=382 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_person_doc
CREATE TABLE IF NOT EXISTS `hr_person_doc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rdate` varchar(10) NOT NULL,
  `pname` varchar(10) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `bdate` varchar(10) NOT NULL,
  `addr` varchar(500) NOT NULL,
  `sex` varchar(1) NOT NULL,
  `tel` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `lineid` varchar(20) NOT NULL,
  `kslid` varchar(3) NOT NULL,
  `dtime` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_person_refer
CREATE TABLE IF NOT EXISTS `hr_person_refer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` varchar(13) NOT NULL,
  `prname` varchar(100) NOT NULL,
  `prrefer` varchar(100) NOT NULL,
  `prname1` varchar(100) NOT NULL,
  `prrefer1` varchar(100) NOT NULL,
  `refid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=340 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_person_status
CREATE TABLE IF NOT EXISTS `hr_person_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` varchar(13) NOT NULL,
  `pstype` int(11) NOT NULL,
  `chil` int(11) NOT NULL,
  `refid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=334 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_pmtype
CREATE TABLE IF NOT EXISTS `hr_pmtype` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_pptype
CREATE TABLE IF NOT EXISTS `hr_pptype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_pstype
CREATE TABLE IF NOT EXISTS `hr_pstype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_ptype
CREATE TABLE IF NOT EXISTS `hr_ptype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=180 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_reg_position
CREATE TABLE IF NOT EXISTS `hr_reg_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` varchar(13) NOT NULL,
  `regp` varchar(100) NOT NULL,
  `regg` varchar(100) NOT NULL,
  `rdate` varchar(10) NOT NULL,
  `refid` int(11) NOT NULL,
  `dedit` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=397 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_rtype
CREATE TABLE IF NOT EXISTS `hr_rtype` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_satype
CREATE TABLE IF NOT EXISTS `hr_satype` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_soldier
CREATE TABLE IF NOT EXISTS `hr_soldier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` varchar(13) NOT NULL,
  `sotype` int(11) NOT NULL,
  `soin` varchar(10) NOT NULL,
  `soexp` varchar(10) NOT NULL,
  `sosite` varchar(100) NOT NULL,
  `sonote` varchar(100) NOT NULL,
  `refid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=257 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_sotype
CREATE TABLE IF NOT EXISTS `hr_sotype` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_stype
CREATE TABLE IF NOT EXISTS `hr_stype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_sutype
CREATE TABLE IF NOT EXISTS `hr_sutype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_sxtype
CREATE TABLE IF NOT EXISTS `hr_sxtype` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_vtype
CREATE TABLE IF NOT EXISTS `hr_vtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=181 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.hr_worktype
CREATE TABLE IF NOT EXISTS `hr_worktype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.menu
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `gid` int(11) NOT NULL,
  `rpus` tinyint(4) NOT NULL DEFAULT '0',
  `open` varchar(500) NOT NULL,
  `add` varchar(500) NOT NULL,
  `edit` varchar(500) NOT NULL,
  `del` varchar(500) NOT NULL,
  `pdf` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.mgroup
CREATE TABLE IF NOT EXISTS `mgroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `enable` tinyint(4) NOT NULL DEFAULT '0',
  `rpus` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.setting
CREATE TABLE IF NOT EXISTS `setting` (
  `site` varchar(7) NOT NULL,
  `sname` varchar(100) NOT NULL,
  `fyear` varchar(4) NOT NULL,
  `server` varchar(20) NOT NULL,
  `user` varchar(20) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `db` varchar(50) NOT NULL,
  `kks` varchar(150) NOT NULL,
  `code` varchar(10) NOT NULL,
  `addr` varchar(1000) NOT NULL,
  `msg1` varchar(300) NOT NULL,
  `msg2` varchar(300) NOT NULL,
  `fid` varchar(2) NOT NULL,
  `startdate` varchar(20) NOT NULL,
  `enddate` varchar(20) NOT NULL,
  `imgcarpath` varchar(200) NOT NULL,
  `hradmin` varchar(80) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.tbinfo
CREATE TABLE IF NOT EXISTS `tbinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `job` varchar(200) NOT NULL,
  `work` varchar(200) NOT NULL,
  `rcode` varchar(3) NOT NULL,
  `rname` varchar(150) NOT NULL,
  `rtime` int(11) NOT NULL,
  `ctime` varchar(30) NOT NULL,
  `access` tinyint(4) NOT NULL DEFAULT '1',
  `cdate` varchar(20) NOT NULL,
  `dtime` int(11) NOT NULL,
  `loginid` int(11) NOT NULL,
  `pmtype` tinyint(4) NOT NULL DEFAULT '1',
  `pptype` int(11) NOT NULL,
  `ptype` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.tblogin
CREATE TABLE IF NOT EXISTS `tblogin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(300) NOT NULL,
  `cids` varchar(200) NOT NULL,
  `aids` varchar(500) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `i` tinyint(4) NOT NULL DEFAULT '0',
  `d` tinyint(4) NOT NULL DEFAULT '0',
  `u` tinyint(4) NOT NULL DEFAULT '0',
  `a` tinyint(4) NOT NULL DEFAULT '0',
  `v` tinyint(4) NOT NULL DEFAULT '0',
  `dtime` int(11) NOT NULL,
  `cdate` varchar(20) NOT NULL,
  `ctime` varchar(20) NOT NULL,
  `status_info` tinyint(4) NOT NULL DEFAULT '0',
  `access` tinyint(4) NOT NULL DEFAULT '1',
  `site` varchar(5) NOT NULL,
  `fupdby` varchar(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table hrksl_db.tbpermision
CREATE TABLE IF NOT EXISTS `tbpermision` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `ins` tinyint(4) NOT NULL DEFAULT '0',
  `upd` tinyint(4) NOT NULL DEFAULT '0',
  `del` tinyint(4) NOT NULL DEFAULT '0',
  `vie` tinyint(4) NOT NULL DEFAULT '0',
  `filename` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=183 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
