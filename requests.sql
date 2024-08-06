CREATE TYPE size_form AS (
    all             INT NOT NULL,
    foreigners      INT NOT NULL
);

CREATE TABLE size(
    id              SERIAL PRIMARY KEY,
    federal_budget  size_form INT NOT NULL,
    russian_budget  size_form INT NOT NULL,
    local_budget    size_form INT NOT NULL,
    fiz_leg_budget  size_form INT NOT NULL
    all             INT NOT NULL
);

CREATE TABLE specialization (
    id              SERIAL PRIMARY KEY,
    edu_code        VARCHAR(8) NOT NULL,
    edu_name        VARCHAR(255) NOT NULL,
    edu_level       VARCHAR(128) NOT NULL,
    edu_form        VARCHAR(128) NOT NULL,
    id_size         INTEGER REFERENCES size (id) NOT NULL
);