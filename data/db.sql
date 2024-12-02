CREATE TABLE posts(
    id          bigserial    NOT NULL,
    external_id int          NOT NULL,
    title       varchar(255) NOT NULL,
    body        text         NOT NULL,
    user_id     varchar(255) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (external_id)
);

CREATE TABLE comments(
    id          bigserial    NOT NULL,
    external_id int          NOT NULL,
    name        varchar(255) NOT NULL,
    email       varchar(255) NOT NULL,
    body        text         NOT NULL,
    post_id     int REFERENCES posts (id),
    PRIMARY KEY (id),
    UNIQUE (external_id)
);
