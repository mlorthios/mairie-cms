/*
 Navicat Premium Data Transfer

 Source Server         : MacServer
 Source Server Type    : MySQL
 Source Server Version : 100311
 Source Host           : localhost:3306
 Source Schema         : mairie

 Target Server Type    : MySQL
 Target Server Version : 100311
 File Encoding         : 65001

 Date: 09/01/2019 11:49:08
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for banners
-- ----------------------------
DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners` (
  `image` text DEFAULT NULL,
  `placement` enum('left','right') DEFAULT NULL,
  `active` enum('0','1') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of banners
-- ----------------------------
BEGIN;
INSERT INTO `banners` VALUES ('/public/img/uploads/fde13048ebe940c6a70132c9da80aed1.png', 'left', '1');
INSERT INTO `banners` VALUES ('/public/img/uploads/122891d793413ed73eaa41da3c33d9f4.png', 'right', '1');
COMMIT;

-- ----------------------------
-- Table structure for events
-- ----------------------------
DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `date_event` date DEFAULT NULL,
  `image` text DEFAULT NULL,
  `url` text DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of events
-- ----------------------------
BEGIN;
INSERT INTO `events` VALUES (4, 1, 'Ouverture du site', 'Ceci est une description', '2019-01-07 11:19:54', '<p><span style=\"background-color: rgb(255, 255, 0);\">test</span></p>', '2019-01-16', '/public/img/uploads/4c7b8dcb7443f1f92d4f92833cdda68e.png', '2468-ouverture-du-site');
COMMIT;

-- ----------------------------
-- Table structure for groups
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of groups
-- ----------------------------
BEGIN;
INSERT INTO `groups` VALUES (1, 'Administrateur', 1);
INSERT INTO `groups` VALUES (2, 'Invité', 1539934246);
COMMIT;

-- ----------------------------
-- Table structure for logs
-- ----------------------------
DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `log` varchar(2555) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Table structure for logs_logins
-- ----------------------------
DROP TABLE IF EXISTS `logs_logins`;
CREATE TABLE `logs_logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `status` enum('error','success') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for messages
-- ----------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `message` varchar(2555) DEFAULT NULL,
  `type` enum('info','warning','defile') DEFAULT NULL,
  `fullpage` enum('0','1') DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of messages
-- ----------------------------
BEGIN;
INSERT INTO `messages` VALUES (1, 12, 'Ouverture du portail &quot;familles&quot;', 'defile', '0', '2018-10-17 09:40:14');
COMMIT;

-- ----------------------------
-- Table structure for navigator
-- ----------------------------
DROP TABLE IF EXISTS `navigator`;
CREATE TABLE `navigator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of navigator
-- ----------------------------
BEGIN;
INSERT INTO `navigator` VALUES (1, 1, 'Vie Pratique', 'fas fa-monument');
INSERT INTO `navigator` VALUES (2, 2, 'Vie Municipale', 'fas fa-shield');
INSERT INTO `navigator` VALUES (3, 3, 'Vie Éducative', 'fas fa-child');
INSERT INTO `navigator` VALUES (4, 4, 'Calendrier des fêtes', 'fas fa-calendar-alt');
INSERT INTO `navigator` VALUES (5, 5, 'Vie Associative', 'fas fa-hands-helping');
INSERT INTO `navigator` VALUES (6, 6, 'Vos Démarches', 'fas fa-briefcase');
INSERT INTO `navigator` VALUES (7, 7, 'Salles Municipales', 'fas fa-map-marker-alt');
INSERT INTO `navigator` VALUES (8, 8, 'Médiathèque', 'fas fa-desktop');
INSERT INTO `navigator` VALUES (9, 9, 'Marchés Publics', 'fas fa-exclamation-triangle');
COMMIT;

-- ----------------------------
-- Table structure for news
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `attach` text DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of news
-- ----------------------------
BEGIN;
INSERT INTO `news` VALUES (1, NULL, 'Ouverture du site', 'Nous avons le plaisir de vous présenter notre nouveau site', 'Bla bla bla', '/public/img/uploads/ad4975a992dd834353e53b16e9fa6d02.png', NULL, '2018-10-02 10:17:47', '6806-ouverture-du-site');
COMMIT;

-- ----------------------------
-- Table structure for newsletter
-- ----------------------------
DROP TABLE IF EXISTS `newsletter`;
CREATE TABLE `newsletter` (
  `active` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of newsletter
-- ----------------------------
BEGIN;
INSERT INTO `newsletter` VALUES ('1');
COMMIT;

-- ----------------------------
-- Table structure for newsletter_registered
-- ----------------------------
DROP TABLE IF EXISTS `newsletter_registered`;
CREATE TABLE `newsletter_registered` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of newsletter_registered
-- ----------------------------
BEGIN;
INSERT INTO `newsletter_registered` VALUES (1, 'admin@admin.fr', '::1', '2018-10-04 09:59:42');
INSERT INTO `newsletter_registered` VALUES (2, 'test@test.fr', '::1', '2018-10-17 16:00:00');
INSERT INTO `newsletter_registered` VALUES (3, 't@g.fr', '::1', '2018-10-18 12:11:14');
COMMIT;

-- ----------------------------
-- Table structure for pages
-- ----------------------------
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) DEFAULT 0,
  `navigator_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `attach` varchar(2555) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of pages
-- ----------------------------
BEGIN;
INSERT INTO `pages` VALUES (1, 1, 1, 'Histoire', '<p><img src=\"/public/img/uploads/f3384cae7d44803499f6937348539359.png\" style=\"width: 25%;\">po</p>', NULL, '1997-histoire', 'Histoire de la ville d\'Audruicq');
INSERT INTO `pages` VALUES (2, 2, 1, 'Infos - Situation', '<h3 style=\"text-align: center; \"><span style=\"background-color: rgb(255, 255, 0);\">Ceci est un test</span></h3>', NULL, '4829-infos-situation', NULL);
INSERT INTO `pages` VALUES (3, 3, 1, 'Commerces', 'test page', NULL, '8313-commerces', NULL);
INSERT INTO `pages` VALUES (4, 4, 1, 'Services publics', 'test page', NULL, '2766-services-publics', NULL);
INSERT INTO `pages` VALUES (5, 5, 1, 'Cimetières', 'test page', NULL, '1666-cimeti-eres', NULL);
INSERT INTO `pages` VALUES (6, 6, 1, 'Services d\'urgences et de soins', 'test page', NULL, '6201-services-durgences-et-de-soins', NULL);
INSERT INTO `pages` VALUES (7, 7, 1, 'Les Transports', 'test page', NULL, '4425-les-transports', NULL);
INSERT INTO `pages` VALUES (8, 1, 2, 'Le Conseil Municipal', 'test page', NULL, '6864-le-conseil-municipal', 'municipal');
INSERT INTO `pages` VALUES (9, 2, 2, 'Police Municipale', '<p><img src=\"https://dunhamweb.com/wp-content/uploads/banner-sample.png\" style=\"width: 650px;\">test page</p>', NULL, '3032-police-municipale', NULL);
INSERT INTO `pages` VALUES (10, 3, 2, 'Comptes rendus de CM', 'test page', NULL, '5130-comptes-rendus-de-cm', NULL);
INSERT INTO `pages` VALUES (11, 1, 3, 'Les écoles', 'test page', NULL, '1432-les-ecoles', NULL);
INSERT INTO `pages` VALUES (12, 2, 3, 'Restaurant scolaire', 'test page', NULL, '8035-restaurant-scolaire', NULL);
INSERT INTO `pages` VALUES (13, 3, 3, 'Enfance et Jeunesse', 'test page', NULL, '7580-enfance-et-jeunesse', NULL);
INSERT INTO `pages` VALUES (14, 4, 3, 'Garderie périscolaire', 'test page', NULL, '6729-garderie-periscolaire', NULL);
INSERT INTO `pages` VALUES (15, 1, 4, 'Calendrier des fêtes', '<iframe src=\"https://www.google.com/calendar/embed?src=mairie.audruicq%40gmail.com&amp;ctz=Europe/Paris\" style=\"border: 0; height: 500px; width: 100%\" frameborder=\"0\" scrolling=\"no\"></iframe>', NULL, '5259-calendrier-des-f-etes', NULL);
INSERT INTO `pages` VALUES (16, 1, 5, 'Vie Associative', '<p style=\"text-align: center; \">Découvrez dès maintenant la vie associative !</p>', NULL, '1103-vie-associative', NULL);
INSERT INTO `pages` VALUES (17, 1, 6, 'Pièce d\'identité', 'test page', NULL, '3090-pi-ece-didentite', NULL);
INSERT INTO `pages` VALUES (18, 2, 6, 'Service National', 'test page', NULL, '1604-service-national', NULL);
INSERT INTO `pages` VALUES (19, 3, 6, 'Élections-Population', 'test page', NULL, '8415-elections-population', NULL);
INSERT INTO `pages` VALUES (20, 4, 6, 'Demande de médaille', 'test page', NULL, '8835-demande-de-medaille', NULL);
INSERT INTO `pages` VALUES (21, 5, 6, 'État Civil', 'test page', NULL, '2171-etat-civil', NULL);
INSERT INTO `pages` VALUES (22, 6, 6, 'Urbanisme', 'test page', NULL, '7965-urbanisme', NULL);
INSERT INTO `pages` VALUES (23, 1, 7, 'Espace Pierre Desmidt', 'test page', NULL, '1159-espace-pierre-desmidt', NULL);
INSERT INTO `pages` VALUES (24, 2, 7, 'COSEC', 'test page', NULL, '4089-cosec', NULL);
INSERT INTO `pages` VALUES (25, 3, 7, 'Salle Polyvalente', 'test page', NULL, '2252-salle-polyvalente', NULL);
INSERT INTO `pages` VALUES (26, 4, 7, 'Maison des associations', 'test page', NULL, '8459-maison-des-associations', NULL);
INSERT INTO `pages` VALUES (27, 5, 7, 'Salle du Calaises', 'test page', NULL, '3603-salle-du-calaises', NULL);
INSERT INTO `pages` VALUES (28, 6, 7, 'Salle Vercoutre', 'test page', NULL, '4801-salle-vercoutre', NULL);
INSERT INTO `pages` VALUES (29, 7, 7, 'Salle du Brédenarde', 'test page', NULL, '6759-salle-du-bredenarde', NULL);
INSERT INTO `pages` VALUES (30, 8, 7, 'Salle Paroissiale', 'test page', NULL, '1205-salle-paroissiale', NULL);
INSERT INTO `pages` VALUES (31, 1, 8, 'Médiathèque', 'test page', NULL, '8549-mediath-eque', NULL);
INSERT INTO `pages` VALUES (33, 1, 9, 'Marchés Publics', '<p><img src=\"https://dunhamweb.com/wp-content/uploads/banner-sample.png\" style=\"width: 650px;\"><br></p>', NULL, '2828-marches-publics', NULL);
INSERT INTO `pages` VALUES (34, 0, 10, 'rerere', '<p>rerere</p>', NULL, '8511-rerere', NULL);
INSERT INTO `pages` VALUES (35, 0, 10, 'rttr', '<p>rtrt</p>', NULL, '4981-rttr', NULL);
INSERT INTO `pages` VALUES (36, 0, 10, 'Test', '<p>test desc</p>', NULL, '1812-test', 'test description');
COMMIT;

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `permission_admin_access` enum('0','1') DEFAULT '0',
  `permission_admin_pages` enum('0','1') DEFAULT '0',
  `permission_admin_events` enum('0','1') DEFAULT '0',
  `permission_admin_news` enum('0','1') DEFAULT '0',
  `permission_admin_messages` enum('0','1') DEFAULT '0',
  `permission_admin_banners` enum('0','1') DEFAULT '0',
  `permission_admin_newsletter` enum('0','1') DEFAULT '0',
  `permission_admin_users` enum('0','1') DEFAULT '0',
  `permission_admin_permissions` enum('0','1') DEFAULT '0',
  `permission_admin_maintenance` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of permissions
-- ----------------------------
BEGIN;
INSERT INTO `permissions` VALUES (1, 1, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `permissions` VALUES (2, 2, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
COMMIT;

-- ----------------------------
-- Table structure for todo_list
-- ----------------------------
DROP TABLE IF EXISTS `todo_list`;
CREATE TABLE `todo_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `content` varchar(2555) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `done` enum('0','1') DEFAULT NULL,
  `done_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of todo_list
-- ----------------------------
BEGIN;
INSERT INTO `todo_list` VALUES (24, 1, 'Désactivé le message d\'information demain', '2018-09-26 16:15:49', '1', '2018-09-26 16:15:56');
INSERT INTO `todo_list` VALUES (25, 1, 'Bienvenue', '2018-09-26 16:16:12', '0', '2018-10-10 14:39:51');
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `avatar` varchar(2555) DEFAULT '/public/img/avatars/default.png',
  `registration_date` datetime DEFAULT NULL,
  `last_connection` datetime DEFAULT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `disabled` enum('0','1') DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES (1, 'Mathis', 'Lorthios', '7629ce60dfef546566f2ddce905a7e0014f830d76a1160f05e79bcb90a07da2a4076ac27a49194c50ebee47f35c183aca2d58ad606b5468722b151056b9f6bc3', 'admin@admin.fr', 1, 'https://t.facdn.net/15430507@400-1420800644.jpg', NULL, NULL, NULL, '0');
INSERT INTO `users` VALUES (2, 'Karine', 'Vilcocq', 'e76ff10aba29927db6ce09207a20644d9e29ab33a77e61baf70cd85eecf952463288a14dec2bfa25edc7132a3df7ebc598bc01b61ee216a71ee61c941c2be76b', 'kvilcocq@ville-audruicq.fr', 1, '/public/img/avatars/default.png', '2018-10-19 09:37:40', NULL, NULL, '0');
COMMIT;

-- ----------------------------
-- Table structure for visitors
-- ----------------------------
DROP TABLE IF EXISTS `visitors`;
CREATE TABLE `visitors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of visitors
-- ----------------------------
BEGIN;
INSERT INTO `visitors` VALUES (1, '::1', '2018-09-26');
INSERT INTO `visitors` VALUES (2, '::1', '2018-09-27');
INSERT INTO `visitors` VALUES (3, '::1', '2018-09-28');
INSERT INTO `visitors` VALUES (4, '::1', '2018-10-01');
INSERT INTO `visitors` VALUES (5, '::1', '2018-10-02');
INSERT INTO `visitors` VALUES (6, '::1', '2018-10-03');
INSERT INTO `visitors` VALUES (7, '::1', '2018-10-04');
INSERT INTO `visitors` VALUES (8, '::1', '2018-10-05');
INSERT INTO `visitors` VALUES (9, '::1', '2018-10-08');
INSERT INTO `visitors` VALUES (10, '::1', '2018-10-09');
INSERT INTO `visitors` VALUES (11, '::1', '2018-10-10');
INSERT INTO `visitors` VALUES (12, '::1', '2018-10-11');
INSERT INTO `visitors` VALUES (13, '::1', '2018-10-12');
INSERT INTO `visitors` VALUES (14, '::1', '2018-10-15');
INSERT INTO `visitors` VALUES (15, '::1', '2018-10-16');
INSERT INTO `visitors` VALUES (16, '::1', '2018-10-17');
INSERT INTO `visitors` VALUES (17, '::1', '2018-10-18');
INSERT INTO `visitors` VALUES (18, '::1', '2018-10-19');
INSERT INTO `visitors` VALUES (19, '192.168.1.55', '2018-10-19');
INSERT INTO `visitors` VALUES (20, '127.0.0.1', '2018-12-26');
INSERT INTO `visitors` VALUES (21, '127.0.0.1', '2019-01-06');
INSERT INTO `visitors` VALUES (22, '127.0.0.1', '2019-01-07');
INSERT INTO `visitors` VALUES (23, '127.0.0.1', '2019-01-08');
INSERT INTO `visitors` VALUES (24, '127.0.0.1', '2019-01-09');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
