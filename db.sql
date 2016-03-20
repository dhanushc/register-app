-- MySQL Workbench Forward Engineering DB ifest

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema ifestDB
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema ifestDB
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `ifestDB` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `ifestDB` ;

-- -----------------------------------------------------
-- Table `ifestDB`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ifestDB`.`user` (
  `iduser` INT NOT NULL,
  `userName` VARCHAR(45) NULL,
  `password` VARCHAR(250) NULL,
  PRIMARY KEY (`iduser`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `ifestDB`.`participant`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ifestDB`.`participant` (
  `idparticipant` INT NOT NULL,
  `firstName` VARCHAR(245) NULL,
  `lastName` VARCHAR(245) NULL,
  `email` VARCHAR(245) NULL,
  `contact` VARCHAR(45) NULL,
  `tshirtSize` VARCHAR(45) NULL,
  `university` VARCHAR(200) NULL,
  `studentRegNo` VARCHAR(145) NULL,
  `informedMethod` VARCHAR(45) NULL,
  PRIMARY KEY (`idparticipant`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
