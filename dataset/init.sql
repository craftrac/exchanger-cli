-- create symbols domain type that contains the currency codes and can be extended in the future;
CREATE DOMAIN currency_code AS CHAR(3)
CHECK (VALUE ~ '^[A-Z]{3}$');


-- create rates table that will store the exchange rates
CREATE TABLE rates (
    currency_date DATE,
    currency_symbol currency_code,
    currency_rate DECIMAL
);

-- add unique constraint to the rates table to prevent duplicates
ALTER TABLE rates ADD CONSTRAINT unique_date_symbol UNIQUE (currency_date, currency_symbol);

-- create materialized view that will store the monthly exchange rate statistics
CREATE MATERIALIZED VIEW currency_rates_monthly AS
SELECT
    DATE_TRUNC('month', currency_date) AS month,
    currency_symbol,
    MIN(currency_rate) AS min_rate,
    MAX(currency_rate) AS max_rate,
    AVG(currency_rate) AS avg_rate
FROM
    rates
GROUP BY
    DATE_TRUNC('month', currency_date),
    currency_symbol
ORDER BY
    month ASC,
    currency_symbol ASC;

-- create view that will query the daily exchange rates 
CREATE VIEW todays_currency_rates AS
SELECT
    currency_date,
    currency_rate,
    currency_symbol
FROM
    rates
WHERE
    currency_date = CURRENT_DATE;
