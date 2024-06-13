-- Adminer 4.2.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `entrees`;
CREATE TABLE `entrees` (
                           `id` int(11) NOT NULL AUTO_INCREMENT,
                           `nom` varchar(128) NOT NULL,
                           `prenom` varchar(128) DEFAULT NULL,
                           `nbureau` int(4) DEFAULT NULL,
                           `tel_mobile` varchar(12) DEFAULT NULL,
                           `tel_fixe` varchar(12) DEFAULT NULL,
                           `email` varchar(128) DEFAULT NULL,
                           `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                           `updated_at` timestamp NULL DEFAULT NULL,
                           PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS departement;
CREATE TABLE departement (
                             `id` int(11) NOT NULL AUTO_INCREMENT,
                             `nom` varchar(128) NOT NULL,
                             PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `entrees2departement`;
CREATE TABLE entrees2departement (
                                     `id_entrees` int(11) NOT NULL,
                                     `id_departement` int(11) NOT NULL,
                                     PRIMARY KEY (`id_departement`, `id_entrees`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;