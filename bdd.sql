CREATE TABLE IF NOT EXISTS `users` (
    `id` int NOT NULL AUTO_INCREMENT,
    `lastName` varchar(200) NOT NULL,
    `firstName` varchar(200) NOT NULL,
    `username` VARCHAR(200) NOT NULL,
    `email` varchar(200) NOT NULL,
    `phone` varchar(100) NOT NULL,
    `birthdate` date NOT NULL,
    `password` varchar(200) NOT NULL,
    `role` enum('acheteur','vendeur','admin','') NOT NULL DEFAULT 'acheteur',
    `avatar` varchar(200) NOT NULL,
    `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_modif` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `actif` int NOT NULL DEFAULT '1',
    PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `messages` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `sender_id` INT NOT NULL,       -- L'utilisateur qui envoie le message
    `receiver_id` INT NOT NULL,     -- L'utilisateur qui reçoit le message
    `message` TEXT NOT NULL,        -- Contenu du message
    `status` ENUM('envoyé', 'reçu', 'lu') NOT NULL DEFAULT 'envoyé', -- Statut du message
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Date d'envoi du message
    FOREIGN KEY (`sender_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`receiver_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);
