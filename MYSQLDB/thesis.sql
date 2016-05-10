
DROP DATABASE IF EXISTS thesis_db;
CREATE DATABASE IF NOT EXISTS thesis_db;

USE thesis_db;

CREATE TABLE END_USER_TB (
	id INT(11) AUTO_INCREMENT,
	CONSTRAINT PK_User PRIMARY KEY(id),
	email VARCHAR(255),
	username VARCHAR(255) UNIQUE,
	password VARCHAR(255) NOT NULL,
	first_name VARCHAR(255) NOT NULL,
	last_name VARCHAR(255) NOT NULL,
	contact VARCHAR(255),
	hometown VARCHAR(255),
	display_picture VARCHAR(255),
	user_type VARCHAR(255) NOT NULL,
	stripe_id VARCHAR(255)
);

CREATE TABLE CATEGORY_TB (
	id INT(11) AUTO_INCREMENT,
	CONSTRAINT PK_Category PRIMARY KEY(id),
	name VARCHAR(255) NOT NULL,
	description VARCHAR(255) 
);

CREATE TABLE ESTABLISHMENT_TB (
	id INT(11) AUTO_INCREMENT,
	CONSTRAINT PK_Estab PRIMARY KEY(id),
	owner_id INT(11) NOT NULL,
	CONSTRAINT estab_owner_id_FK FOREIGN KEY(owner_id)
	REFERENCES END_USER_TB(id),
	category_id INT(11) NOT NULL,
	CONSTRAINT estab_category_id_FK FOREIGN KEY(category_id)
	REFERENCES CATEGORY_TB(id),
	name VARCHAR(255) NOT NULL,
	display_picture VARCHAR(255),
	description VARCHAR(255),
	tags VARCHAR(255)
);

CREATE TABLE BRANCHES_TB (
	id INT(11) AUTO_INCREMENT,
	estab_id INT(11) NOT NULL,
	CONSTRAINT branch_estab_id_FK FOREIGN KEY(estab_id)
	REFERENCES ESTABLISHMENT_TB(id),
	address VARCHAR(255) NOT NULL,
	lat FLOAT( 10, 6 ) NOT NULL,
	lng FLOAT( 10, 6 ) NOT NULL,
	CONSTRAINT CPK_branches PRIMARY KEY(id, estab_id)
);

#version 2.1
CREATE TABLE PLAN_DURATION_TB (
	id INT(11) AUTO_INCREMENT,
	CONSTRAINT PK_Plan_Dur PRIMARY KEY(id),
	duration_name VARCHAR(255) NOT NULL,
	description VARCHAR(255),
	duration_visibility VARCHAR(255)
	
);

CREATE TABLE PLAN_TB (
	id INT(11) AUTO_INCREMENT,
	CONSTRAINT PK_Plan PRIMARY KEY(id),
	plan_interval VARCHAR(255) NOT NULL,
	plan_name VARCHAR(255) NOT NULL,
	estab_no INT(11) NOT NULL,  #no of establishment
	branch_no INT(11) NOT NULL, #no of branches in all establishment
	cost DECIMAL(19, 4) NOT NULL,
	visibility VARCHAR(255) NOT NULL
	-- days_no INT(11) NOT NULL
);

CREATE TABLE SUBSCRIBED_PLAN (
	id INT(11) AUTO_INCREMENT,
	owner_id INT(11) NOT NULL,
	CONSTRAINT subs_plan_owner_FK FOREIGN KEY(owner_id)
	REFERENCES END_USER_TB(id),
	plan_id INT(11) NOT NULL,
	CONSTRAINT subs_plan_id_FK FOREIGN KEY(plan_id)
	REFERENCES PLAN_TB(id),
	date_start DATETIME NOT NULL,
	date_end DATETIME NOT NULL, 
	status VARCHAR(255) NOT NULL,
	CONSTRAINT CPK_subs_plan PRIMARY KEY(id, owner_id)
);


