SET FOREIGN_KEY_CHECKS=0;

        DROP TABLE IF EXISTS `lobbys_users`, `lobbys`, `chat_messages`, `users`;

        SET FOREIGN_KEY_CHECKS=1;

        CREATE TABLE IF NOT EXISTS `users` (
        user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        steam_id INT,
        /* DELETE USERNAME AND PW BEFORE DEPLOYING */
        username VARCHAR(255),
        password VARCHAR(255),
        age VARCHAR(10),
        /* admin, mod, blacklisted, default */
        role VARCHAR(255),
        rank VARCHAR(255),
        upvotes INT DEFAULT 0,
        downvotes INT DEFAULT 0,
        language_one VARCHAR(255),
        language_two VARCHAR(255),
        language_three VARCHAR(255),
        created DATETIME DEFAULT NULL,
        modified DATETIME DEFAULT NULL
        );

        CREATE TABLE IF NOT EXISTS `chat_messages` (
        message_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        sent_by INT UNSIGNED NOT NULL,
        message VARCHAR(255) NOT NULL,
        created DATETIME DEFAULT NULL,
        FOREIGN KEY (sent_by) REFERENCES users(user_id) ON DELETE CASCADE
        );

        CREATE TABLE IF NOT EXISTS `lobbys` (
        lobby_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        owned_by INT UNSIGNED NOT NULL,
        free_slots INT DEFAULT 4,
        url VARCHAR(255) NOT NULL,
        created DATETIME DEFAULT NULL,
        modified DATETIME DEFAULT NULL,
        FOREIGN KEY (owned_by) REFERENCES users(user_id) ON DELETE CASCADE
        );

        CREATE TABLE IF NOT EXISTS `lobbys_users` (
        lobbys_users_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        lobby_id INT UNSIGNED,
        user_id INT UNSIGNED,
        FOREIGN KEY (lobby_id) REFERENCES lobbys(lobby_id) ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
        );

        /* INIT SCRIPT */
        /* INSERT REQUIRED DATA HERE TO SETUP THE APPLICATION */

        /* TEST DATA */
        INSERT INTO `users` (username, password, age, role, rank, upvotes, downvotes, language_one, language_two, language_three) VALUES ('user0', '$2y$10$rSAzv08D1E9yhu8JV4bCIOf2rV6wwt5BP0ZKWiCpw.uKRRVGZ56ei', 16, 'default', 'MGE', 2, 10, 'english', 'german', 'russian');
        INSERT INTO `users` (username, password, role) VALUES ('user1', '$2y$10$rSAzv08D1E9yhu8JV4bCIOf2rV6wwt5BP0ZKWiCpw.uKRRVGZ56ei', 'default');
        INSERT INTO `users` (username, password, role) VALUES ('user2', '$2y$10$rSAzv08D1E9yhu8JV4bCIOf2rV6wwt5BP0ZKWiCpw.uKRRVGZ56ei', 'default');
        INSERT INTO `users` (username, password, role) VALUES ('user3', '$2y$10$rSAzv08D1E9yhu8JV4bCIOf2rV6wwt5BP0ZKWiCpw.uKRRVGZ56ei', 'default');
        INSERT INTO `users` (username, password, role) VALUES ('admin1', '$2y$10$rSAzv08D1E9yhu8JV4bCIOf2rV6wwt5BP0ZKWiCpw.uKRRVGZ56ei', 'admin');
        INSERT INTO `users` (username, password, role) VALUES ('mod1', '$2y$10$rSAzv08D1E9yhu8JV4bCIOf2rV6wwt5BP0ZKWiCpw.uKRRVGZ56ei', 'mod');

        INSERT INTO `lobbys` (owned_by, url) VALUES (1, 'test');
        INSERT INTO `lobbys` (owned_by, url) VALUES (2, 'test2');

        INSERT INTO `lobbys_users` (lobby_id, user_id) VALUES (1,1);
        INSERT INTO `lobbys_users` (lobby_id, user_id) VALUES (1,2);
        INSERT INTO `lobbys_users` (lobby_id, user_id) VALUES (2,1);
        INSERT INTO `lobbys_users` (lobby_id, user_id) VALUES (2,2);
        INSERT INTO `lobbys_users` (lobby_id, user_id) VALUES (2,3);
        INSERT INTO `lobbys_users` (lobby_id, user_id) VALUES (2,4);
        INSERT INTO `lobbys_users` (lobby_id, user_id) VALUES (2,5);

        INSERT INTO `chat_messages` (sent_by, message) VALUES (1, 'Hi');
        INSERT INTO `chat_messages` (sent_by, message) VALUES (2, 'Hi there.');

