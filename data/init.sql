use W01149488;

CREATE TABLE reviews (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    year INT(4) NOT NULL,
    rating INT(2),
    description VARCHAR(100),
    reviewer VARCHAR(30),
    datereviewed TIMESTAMP
  );