#version 4.0 
CREATE TABLE ACTIVITY_LOG_TB (
	id INT(11) AUTO_INCREMENT,
	CONSTRAINT PK_Activity PRIMARY KEY(id),
	user_id INT(11) NOT NULL,
	CONSTRAINT activity_user_id FOREIGN KEY(user_id)
	REFERENCES END_USER_TB(id),
	description VARCHAR(255) NOT NULL,
	processed_date DATETIME NOT NULL
);

-- CREATE TABLE COUPON_TB (
-- 	code INT(11) NOT NULL,
-- 	CONSTRAINT PK_Coupon PRIMARY KEY(code),
-- 	discount INT(11) NOT NULL,
-- 	status VARCHAR(255) NOT NULL
-- );

-- CREATE TABLE TRANSACTION_LOG_TB (
-- 	id INT(11) AUTO_INCREMENT,
-- 	CONSTRAINT PK_Transaction PRIMARY KEY(id),
-- 	subs_plan_id INT(11) NOT NULL,
-- 	CONSTRAINT transaction_owner_FK FOREIGN KEY(subs_plan_id)
-- 	REFERENCES SUBSCRIBED_PLAN(id),
-- 	processed_date DATETIME NOT NULL
-- );

#version 2.0
CREATE TABLE REVIEW_TB (
	user_id INT(11) NOT NULL,
	CONSTRAINT review_user_id_FK FOREIGN KEY(user_id)
	REFERENCES END_USER_TB(id),
	estab_id INT(11) NOT NULL,
	CONSTRAINT review_estab_id_FK FOREIGN KEY(estab_id)
	REFERENCES ESTABLISHMENT_TB(id),
	rating INT(11) NOT NULL,
	comment VARCHAR(255),
	CONSTRAINT CPK_Review PRIMARY KEY(user_id, estab_id)
);

CREATE TABLE GALLERY_TB (
	id INT(11) AUTO_INCREMENT,
	estab_id INT(11) NOT NULL,
	CONSTRAINT gallery_estab_id_FK FOREIGN KEY(estab_id)
	REFERENCES ESTABLISHMENT_TB(id),
	gallery_pic VARCHAR(255) NOT NULL,
	CONSTRAINT CPK_Gallery PRIMARY KEY(id, estab_id)
);

#version 4.0 
CREATE TABLE BRANCHES_GALLERY_TB (
	id INT(11) AUTO_INCREMENT,
	CONSTRAINT PK_branches_gallery_id PRIMARY KEY(id),
	branch_id INT(11) NOT NULL,
	CONSTRAINT br_gal_branch_id_FK FOREIGN KEY(branch_id)
	REFERENCES BRANCHES_TB(id),
	gallery_id INT(11) NOT NULL,
	CONSTRAINT br_gal_gallery_id_FK FOREIGN KEY(gallery_id)
	REFERENCES GALLERY_TB(id)
);


CREATE TABLE BOOKMARK_TB (
	user_id INT(11) NOT NULL,
	CONSTRAINT bookmark_user_id FOREIGN KEY(user_id)
	REFERENCES END_USER_TB(id),
	estab_id INT(11) NOT NULL,
	CONSTRAINT bookmark_estab_id FOREIGN KEY(estab_id)
	REFERENCES ESTABLISHMENT_TB(id),
	CONSTRAINT CPK_Bookmark PRIMARY KEY(user_id, estab_id)
);

#version 3.0
CREATE TABLE SUBSPLAN_ESTAB_TB (
	id INT(11) AUTO_INCREMENT,
	CONSTRAINT PK_subsplan_estab PRIMARY KEY(id),
	subs_plan_id INT(11) NOT NULL,
	CONSTRAINT subsplan_id_FK FOREIGN KEY(subs_plan_id)
	REFERENCES SUBSCRIBED_PLAN(id),
	estab_id INT(11) NOT NULL,
	CONSTRAINT subs_estab_id_FK FOREIGN KEY(estab_id)
	REFERENCES ESTABLISHMENT_TB(id)
);

