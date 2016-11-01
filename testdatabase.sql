USE thesis_db;

DROP TABLE BUSINESS_HOURS_TB;
CREATE TABLE BUSINESS_HOURS_TB (
	day_no INT(11) NOT NULL,
	branch_id INT(11) NOT NULL,
	CONSTRAINT bh_branch_id_FK FOREIGN KEY(branch_id)
	REFERENCES BRANCHES_TB(id),
	opening_hour TIME NOT NULL,
	closing_hour TIME NOT NULL,
	CONSTRAINT CPK_Business_hours PRIMARY KEY (day_no, branch_id)
);