-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 07, 2015 at 10:13 AM
-- Server version: 5.5.44-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `magzhub`
--
CREATE DATABASE IF NOT EXISTS `magzhub` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `magzhub`;

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `addCategory`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addCategory`(in CategoryName varchar(255))
begin
insert into categories (name)
values(CategoryName);
end$$

DROP PROCEDURE IF EXISTS `addIssue`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addIssue`(IN `magId` INT(11))
BEGIN
INSERT into issues(magazineId,url)VALUES(magId,'https://drive.google.com/open?id=0B4Re2J0YY8xeNDRCWEdxaFFLMlE');
end$$

DROP PROCEDURE IF EXISTS `addMagazine`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addMagazine`(IN `magName` VARCHAR(255), IN `catId` INT(11), IN `publishId` INT, IN `description` TEXT, IN `magazineFreq` VARCHAR(255))
BEGIN
insert into magazines(magazines.MagazineName,magazines.categoryId,magazines.publisherId,magazines.magazineDescription,magazines.magazineFrequency)
VALUES (magName,catId,publishId,description,magazineFreq);
END$$

DROP PROCEDURE IF EXISTS `changePasswordPublisher`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `changePasswordPublisher`(IN `pubId` INT, IN `oldPassword` VARCHAR(255), IN `newPassword` VARCHAR(255))
Begin
DECLARE result varchar(255);
SELECT publisher.password into result from publisher where publisher.publisherId=pubID and publisher.password=oldPassword;
if(result is not null)
THEN
UPDATE publisher SET
publisher.password=newPassword where publisher.publisherId=pubId ;
set result=1;
select result;
ELSE
set result=0;
select result;
end if;
END$$

DROP PROCEDURE IF EXISTS `changePasswordUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `changePasswordUser`(in userId int,in oldPassword varchar(255),in newPassword varchar(255))
Begin
DECLARE result varchar(255);
SELECT user.password into result from user where user.userid=userId and user.password=oldPassword;
if(result is not null)
THEN
UPDATE user SET
user.password=newPassword where user.userid=userId ;
set result=1;
select result;
ELSE
set result=0;
select result;
end if;
END$$

DROP PROCEDURE IF EXISTS `checkingmagazineimageupload`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `checkingmagazineimageupload`(in filepath varchar(200),in magName varchar(100))
BEGIN
update magazines
set magazineThumbnail=load_file(filepath)
where magazines.MagazineName=magName;
END$$

DROP PROCEDURE IF EXISTS `CheckSusbscriptionStatus`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CheckSusbscriptionStatus`(in userid int,in magid int)
begin
	select CheckSubscription(userid, magid) AS subscriptionID ;

end$$

DROP PROCEDURE IF EXISTS `getDetailsForUploadingInGoogleDrive`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getDetailsForUploadingInGoogleDrive`(IN `issuId` INT)
BEGIN
select tempissueupload.name from tempissueupload where tempissueupload.issueId=issuId;
END$$

DROP PROCEDURE IF EXISTS `getDifferentIssuesOfMagazine`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getDifferentIssuesOfMagazine`(in magId int ,in userId int)
BEGIN
DECLARE subscriptionid int;
select CheckSubscription( userId , magId ) into  subscriptionid;
    if(subscriptionid is not null)
    then
SELECT issues.issueid, issues.issueName, issues.issueThumbnail FROM issues WHERE issues.magazineId=magId ORDER by issues.issueDate DESC;
end If;
END$$

DROP PROCEDURE IF EXISTS `getFileIdOfIssue`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getFileIdOfIssue`(IN `issuId` INT)
BEGIN
SELECT issues.fileId from issues WHERE issues.issueid=issuId;
END$$

DROP PROCEDURE IF EXISTS `getFileIdOfLatestissue`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getFileIdOfLatestissue`(IN `magId` INT, IN `userId` INT)
begin
declare subscriptionid int;
 select CheckSubscription( userid , magid ) into  subscriptionid;
    if(subscriptionid is not null)
    then
select fileId from issues where issues.magazineid=magId
order by issueDate desc limit 1;
end if;
end$$

DROP PROCEDURE IF EXISTS `getFileIdOfLatestIssuePublisher`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getFileIdOfLatestIssuePublisher`(IN `magid` INT, IN `pubid` INT)
BEGIN
SELECT issues.fileId from issues where issues.magazineId=(select magazines.Magazineid from magazines WHERE magazines.Magazineid=magid
AND magazines.publisherId=pubid);
End$$

