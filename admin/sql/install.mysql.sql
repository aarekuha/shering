drop table if exists `#__shering_cars`;
create table if not exists `#__shering_cars`
(
    `id`            int(5) unsigned NOT NULL AUTO_INCREMENT,
    `class`         tinyint(2) NOT NULL, -- 0 - Эконом, 1 - Комфорт, 2 - Бизнес
    `mark`          tinyint(2) NOT NULL, -- справочник
    `model`         tinyint(2) NOT NULL, -- справочник
    `year`          smallint(2) unsigned NOT NULL,
    `engine_type`   tinyint(2) NOT NULL, -- 0 - Бензин, 1 - Пропан, 2 - Метан, 3 - Дизель
    `engine_size`   tinyint(2) NOT NULL, -- справочник
    `transmission`  tinyint(2) NOT NULL, -- 0 - Механика, 1 - автомат
    `interior`      tinyint(2) NOT NULL, -- 0 - Велюр, 1 - Кожзам, 2 - Кожа
    `conditioner`   tinyint(2) NOT NULL, -- 0 - нет, 1 - есть
    `cost`          int(5) default 0,
    `images`        text,
    `car_number`    varchar(15) default "" not null,
    `status`        tinyint(2) default 0 not null,
    `color` 		tinyint(2) NOT NULL DEFAULT '0',
    `desc` 			text,
    primary key (`id`)
) engine=innodb;

drop table if exists `#__shering_marks`;
create table if not exists `#__shering_marks`
(
    `id`    tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(100) NOT NULL,
    primary key (`id`)
) engine=innodb;

drop table if exists `#__shering_models`;
create table if not exists `#__shering_models`
(
    `id`    tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(100) NOT NULL,
    `mark`  tinyint(2) not null,
    primary key (`id`)
) engine=innodb;

drop table if exists `#__shering_engine_sizes`;
create table if not exists `#__shering_engine_sizes`
(
    `id`    tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(100) NOT NULL,
    primary key (`id`)
) engine=innodb;

drop table if exists `#__shering_users`;
create table if not exists `#__shering_users`
(
    `id`                int(5) unsigned NOT NULL AUTO_INCREMENT,
    `fio`               varchar(255) NOT NULL,
    `tel`               varchar(10) NOT NULL,
    `password`          varchar(30) NOT NULL,
    `smscounter`        tinyint(1) NOT NULL,
    `status`            tinyint(1) NOT NULL, -- 0 - Не проверен, 1 - Проверен, 2 - Заблокирован
    `registration_date` date NOT NULL,
    `token`             varchar(20),
    primary key (`id`)
) engine=innodb;

drop table if exists `#__shering_criteria`;
create table if not exists `#__shering_criteria`
(
    `id`            int(5) unsigned NOT NULL AUTO_INCREMENT,
    `user_id`       int(5) unsigned NOT NULL,
    `class`         tinyint(2) NOT NULL default -1, -- 0 - Эконом, 1 - Комфорт, 2 - Бизнес
    `mark`          tinyint(2) NOT NULL default -1, -- справочник
    `model`         tinyint(2) NOT NULL default -1, -- справочник
    `year`          smallint(2) unsigned NOT NULL default 2000,
    `engine_type`   tinyint(2) NOT NULL default -1, -- 0 - Бензин, 1 - Пропан, 2 - Метан, 3 - Дизель
    `engine_size`   tinyint(2) NOT NULL default -1, -- справочник
    `transmission`  tinyint(2) NOT NULL default -1, -- 0 - Механика, 1 - автомат
    `interior`      tinyint(2) NOT NULL default -1, -- 0 - Велюр, 1 - Кожзам, 2 - Кожа
    `conditioner`   tinyint(2) NOT NULL default -1, -- 0 - нет, 1 - есть
    `cost`          int(5) default 0,
    `creation_date` date NOT NULL,
    `deleted`       tinyint(2) default 0 not null,
    `car_id`        int(5),
    primary key (`id`)
) engine=innodb;

drop table if exists `#__shering_sms`;
create table if not exists `#__shering_sms`
(
    `id`        int(5) unsigned NOT NULL AUTO_INCREMENT,
    `user_id`   int(5) unsigned NOT NULL,
    `car_id`    int(5) unsigned NOT NULL,
    `send_date` date NOT NULL,
    primary key (`id`)
) engine=innodb;

drop table if exists `#__shering_colors`;
create table if not exists `#__shering_colors`
(
    `id`        tinyint(2) NOT NULL AUTO_INCREMENT,
    `name`   	varchar(50),
    `value`     varchar(6),
    primary key (`id`)
) engine=innodb;
