-- MySQL Script generated by MySQL Workbench
-- Thu Aug 24 09:46:04 2017
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema restful
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema restful
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `restful` DEFAULT CHARACTER SET utf8 ;
USE `restful` ;

-- -----------------------------------------------------
-- Table `restful`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `restful`.`users` ;

CREATE TABLE IF NOT EXISTS `restful`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `created_at` DATETIME NULL,
  `update_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username` (`username` ASC),
  INDEX `user_created` (`created_at` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restful`.`article`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `restful`.`article` ;

CREATE TABLE IF NOT EXISTS `restful`.`article` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL,
  `content` TEXT NOT NULL,
  `users_id` INT NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `title` (`title` ASC),
  INDEX `fk_article_users_idx` (`users_id` ASC),
  INDEX `articel_created` (`created_at` ASC),
  CONSTRAINT `fk_article_users`
    FOREIGN KEY (`users_id`)
    REFERENCES `restful`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
