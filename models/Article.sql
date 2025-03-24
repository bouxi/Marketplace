CREATE TABLE articles (
                          id INT PRIMARY KEY AUTO_INCREMENT,
                          user_id INT,
                          nom VARCHAR(255),
                          categorie VARCHAR(255),
                          quantite INT,
                          description TEXT,
                          prix DECIMAL(10,2),
                          FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
ALTER TABLE articles
    ADD COLUMN photo1 VARCHAR(255) NULL,
ADD COLUMN photo2 VARCHAR(255) NULL,
ADD COLUMN photo3 VARCHAR(255) NULL;
