# phpMyAdmin MySQL-Dump
# version 2.8.2.4
# http://www.phpmyadmin.net/ (download page)
#
# Server: localhost
# Date: Jun 21, 2009 at 12:09 AM
# Version: 5.0.45
# Version PHP: 5.2.3
# Version Xoops: Xoops 2.3
# --------------------------------------------------------

# 
# Table structure for table `gallery_category`
# 

CREATE TABLE `gallery_category` (
  `cat_id` int(5) unsigned NOT NULL auto_increment,
  `cat_pid` int(11) NOT NULL default '0',
  `cat_name` text NOT NULL,
  `cat_thumb` text NOT NULL,
  `cat_link` text NOT NULL,
  `cat_hits` int(11) NOT NULL default '0',
  `cat_banner` int(10) default NULL,
  `cat_description` text,
  `cat_date` date NOT NULL,
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# 
# Table structure for table `gallery_collection`
# 

CREATE TABLE `gallery_collection` (
  `coll_id` int(11) unsigned NOT NULL auto_increment,
  `coll_lid` int(11) NOT NULL,
  `coll_name` text character set utf8 NOT NULL,
  `coll_thumb` text character set utf8 NOT NULL,
  `coll_link` text character set utf8 NOT NULL,
  `coll_date` int(10) NOT NULL,
  `coll_hits` int(11) unsigned NOT NULL default '0',
  `coll_banner` int(5) default NULL,
  `coll_description` text character set utf8,
  PRIMARY KEY  (`coll_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# 
# Table structure for table `gallery_banners`
# 

CREATE TABLE `gallery_banners` (
  `ban_id` int(5) unsigned NOT NULL auto_increment,
  `ban_name` text NOT NULL,
  `ban_image` text,
  `ban_link` text,
  `ban_date` int(10) NOT NULL,
  PRIMARY KEY  (`ban_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;