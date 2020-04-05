-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema fin_missa
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `typesIntention`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `typesIntention` (
  `id_type_intention` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL COMMENT 'Title of intentions Eg: \"In action of grace\", \"by the 7th day of death\"',
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id_type_intention`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cash`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cash` (
  `id_cash` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `amount` DECIMAL(14,2) NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id_cash`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `typesMass`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `typesMass` (
  `id_type_mass` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL,
  `hour` TIME NOT NULL,
  `mass_special` TINYINT NULL DEFAULT 0,
  `date` DATE NULL COMMENT 'Special masses have a mandatory date',
  `price` DECIMAL(5,2) NULL DEFAULT 0,
  `enable` TINYINT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id_type_mass`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `masses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `masses` (
  `id_mass` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_type_mass` INT UNSIGNED NOT NULL,
  `id_type_intention` INT UNSIGNED NOT NULL,
  `id_cash` INT UNSIGNED NOT NULL,
  `faithful` VARCHAR(255) NOT NULL,
  `date` DATE NOT NULL,
  `amount_paid` DECIMAL(7,2) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id_mass`),
  INDEX `fk_mass_intentions1_idx` (`id_type_intention` ASC),
  INDEX `fk_mass_cash1_idx` (`id_cash` ASC),
  INDEX `fk_mass_typesMass1_idx` (`id_type_mass` ASC),
  CONSTRAINT `fk_mass_intentions1`
    FOREIGN KEY (`id_type_intention`)
    REFERENCES `typesIntention` (`id_type_intention`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_mass_cash1`
    FOREIGN KEY (`id_cash`)
    REFERENCES `cash` (`id_cash`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_mass_typesMass1`
    FOREIGN KEY (`id_type_mass`)
    REFERENCES `typesMass` (`id_type_mass`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB
COMMENT = 'Masses with requests from the faithful';


-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `login` VARCHAR(45) NOT NULL,
  `passwd` VARCHAR(255) NOT NULL,
  `photo` VARCHAR(255) NULL,
  `level` TINYINT(1) NOT NULL COMMENT 'Level 1 = Priest\nLevel 2 = Secretary',
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE INDEX `login_UNIQUE` (`login` ASC))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `typesIntention`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `typesIntention` (`id_type_intention`, `title`, `created_at`, `updated_at`) VALUES (DEFAULT, 'Em Louvor', NULL, NULL);
INSERT INTO `typesIntention` (`id_type_intention`, `title`, `created_at`, `updated_at`) VALUES (DEFAULT, 'Em Ação de Graças', NULL, NULL);
INSERT INTO `typesIntention` (`id_type_intention`, `title`, `created_at`, `updated_at`) VALUES (DEFAULT, 'Em Ação de Graças pelo Aniversário de', NULL, NULL);
INSERT INTO `typesIntention` (`id_type_intention`, `title`, `created_at`, `updated_at`) VALUES (DEFAULT, 'Em Louvor ao Anjo da Guarda de', NULL, NULL);
INSERT INTO `typesIntention` (`id_type_intention`, `title`, `created_at`, `updated_at`) VALUES (DEFAULT, 'Por Intenção', NULL, NULL);
INSERT INTO `typesIntention` (`id_type_intention`, `title`, `created_at`, `updated_at`) VALUES (DEFAULT, 'Em Ação de Graças pelo Dom da Saúde de', NULL, NULL);
INSERT INTO `typesIntention` (`id_type_intention`, `title`, `created_at`, `updated_at`) VALUES (DEFAULT, 'Falecimento do Dia', NULL, NULL);
INSERT INTO `typesIntention` (`id_type_intention`, `title`, `created_at`, `updated_at`) VALUES (DEFAULT, '7º Dia', NULL, NULL);
INSERT INTO `typesIntention` (`id_type_intention`, `title`, `created_at`, `updated_at`) VALUES (DEFAULT, '1º Mês de Falecimento', NULL, NULL);
INSERT INTO `typesIntention` (`id_type_intention`, `title`, `created_at`, `updated_at`) VALUES (DEFAULT, '1º Ano de Falecimento', NULL, NULL);
INSERT INTO `typesIntention` (`id_type_intention`, `title`, `created_at`, `updated_at`) VALUES (DEFAULT, 'Pelas Irmãs e Irmãos Falecidos', NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `cash`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `cash` (`id_cash`, `name`, `amount`, `created_at`, `updated_at`) VALUES (1, 'Intenções Dinheiro', 0, '2020-01-01 00:00', NULL);
INSERT INTO `cash` (`id_cash`, `name`, `amount`, `created_at`, `updated_at`) VALUES (DEFAULT, 'Intenções Cartão', 0, '2020-01-01', NULL);
INSERT INTO `cash` (`id_cash`, `name`, `amount`, `created_at`, `updated_at`) VALUES (DEFAULT, 'Padrinhamento', 0, '2020-01-01 00:00', NULL);
INSERT INTO `cash` (`id_cash`, `name`, `amount`, `created_at`, `updated_at`) VALUES (DEFAULT, 'Doações', 0, '2020-01-01', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `users`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `users` (`id_user`, `name`, `login`, `passwd`, `photo`, `level`, `created_at`, `updated_at`) VALUES (1, 'Administrador', 'admin', '$2y$10$tQWuRcnu23DXW3Yn2DaW1.SiHPHLKXTsobc5UdVcW0tobi6..XvaK', '', 1, '2020-04-04 19:38:03', '2020-04-04 19:38:03');

COMMIT;