DROP PROCEDURE IF EXISTS `getIssueIdForInsertingDetails`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getIssueIdForInsertingDetails`(in filpath varchar  (250))
BEGIN
select tempissueupload.issueId from tempissueupload WHERE
tempissueupload.filepath=filpath;
END$$

DROP PROCEDURE IF EXISTS `getSubscribedMagazineOfUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getSubscribedMagazineOfUser`(in userId int)
BEGIN
select magazines.MagazineName,magazines.Magazineid from magazines where magazines.Magazineid in(select subscription.magazineID from subscription where subscription.userID=userId );
END$$

DROP PROCEDURE IF EXISTS `insertDetailsIntoIssuesTable`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertDetailsIntoIssuesTable`(IN `tempIssueId` INT)
BEGIN
declare issuId int;
declare magId int;
declare filId varchar(100);
declare issuDate timestamp;
declare dscription text;
declare filName varchar(100);
declare issuName varchar(255);
declare issuThumbnail longblob;

select tempissueupload.issueId,tempissueupload.magazineId,tempissueupload.fileId,tempissueupload.issueDate,tempissueupload.description,
tempissueupload.name, tempissueupload.issueName,tempissueupload.issueThumbnail into issuId,magId,filId,issuDate,dscription,filName,issuName,issuThumbnail from tempissueupload where tempissueupload.issueId=tempIssueId and tempissueupload.isUpload='Y'  ;

insert into issues (issueid,magazineid,fileid,issueDate,description,fileName,issueName,issueThumbnail)
VALUES (issuId,magId,filId,issuDate,dscription,filName,issuName,issuThumbnail);
delete from tempissueupload where tempissueupload.issueId=tempIssueId and tempissueupload.isUpload='Y';

END$$

DROP PROCEDURE IF EXISTS `insertFileIdInTempIssueUpload`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertFileIdInTempIssueUpload`(IN `driveFileId` VARCHAR(250), IN `issueId` INT)
BEGIN
update tempissueupload set fileId=driveFileId,tempissueupload.isUpload='Y' where tempissueupload.issueId=issueId ;
END$$

DROP PROCEDURE IF EXISTS `insertIssue`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertIssue`(IN magid int,IN url varchar(250))
begin
insert into issues(magazineId,url) values(magid,url);
end$$

DROP PROCEDURE IF EXISTS `ListCategories`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ListCategories`()
begin
	select id, name from categories;
end$$

DROP PROCEDURE IF EXISTS `ListMagazines`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ListMagazines`(IN catId int)
begin
	select  MagazineId,MagazineName from magazines where categoryId=catid;
end$$

DROP PROCEDURE IF EXISTS `listMagazinesPublisher`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `listMagazinesPublisher`(in catId int,in publishId int)
begin
select  MagazineId,MagazineName from magazines where categoryId=catid
and publisherId=publishId;
end$$

DROP PROCEDURE IF EXISTS `listMagazineThumbnailPublisher`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `listMagazineThumbnailPublisher`(IN pubid int)
BEGIN
SELECT magazineid, MagazineName,magazineThumbnail from magazines WHERE magazines.publisherId=pubid;
END$$

DROP PROCEDURE IF EXISTS `listThumbnailForCategories`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `listThumbnailForCategories`()
BEGIN
SELECT thumbnail from categories;
end$$

DROP PROCEDURE IF EXISTS `listThumbnailForMagazine`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `listThumbnailForMagazine`(in catId int)
BEGIN
SELECT magazineThumbnail from magazines WHERE magazines.categoryId=catId;
END$$

DROP PROCEDURE IF EXISTS `listThumbnailForSubscribedMagazine`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `listThumbnailForSubscribedMagazine`(IN `userId` INT)
BEGIN
SELECT magazineThumbnail FROM magazines where magazines.Magazineid in(
select subscription.magazineID from subscription where subscription.userID=userId);
End$$

