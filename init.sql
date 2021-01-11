create table currency
(
    id                   int auto_increment primary key,
    calendar_date        date          not null,
    last_prediction_date date          not null,
    valute_id            varchar(32)   not null,
    name                 varchar(128)  not null,
    value                decimal(7, 4) not null,
    valute_nominal       int           not null,
    char_code            varchar(16)   not null
);
