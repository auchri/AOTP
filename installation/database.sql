CREATE TABLE IF NOT EXISTS `projects` (
  `id`          int(11)      NOT NULL,
  `admin`       int(11)      NOT NULL,
  `name`        varchar(255) NOT NULL,
  `description` text         NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `users` (
  `id`        int(11)      NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname`  varchar(255) NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

ALTER TABLE `projects`
ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
ADD PRIMARY KEY (`id`);

ALTER TABLE `projects`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;