CREATE TABLE sveden_table_education (
    id          SERIAL      NOT NULL PRIMARY KEY,
    org_id      INT         NULL,
    edu_code    TEXT        NOT NULL COMMENT "Код",
    edu_name    TEXT        NOT NULL COMMENT "Направление",
    edu_form    TEXT        NOT NULL COMMENT "Форма обучения",
    edu_level   TEXT        NOT NULL COMMENT "Уровень образования",
    contingent  INT         NOT NULL COMMENT "Общая численность обучающихся"
);