DROP PROCEDURE IF EXISTS `showMessagePublisher`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `showMessagePublisher`(IN `pubId` INT)
BEGIN
select first_name from publisher where publisherId=pubId;
end$$

DROP PROCEDURE IF EXISTS `showMessageUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `showMessageUser`(IN `userId` INT)
    NO SQL
BEGIN
select first_name from user where user.userid=userId;
end$$

DROP PROCEDURE IF EXISTS `SubscribeMagazine`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SubscribeMagazine`(in userid int,in magid int)
begin
	declare subscriptionid int;
	select CheckSubscription( userid , magid ) into  subscriptionid;
    if(subscriptionid is null)
    then
		insert into subscription(userID,magazineID) values(userid,magid);
    end if;

end$$

DROP PROCEDURE IF EXISTS `SubscribeOrUnsubscribeMagazine`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SubscribeOrUnsubscribeMagazine`(in userid int,in magid int)
begin
	declare subscriptionid int;
    select CheckSubscription( userid , magid ) into  subscriptionid;
    if(subscriptionid is null)
    then
		insert into subscription(userID,magazineID) values(userid,magid);
	else
    delete from  subscription where subscription.SubscriptionID=subscriptionid ;
    end if;
end$$

DROP PROCEDURE IF EXISTS `UnsubscribeMagazine`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `UnsubscribeMagazine`(in userid int,in magid int)
begin
	declare subscriptionid int;
	select CheckSubscription( userid , magid ) into  subscriptionid;
    if(subscriptionid is not null)
    then
		delete from  subscription where subscription.SubscriptionID=subscriptionid;
    end if;
end$$

DROP PROCEDURE IF EXISTS `updateMagazineThumbnail`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateMagazineThumbnail`(IN `magId` INT, IN `filPath` LONGBLOB)
BEGIN
update magazines
set magazines.magazineThumbnail=filPath
where magazines.Magazineid=magId;
END$$

DROP PROCEDURE IF EXISTS `uploadBigFilePathIssue`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `uploadBigFilePathIssue`(IN `filPath` VARCHAR(255), IN `filname` VARCHAR(255))
BEGIN
INSERT into tempissueupload(tempissueupload.filepath,tempissueupload.name)VALUES(filPath,filname);
end$$

DROP PROCEDURE IF EXISTS `uploadIssue`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `uploadIssue`(IN `magId` INT, IN `dscription` TEXT, IN `issuName` VARCHAR(255), IN `filPath` LONGBLOB, IN `issuId` INT)
BEGIN
UPDATE tempissueupload SET 
tempissueupload.magazineId=magId,tempissueupload.description=dscription,tempissueupload.issueName=issuName ,tempissueupload.issueThumbnail=filPath WHERE tempissueupload.issueId=issuId;
call updateMagazineThumbnail(magId,filPath);

END$$

DROP PROCEDURE IF EXISTS `ValidatePublisher`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ValidatePublisher`(IN `emailid` VARCHAR(40), IN `passwd` VARCHAR(40))
begin
if exists (select publisherId  from publisher where publisher.email=emailid)
	then
		select password into @pass from publisher where publisher.email=emailid;
		 if(!strcmp(passwd,@pass))
			then
				update custommessage
                set custommessage.custommessage=concat('Welcome ',(select first_name from publisher where publisher.email=emailid))
                , custommessage.userid=(select publisherId from publisher where publisher.email=emailid)
                where id=1;
                select * from custommessage where id=1;
            else
				select * from custommessage where id=2;
            end if;
    else
		select * from custommessage where id=3;
end if;
end$$

DROP PROCEDURE IF EXISTS `ValidateUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ValidateUser`(IN `emailid` VARCHAR(40), IN `passwd` VARCHAR(40))
begin
if exists (select userid  from user where user.email=emailid)
	then
		select password into @pass from user where user.email=emailid;

		 if(!strcmp(passwd,@pass))
			then
				update custommessage
                set custommessage.custommessage=concat('Welcome ',(select first_name from user where user.email=emailid))
                , custommessage.userid=(select userid from user where user.email=emailid)
                where id=1;
                select * from custommessage where id=1;
            else
				select * from custommessage where id=2;
            end if;
    else
		select * from custommessage where id=3;
end if;
end$$

--
-- Functions
--
DROP FUNCTION IF EXISTS `CheckSubscription`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `CheckSubscription`( userid int, magid int) RETURNS int(11)
begin
	declare subscriptionVar int;
	select SubscriptionID into subscriptionVar from subscription where  subscription.userID=userid and  subscription.magazineID=magid;
	return subscriptionVar;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `custommessage`
--

DROP TABLE IF EXISTS `custommessage`;
CREATE TABLE IF NOT EXISTS `custommessage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `messagestatus` tinyint(1) DEFAULT NULL,
  `custommessage` varchar(40) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `dummysubscription`
