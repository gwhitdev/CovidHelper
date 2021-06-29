CREATE TABLE IF NOT EXISTS patient_audit (
    audit_id        INT UNSIGNED NOT NULL AUTO_INCREMENT,
    activity        VARCHAR(60) NOT NULL,
    activity_date   DATETIME NOT NULL,
    patient_id      INT UNSIGNED,
    user_id         INT UNSIGNED,
    PRIMARY  KEY (audit_id),
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    UNIQUE (audit_id)
);