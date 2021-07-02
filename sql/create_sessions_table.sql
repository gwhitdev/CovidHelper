CREATE TABLE IF NOT EXISTS login_sessions
(
    session_id      VARCHAR(255) NOT NULL,
    user_id      INT UNSIGNED NOT NULL,
    login_time      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (session_id)
);