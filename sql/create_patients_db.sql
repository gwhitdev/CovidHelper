CREATE TABLE IF NOT EXISTS patients 
(
    patient_id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
    patient_first_name      VARCHAR(40) NOT NULL,
    patient_last_name       VARCHAR(60) NOT NULL,
    patient_email           VARCHAR(50) NOT NULL,
    patient_postcode        VARCHAR(50) NOT NULL,
    patient_dob             DATE NOT NULL,
    vaccination_one         DATE,
    vaccination_two         DATE,
    patient_notes           TEXT,
    date_created            DATE NOT NULL,
    user_id                 INT UNSIGNED,
    PRIMARY KEY (patient_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    UNIQUE (patient_email,user_id)
);
