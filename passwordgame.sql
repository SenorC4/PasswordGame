DROP SCHEMA IF EXISTS passwordgame;
CREATE SCHEMA passwordgame;
USE passwordgame;

CREATE TABLE RULES (
	RULE_NUM    INTEGER NOT NULL,
	RULE_DESC   VARCHAR(200) NOT NULL
);

CREATE TABLE WINNING_PASSWORDS (
	PASSWORD    VARCHAR(3000) NOT NULL
);

INSERT INTO RULES VALUES (5, 'Your password must include "duck".');
INSERT INTO RULES VALUES (4, 'Your password must include a special character.');
INSERT INTO RULES VALUES (3, 'Your password must include an uppercase letter.');
INSERT INTO RULES VALUES (2, 'Your password must include a number.');
INSERT INTO RULES VALUES (1, 'Your password must have at least 5 characters.');