--

DROP TABLE IF EXISTS `dummysubscription`;
CREATE TABLE IF NOT EXISTS `dummysubscription` (
  `SubscriptionID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `issues`
--

DROP TABLE IF EXISTS `issues`;
CREATE TABLE IF NOT EXISTS `issues` (
  `issueid` int(11) NOT NULL AUTO_INCREMENT,
  `magazineId` int(11) DEFAULT NULL,
  `fileId` varchar(250) DEFAULT NULL,
  `issueName` varchar(255) NOT NULL,
  `issueDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text,
  `fileName` varchar(255) DEFAULT NULL,
  `issueThumbnail` longblob NOT NULL,
  PRIMARY KEY (`issueid`),
  KEY `magazineId` (`magazineId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Table structure for table `magazines`
--

DROP TABLE IF EXISTS `magazines`;
CREATE TABLE IF NOT EXISTS `magazines` (
  `Magazineid` int(11) NOT NULL AUTO_INCREMENT,
  `MagazineName` varchar(50) DEFAULT NULL,
  `categoryId` int(11) DEFAULT NULL,
  `publisherId` int(11) DEFAULT NULL,
  `magazineThumbnail` longblob,
  `magazineDescription` text,
  `magazineFrequency` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Magazineid`),
  KEY `categoryId` (`categoryId`),
  KEY `publisherId` (`publisherId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `publisher`
--

DROP TABLE IF EXISTS `publisher`;
CREATE TABLE IF NOT EXISTS `publisher` (
  `publisherId` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) DEFAULT NULL,
  `password` char(40) DEFAULT NULL,
  `first_name` char(30) DEFAULT NULL,
  `last_name` char(30) DEFAULT NULL,
  `publicationCompany` varchar(255) NOT NULL,
  `creationTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `publicationName` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`publisherId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

DROP TABLE IF EXISTS `subscription`;
CREATE TABLE IF NOT EXISTS `subscription` (
  `SubscriptionID` int(13) NOT NULL AUTO_INCREMENT,
  `userID` int(13) DEFAULT NULL,
  `magazineID` int(13) DEFAULT NULL,
  PRIMARY KEY (`SubscriptionID`),
  KEY `magazineID` (`magazineID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `tempissueupload`
--

DROP TABLE IF EXISTS `tempissueupload`;
CREATE TABLE IF NOT EXISTS `tempissueupload` (
  `issueId` int(11) NOT NULL AUTO_INCREMENT,
  `magazineId` int(11) DEFAULT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `fileId` varchar(255) DEFAULT NULL,
  `isUpload` enum('Y','N') DEFAULT 'N',
  `description` text,
  `issueDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `issueName` varchar(255) NOT NULL,
  `issueThumbnail` longblob NOT NULL,
  PRIMARY KEY (`issueId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(40) DEFAULT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `creationTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `issues`
--
ALTER TABLE `issues`
  ADD CONSTRAINT `issues_ibfk_1` FOREIGN KEY (`magazineId`) REFERENCES `magazines` (`Magazineid`) ON DELETE CASCADE;

--
-- Constraints for table `magazines`
--
ALTER TABLE `magazines`
  ADD CONSTRAINT `magazines_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `magazines_ibfk_2` FOREIGN KEY (`publisherId`) REFERENCES `publisher` (`publisherId`) ON DELETE CASCADE;

--
-- Constraints for table `subscription`
--
ALTER TABLE `subscription`
  ADD CONSTRAINT `subscription_ibfk_1` FOREIGN KEY (`magazineID`) REFERENCES `magazines` (`Magazineid`),
  ADD CONSTRAINT `subscription_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `user` (`userid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
