CREATE TABLE IF NOT EXISTS patients 
(
patient_id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
patient_first_name      VARCHAR(40) NOT NULL,
patient_last_name       VARCHAR(60) NOT NULL,
patient_email           VARCHAR(20) NOT NULL,
patient_post_code       VARCHAR(10) NOT NULL,
patient_user_name       VARCHAR(20) NOT NULL,
user_id                 INT UNSIGNED,
PRIMARY KEY (patient_id),
FOREIGN KEY (user_id) REFERENCES users(user_id),
UNIQUE (patient_email,user_id)
);
