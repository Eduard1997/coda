DELETE FROM menus WHERE id=54;
DELETE FROM menus WHERE id=55;
DELETE FROM menus WHERE id=49;
DELETE FROM menus WHERE id=56;
DELETE FROM menus WHERE id=14;
DELETE FROM menus WHERE id=15;
DELETE FROM menus WHERE id=16;
DELETE FROM menus WHERE id=33;
DELETE FROM menus WHERE id=34;
DELETE FROM menus WHERE id=35;
DELETE FROM menus WHERE id=37;
DELETE FROM menus WHERE id=38;
DELETE FROM menus WHERE id=39;
DELETE FROM menus WHERE id=40;
DELETE FROM menus WHERE id=43;
DELETE FROM menus WHERE id=47;
DELETE FROM menu_role WHERE menus_id=54;
DELETE FROM menu_role WHERE menus_id=55;
DELETE FROM menu_role WHERE menus_id=49;
DELETE FROM menu_role WHERE menus_id=56;
DELETE FROM menu_role WHERE menus_id=14;
DELETE FROM menu_role WHERE menus_id=15;
DELETE FROM menu_role WHERE menus_id=16;
DELETE FROM menu_role WHERE menus_id=33;
DELETE FROM menu_role WHERE menus_id=34;
DELETE FROM menu_role WHERE menus_id=35;
DELETE FROM menu_role WHERE menus_id=37;
DELETE FROM menu_role WHERE menus_id=38;
DELETE FROM menu_role WHERE menus_id=39;
DELETE FROM menu_role WHERE menus_id=40;
DELETE FROM menu_role WHERE menus_id=43;
DELETE FROM menu_role WHERE menus_id=47;
TRUNCATE TABLE notes;
DELETE FROM menus WHERE name LIKE 'Theme';
DELETE FROM menu_role WHERE menus_id=15;
DELETE FROM menu_role WHERE menus_id=16;
DELETE FROM `menus` WHERE `menus`.`id` = 48;
DELETE FROM `menu_role` WHERE `menu_role`.`id` = 48;
INSERT INTO `menus` (`id`, `name`, `href`, `icon`, `slug`, `parent_id`, `menu_id`, `sequence`) VALUES (NULL, 'Tasks', '/tasks', 'cil-task', 'link', NULL, '1', '1');
INSERT INTO `menu_role` (`id`, `role_name`, `menus_id`) VALUES (NULL, 'user', '69');
UPDATE `menus` SET `sequence` = '2' WHERE `menus`.`id` = 69;
DELETE FROM `menus` WHERE `menus`.`id` = 67;
DELETE FROM `menu_role` WHERE `menu_role`.`id` = 118;
DELETE FROM `menu_role` WHERE `menu_role`.`id` = 119;
INSERT INTO `menus` (`id`, `name`, `href`, `icon`, `slug`, `parent_id`, `menu_id`, `sequence`) VALUES (NULL, 'Notes', '/notes', 'cil-notes', 'link', NULL, '1', '3');
INSERT INTO `menu_role` (`id`, `role_name`, `menus_id`) VALUES (NULL, 'admin', '69');
INSERT INTO `menu_role` (`id`, `role_name`, `menus_id`) VALUES (121, 'user', 71), (122, 'admin', 71);
CREATE TABLE `coda_db`.`tasks` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `user_id` INT UNSIGNED NOT NULL , `text` TEXT NOT NULL , `priority` SMALLINT(10) NOT NULL COMMENT '1 - normal 2 - medium 3 - high' , `deadline` TIMESTAMP NULL , `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `tasks` ADD `title` VARCHAR(255) NOT NULL AFTER `user_id`;
INSERT INTO `menus` (`id`, `name`, `href`, `icon`, `slug`, `parent_id`, `menu_id`, `sequence`) VALUES (NULL, 'Messages', '/messages', 'cil-envelope-closed', 'link', NULL, '1', '3');
INSERT INTO `menu_role` (`id`, `role_name`, `menus_id`) VALUES (NULL, 'user', '72'), (NULL, 'admin', '72');
ALTER TABLE `tasks` CHANGE `deadline` `deadline` DATE NULL DEFAULT NULL;
CREATE TABLE `coda_db`.`messages` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `from_id` SMALLINT(50) UNSIGNED NOT NULL , `to_id` SMALLINT(50) UNSIGNED NOT NULL , `text` TEXT NOT NULL , `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `admin_updates` (
    `id` int(10) UNSIGNED NOT NULL,
    `message` text NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `admin_updates`
ADD PRIMARY KEY (`id`);
ALTER TABLE `admin_updates`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;
INSERT INTO `menus` (`id`, `name`, `href`, `icon`, `slug`, `parent_id`, `menu_id`, `sequence`) VALUES (NULL, 'Site updates', '/site-updates', 'cil-update', 'link', NULL, '1', '5');
INSERT INTO `menu_role` (`id`, `role_name`, `menus_id`) VALUES (NULL, 'admin', '73');
INSERT INTO `menu_role` (`id`, `role_name`, `menus_id`) VALUES (NULL, 'user', '73');
UPDATE `menus` SET `icon` = 'cil-cog' WHERE `menus`.`id` = 73;
ALTER TABLE `users` ADD `profile_picture` VARCHAR(255) NULL DEFAULT NULL AFTER `email_verified_at`;
DELETE FROM `menus` WHERE `menus`.`id` = 2;
DELETE FROM `menu_role` WHERE `menu_role`.`id` = 4;
DELETE FROM `menus` WHERE `menus`.`id` = 60;
DELETE FROM `menu_role` WHERE `menu_role`.`id` = 112;
