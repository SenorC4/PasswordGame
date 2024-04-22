DROP SCHEMA IF EXISTS backupprompts;
CREATE SCHEMA backupprompts;
USE backupprompts;

CREATE TABLE leaderboard (
	username    varchar(100),
	score   int(11)
);

CREATE TABLE prompts (
	title    int(11),
    info varchar(3000),
    image varchar(3000)
);

INSERT INTO prompts VALUES (19, 'Your password must include the length of your password.', NULL);
INSERT INTO prompts VALUES (18, 'Your password must include the name of this character.', 'images/1character.png');
INSERT INTO prompts VALUES (17, 'Your password must end with a punctuation mark.', NULL);
INSERT INTO prompts VALUES (16, 'Your password must include the binary representation of the letter Q.', NULL);
INSERT INTO prompts VALUES (15, 'Your password must include the name of this U.S. president.', 'images/1president.png');
INSERT INTO prompts VALUES (14, 'Your duck is hungry. Keep your duck fed or else you lose the game.', NULL);
INSERT INTO prompts VALUES (13, 'Your password must include the name of this painting.', 'images/1painting.png');
INSERT INTO prompts VALUES (12, 'Your password must include Earth\'s diameter at the equator in miles.', 'images/earth.png');
INSERT INTO prompts VALUES (11, 'Your password must contain the emoji of Dr. Mood\'s favorite animal.', NULL);
INSERT INTO prompts VALUES (10, 'Your password must contain the answer to this captcha.', 'captchas/1captcha.jpg');
INSERT INTO prompts VALUES (9, 'The numbers in your password must add up to 30.', NULL);
INSERT INTO prompts VALUES (8, 'Your password must include the name of any one of these MICS faculty members.',  'images/faculty.png');
INSERT INTO prompts VALUES (7, 'Your password must include the name of a PLNU building.', NULL);
INSERT INTO prompts VALUES (6, 'Your password must include a month of the year.',  NULL);
INSERT INTO prompts VALUES (5, 'Your password must include "PLNU".',  NULL);
INSERT INTO prompts VALUES (4, 'Your password must include a special character.',  NULL);
INSERT INTO prompts VALUES (3, 'Your password must include an uppercase letter.',  NULL);
INSERT INTO prompts VALUES (2, 'Your password must include a number.',  NULL);
INSERT INTO prompts VALUES (1, 'Your password must have at least 8 characters.',  NULL);
