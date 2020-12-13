

CREATE TABLE `categories` (
  `idCategorie` int(10) UNSIGNED ZEROFILL NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `idUser` int(10) UNSIGNED ZEROFILL NOT NULL,
  `idPost` int(10) UNSIGNED ZEROFILL NOT NULL,
  `idComment` int(10) UNSIGNED ZEROFILL NOT NULL,
  `date` datetime NOT NULL,
  `text` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `followers`
--

CREATE TABLE `followers` (
  `id_user` int(10) UNSIGNED ZEROFILL NOT NULL,
  `id_follower` int(10) UNSIGNED ZEROFILL NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes`
--

CREATE TABLE `likes` (
  `Users_idUsers` int(10) UNSIGNED ZEROFILL NOT NULL,
  `Posts_idPost` int(10) UNSIGNED ZEROFILL NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `idNotification` int(10) UNSIGNED ZEROFILL NOT NULL,
  `message` varchar(150) NOT NULL,
  `date` datetime NOT NULL,
  `Users_idUsers` int(10) UNSIGNED ZEROFILL NOT NULL,
  `image_path` varchar(200) NOT NULL,
  `readed` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE `posts` (
  `idPost` int(10) UNSIGNED ZEROFILL NOT NULL,
  `image_path` varchar(45) NOT NULL,
  `title` varchar(55) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `date_create` datetime NOT NULL,
  `price` int(6) DEFAULT NULL,
  `Category` int(10) UNSIGNED ZEROFILL NOT NULL,
  `Users_idUsers` int(10) UNSIGNED ZEROFILL NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `idUsers` int(10) UNSIGNED ZEROFILL NOT NULL,
  `email` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `role` int(1) NOT NULL,
  `user_name` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_photo` varchar(250) NOT NULL,
  `user_premium` int(1) NOT NULL,
  `biography` varchar(160) DEFAULT NULL,
  `location` varchar(50) NOT NULL,
  `instagram` varchar(150) DEFAULT NULL,
  `facebook` varchar(150) DEFAULT NULL,
  `twitter` varchar(150) DEFAULT NULL,
  `entry_date` datetime NOT NULL,
  `image_layout` varchar(200) NOT NULL,
  `web` varchar(175) DEFAULT NULL,
  `about` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`idCategorie`);

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`idComment`),
  ADD KEY `fk_Users_has_Posts1_Posts1_idx` (`idPost`),
  ADD KEY `fk_Users_has_Posts1_Users1_idx` (`idUser`);

--
-- Indices de la tabla `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id_user`,`id_follower`),
  ADD KEY `fk_Users_has_Users_Users2_idx` (`id_follower`),
  ADD KEY `fk_Users_has_Users_Users1_idx` (`id_user`);

--
-- Indices de la tabla `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`Users_idUsers`,`Posts_idPost`),
  ADD KEY `fk_Users_has_Posts_Posts1_idx` (`Posts_idPost`),
  ADD KEY `fk_Users_has_Posts_Users1_idx` (`Users_idUsers`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`idNotification`),
  ADD UNIQUE KEY `idNotification_UNIQUE` (`idNotification`),
  ADD KEY `fk_Notifications_Users1_idx` (`Users_idUsers`);

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`idPost`,`Users_idUsers`),
  ADD UNIQUE KEY `idPost_UNIQUE` (`idPost`),
  ADD KEY `fk_Posts_Categories1_idx` (`Category`),
  ADD KEY `fk_Posts_Users1_idx` (`Users_idUsers`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUsers`),
  ADD UNIQUE KEY `idUsuario_UNIQUE` (`idUsers`),
  ADD UNIQUE KEY `user_name_UNIQUE` (`user_name`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `idCategorie` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `idComment` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `notifications`
--
ALTER TABLE `notifications`
  MODIFY `idNotification` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `idPost` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `idUsers` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_Users_has_Posts1_Posts1` FOREIGN KEY (`idPost`) REFERENCES `posts` (`idPost`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Users_has_Posts1_Users1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUsers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `fk_Users_has_Users_Users1` FOREIGN KEY (`id_user`) REFERENCES `users` (`idUsers`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Users_has_Users_Users2` FOREIGN KEY (`id_follower`) REFERENCES `users` (`idUsers`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `fk_Users_has_Posts_Posts1` FOREIGN KEY (`Posts_idPost`) REFERENCES `posts` (`idPost`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Users_has_Posts_Users1` FOREIGN KEY (`Users_idUsers`) REFERENCES `users` (`idUsers`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_Notifications_Users1` FOREIGN KEY (`Users_idUsers`) REFERENCES `users` (`idUsers`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_Posts_Categories1` FOREIGN KEY (`Category`) REFERENCES `categories` (`idCategorie`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Posts_Users1` FOREIGN KEY (`Users_idUsers`) REFERENCES `users` (`idUsers`) ON DELETE NO ACTION ON UPDATE NO ACTION;

