CREATE TABLE company (
   id int(11) NOT NULL auto_increment,
   name varchar(255) NOT NULL,
   description TEXT NULL,
   PRIMARY KEY (id)
 );
 
CREATE TABLE product_template (
	id int( 11 ) NOT NULL AUTO_INCREMENT ,
	name varchar( 255 ) NOT NULL ,
	description TEXT NULL ,
	PRIMARY KEY ( id )
);
 
CREATE TABLE `product` (
  id int( 11 ) NOT NULL AUTO_INCREMENT ,
  `company_id` int( 11 ) NOT NULL ,
  `product_template_id` int( 11 ) NOT NULL,
  PRIMARY KEY (id)
);

ALTER TABLE  `product` ADD INDEX (  `company_id` ) ;
ALTER TABLE  `product` ADD INDEX (  `product_template_id` ) ;

 INSERT INTO company (name, description)
     VALUES  ('The  Military  Wives',  'In  My  Dreams');
 INSERT INTO company (name, description)
     VALUES  ('Adele',  '21');
 INSERT INTO company (name, description)
     VALUES  ('Bruce  Springsteen',  'Wrecking Ball (Deluxe)');
 INSERT INTO company (name, description)
     VALUES  ('Lana  Del  Rey',  'Born  To  Die');
 INSERT INTO company (name, description)
     VALUES  ('Gotye',  'Making  Mirrors');
     
     
INSERT INTO product_template (name, description, company_id)
    VALUES  ('Product 1',  'Product Description', 1);
    
INSERT INTO product_template (name, description, company_id)
    VALUES  ('Product 1',  'Product Description', 1);
    
INSERT INTO product_template (name, description, company_id)
    VALUES  ('Product 1',  'Product Description', 1);