#default values
-- INSERT INTO PLAN_TB (name, estab_no, branch_no, cost, days_no) VALUES ('WEEKLY SUBSCRIPTION', 3, 9, 2500, 7);
-- INSERT INTO PLAN_TB (name, estab_no, branch_no, cost, days_no) VALUES ('MONTHLY SUBSCRIPTION', 3, 9, 5000, 31);
-- INSERT INTO PLAN_TB (name, estab_no, branch_no, cost, days_no) VALUES ('YEARLY SUBSCRIPTION', 3, 9, 50000, 365);


#mga pede pang madagdag sa database
#1***************************************
#kinds of subscription na table eg. weekly monthly
#para sa normalization lang kung ififilter
#ung mga different kinds of subscription by 
#kind        ~~~~~~FORMALITY~~~~
#****************************************



#default values
INSERT INTO PLAN_DURATION_TB (duration_name, description, duration_visibility) VALUES ('day', 'daily', "HIDDEN");
INSERT INTO PLAN_DURATION_TB (duration_name, description, duration_visibility) VALUES ('week', 'weekly', "VISIBLE");
INSERT INTO PLAN_DURATION_TB (duration_name, description, duration_visibility) VALUES ('month', 'monthly', "VISIBLE");
INSERT INTO PLAN_DURATION_TB (duration_name, description, duration_visibility) VALUES ('year', 'yearly', "VISIBLE");

INSERT INTO PLAN_TB(plan_name, plan_interval, estab_no, branch_no, cost, visibility) VALUES ('not specified', 2, 3, 9, 2500, "VISIBLE");
INSERT INTO PLAN_TB(plan_name, plan_interval, estab_no, branch_no, cost, visibility) VALUES ('not specified', 2, 2, 9, 2200, "VISIBLE");
INSERT INTO PLAN_TB(plan_name, plan_interval, estab_no, branch_no, cost, visibility) VALUES ('not specified', 2, 1, 9, 2000, "VISIBLE");

INSERT INTO PLAN_TB(plan_name, plan_interval, estab_no, branch_no, cost, visibility) VALUES ('not specified', 3, 3, 9, 5500, "VISIBLE");
INSERT INTO PLAN_TB(plan_name, plan_interval, estab_no, branch_no, cost, visibility) VALUES ('not specified', 3, 2, 9, 5200, "VISIBLE");
INSERT INTO PLAN_TB(plan_name, plan_interval, estab_no, branch_no, cost, visibility) VALUES ('not specified', 3, 1, 9, 5000, "VISIBLE");

INSERT INTO PLAN_TB(plan_name, plan_interval, estab_no, branch_no, cost, visibility) VALUES ('not specified', 4, 3, 9, 55000, "VISIBLE");
INSERT INTO PLAN_TB(plan_name, plan_interval, estab_no, branch_no, cost, visibility) VALUES ('not specified', 4, 2, 9, 52000, "VISIBLE");
INSERT INTO PLAN_TB(plan_name, plan_interval, estab_no, branch_no, cost, visibility) VALUES ('not specified', 4, 1, 9, 50000, "VISIBLE");

INSERT INTO CATEGORY_TB (name, description) VALUES ("FAST FOOD", "Naaaah");
INSERT INTO CATEGORY_TB (name, description) VALUES ("HOSPITAL", "Naaaah");
INSERT INTO CATEGORY_TB (name, description) VALUES ("PARK", "Naaaah");
INSERT INTO CATEGORY_TB (name, description) VALUES ("MALL", "Naaaah");
INSERT INTO CATEGORY_TB (name, description) VALUES ("SALON", "Naaaah");

INSERT INTO END_USER_TB (email, username, password, first_name, last_name, contact, hometown, display_picture , user_type)
VALUES ("bautistamaryjo143@gmail.com", "jojo", "7510d498f23f5815d3376ea7bad64e29", "Maryjo", "Yasa", "09069081822", "Malolos, Bulacan", "DISPLAY_PICTURES/defaultavatar.png", "ADMIN");