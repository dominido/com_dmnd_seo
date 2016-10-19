CREATE TABLE IF NOT EXISTS `#__dmnd_sitemap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(1024) NOT NULL,
  `lastmode` datetime NOT NULL,
  `changefreq` varchar(1024) NOT NULL,
  `priority` varchar(32) NOT NULL,

  `published` tinyint(4) DEFAULT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `publish_up` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

