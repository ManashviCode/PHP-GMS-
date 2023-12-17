CREATE DATABASE test;
use test;

CREATE TABLE emailMessage (
	id INT(11) PRIMARY KEY AUTO_INCREMENT,
	sender VARCHAR(30) NOT NULL,
	receiver VARCHAR(30) NOT NULL,
	cc VARCHAR(30) NOT NULL,
    bcc VARCHAR(30) NOT NULL,
	email VARCHAR(200) NOT NULL,
	date TIMESTAMP
);

ALTER TABLE emailMessage
ADD COLUMN subject VARCHAR(30) NOT NULL;

use test;
CREATE TABLE labels (
    labelid INT(11) PRIMARY KEY AUTO_INCREMENT,
    labelname VARCHAR(20) NOT NULL,
    desciption VARCHAR(30) NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

use test;
CREATE TABLE emailMessage_labels (
 emailMessage_labels_id INT PRIMARY KEY AUTO_INCREMENT,
 labelid INT(11) UNSIGNED NOT NULL,
 id INT(11) UNSIGNED NOT NULL,
 FOREIGN KEY (labelid) REFERENCES labels(labelid),
 FOREIGN KEY (id) REFERENCES emailMessage(id)
);

CREATE INDEX idx_subject ON emailMessage (subject);