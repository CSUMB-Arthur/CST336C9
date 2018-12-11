-- copy index, triggers, AND data (rows + columns) of a table
CREATE TABLE newtable LIKE oldtable; 
INSERT newtable SELECT * FROM oldtable;

-- 

-- add column to table
ALTER TABLE table
ADD COLUMN somename sometype [FIRST|AFTER existing_column];


--update all values
UPDATE sometable SET attribute = value, attribute2 = anothervalue;