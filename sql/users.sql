CREATE TABLE IF NOT EXISTS users
(
    user_id     INT UNSIGNED NOT NULL AUTO_INCREMENT,
    first_name  VARCHAR(20) NOT NULL,
    last_name   VARCHAR(40) NOT NULL,
    email       VARCHAR(60) NOT NULL,
    pass        CHAR(60) NOT NULL,
    reg_date    DATETIME NOT NULL,
    user_type   VARCHAR(10) NOT NULL CHECK ('user','site-admin','doctor','nurse','support') DEFAULT 'user',
    PRIMARY KEY (user_id),
    UNIQUE (email)
);

