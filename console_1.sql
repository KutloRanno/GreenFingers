DROP DATABASE IF EXISTS GreenFingers;

CREATE DATABASE  GreenFingers;

USE GreenFingers;

DROP TABLE IF EXISTS Purchase;
DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS Stock;
DROP TABLE IF EXISTS Stock_Type;
DROP TABLE IF EXISTS Status;
DROP TABLE IF EXISTS Store;
DROP TABLE IF EXISTS Management;
DROP TABLE IF EXISTS Customer_Bank;
DROP TABLE IF EXISTS Customer;
DROP TABLE IF EXISTS Bank;
DROP TABLE IF EXISTS Country;
DROP VIEW IF EXISTS stocklevelbystore_view ;
DROP PROCEDURE IF EXISTS UpdateStoreId;
DROP PROCEDURE IF EXISTS MakePurchase;


CREATE TABLE Bank (
    bankSortCode int PRIMARY KEY ,
    bankName varchar(30) NOT NULL UNIQUE
);

CREATE TABLE Country(
    countryId int PRIMARY KEY ,
    countryName varchar(30) NOT NULL UNIQUE
);

CREATE TABLE Customer(
    cusId int PRIMARY KEY auto_increment ,
    cusFirstname varchar(25) NOT NULL ,
    cusLastName varchar(25) NOT NULL ,
    cusDateOfBirth DATE NOT NULL ,
    cusCellNo int NOT NULL UNIQUE ,
    cusPhysicalAddress varchar(40),
    cusEmailAddress varchar(40) UNIQUE ,
    cusPassword char(60)  NOT NULL ,
    cusGender char(1) NOT NULL  ,
    countryId int REFERENCES Country,
    cusDateRegistered date not null
);
ALTER TABLE Customer AUTO_INCREMENT = 8890;

CREATE TABLE Customer_Bank(
    cusId INT REFERENCES Customer,
    bankSortCode INT NOT NULL REFERENCES Bank,
    accountNumber INT PRIMARY KEY
);

CREATE TABLE Store(
    storeId int PRIMARY KEY,
    storeName varchar(30) UNIQUE NOT NULL ,
    storeAddress varchar(30)  UNIQUE NOT NULL
);

CREATE TABLE Stock_Type(
    stockTypeId int PRIMARY KEY ,
    stockTypeName varchar(30) NOT NULL UNIQUE
);

CREATE TABLE Stock(
    stockId int Primary Key,
    stockName varchar(30) NOT NULL UNIQUE ,
    stockSize varchar(10) NOT NULL,
    stockTypeId int REFERENCES Stock_Type
);

CREATE TABLE Management(
    manEmailAddress varchar(40) PRIMARY KEY ,
    manPassword char(60) NOT NULL
);

CREATE TABLE Status(
    statusId INT PRIMARY KEY
);

CREATE TABLE Product(
    prodId int PRIMARY KEY ,
    prodName varchar(20),
    prodCost float NOT NULL ,
    prodDescription varchar(300),
    storeId int REFERENCES Store,
    stockId int REFERENCES Stock,
    statusId INT REFERENCES Status,
    manEmailAddress varchar(50) REFERENCES Management
);

CREATE TABLE Purchase(
    prodId  INT REFERENCES Product,
    accountNumber int REFERENCES Customer_Bank,
    purchaseDate DATE NOT NULL,
    PRIMARY KEY(prodId,accountNumber)
);

# inserting data into my tables now

insert into Bank (bankSortCode, bankName) values
( 1011,'FNB'),(1013,'ABSA'),(1015,'Stanbic'),(1017,'Baroda'),(1019,'Barclays'),(1021,'Capitec')
;
select * from Bank;

insert into Country (countryId, countryName) VALUES (1,'Botswana'),(2,'Zambia'),(3,'Letshotho');
select * from Country;

insert into Customer
    (cusFirstname, cusLastName, cusDateOfBirth, cusCellNo, cusPhysicalAddress, cusEmailAddress, cusPassword, countryId,cusGender, cusDateRegistered)
values('Kutlo' ,'Ranno','2002,07,17', 77335859,'Gabs Block 8','kutlo@outlook','password',1,'M',current_date()),
      ('Leo','Messi','1986-09-17',28191,'Miami Phase 2','messi@outlook','messipass',2,'M',current_date()),
      ('Dinny','Jameson','2001-06-21',43322,'Nothumbria','dinny@gmail.com','dinnypass',3,'F',current_date());
select * from Customer;

insert into Customer_Bank (cusId, bankSortCode, accountNumber)
values (8890,1011,74620372),(8892,1019,2121211);
select * from Customer_Bank;

insert into Stock_Type (stockTypeId, stockTypeName)
values(20221,'Garden Ware') ,(20223,'House Plants'),(20225,'Flowers'),(20227,'Outdoor Plants');
select * from Stock_Type;

insert into Stock (stockId, stockName, stockSize, stockTypeId) values (1111,'Tulip','seedlings',20225),
                                                                      (1113,'Red Rose','Mature',20225),
                                                                      (1115,'Cactus','Small',20223),
                                                                      (1117,'Artificial lawn','Medium',20227),
                                                                      (1119,'hand shovel','small',20221);
select * from Stock;

insert into Store (storeId, storeName, storeAddress) values (2221,'Gaborone Green Fingers','Block 3 Gabs'),
                                                            (2223,'Paje Green Fingers','Paje 23rd Avenue'),
                                                            (2225,'Riverwalk Green Fingers','Riverwalk Mall Unit 23'),
                                                            (2227,'Gabane Green Fingers','Gabane Block 9'),
                                                            (2229,'Serowe Green Fingers','Botalaote Mall Unit 5');
select * from Store;

insert into Management (manEmailAddress, manPassword) VALUES ('jeffrey@outlook.com','password'), ('lucia@gmail.com','password'),('joe@yahoo.com','joepass');
select * from Management;

insert into Status (statusId) VALUES (0),(1);
select * from Status;

insert into Product (prodId, prodName, prodCost, prodDescription, storeId, stockId, statusId, manEmailAddress)
VALUES
    (4831,'Tulip',90.00,'A white tulip to spread love and warmth',2221,1111,1,'lucia@gmail.com'),
    (4833,'Tulip',90.00,'A white tulip to spread love and warmth',2229,1111,1,'lucia@gmail.com'),
    (4835,'Tulip',90.00,'A white tulip to spread love and warmth',2227,1111,1,'lucia@gmail.com'),
    (4837,'Tulip',90.00,'A white tulip to spread love and warmth',2229,1111,1,'jeffrey@outlook.com'),
    (4839,'Tulip',90.00,'A white tulip to spread love and warmth',2229,1111,1,'lucia@gmail.com'),
    (4841,'Tulip',90.00,'A white tulip to spread love and warmth',2227,1111,1,'lucia@gmail.com'),
    (4843,'Tulip',90.00,'A white tulip to spread love and warmth',2229,1111,1,'lucia@gmail.com'),
    (4845,'Tulip',90.00,'A white tulip to spread love and warmth',2227,1111,1,'lucia@gmail.com'),
    (4847,'Tulip',90.00,'A white tulip to spread love and warmth',2229,1111,1,'joe@yahoo.com'),
    (4849,'Tulip',90.00,'A white tulip to spread love and warmth',2229,1111,1,'lucia@gmail.com'),
    (6769,'Shovel',300.00,'For digging in small plots or seedling containers',2227,1119,1,'jeffrey@outlook.com'),
    (6771,'Shovel',300.00,'For digging in small plots or seedling containers',2227,1119,1,'jeffrey@outlook.com'),
    (6773,'Shovel',300.00,'For digging in small plots or seedling containers',2221,1119,1,'jeffrey@outlook.com'),
    (6775,'Shovel',300.00,'For digging in small plots or seedling containers',2221,1119,1,'jeffrey@outlook.com'),
    (6777,'Shovel',300.00,'For digging in small plots or seedling containers',2221,1119,1,'lucia@gmail.com'),
    (6779,'Shovel',300.00,'For digging in small plots or seedling containers',2229,1119,1,'jeffrey@outlook.com'),
    (6781,'Shovel',300.00,'For digging in small plots or seedling containers',2229,1119,1,'joe@yahoo.com'),
    (6783,'Shovel',300.00,'For digging in small plots or seedling containers',2227,1119,1,'jeffrey@outlook.com'),
    (6785,'Shovel',300.00,'For digging in small plots or seedling containers',2221,1119,1,'jeffrey@outlook.com'),
    (5550,'Cactus',120.00,'Cute cactus for putting on your comfy table or window pane',2225,1115,1,'lucia@gmail.com'),
    (5552,'Cactus',120.00,'Cute cactus for putting on your comfy table or window pane',2227,1115,1,'lucia@gmail.com'),
    (5554,'Cactus',120.00,'Cute cactus for putting on your comfy table or window pane',2227,1115,1,'lucia@gmail.com'),
    (5556,'Cactus',120.00,'Cute cactus for putting on your comfy table or window pane',2225,1115,1,'lucia@gmail.com'),
    (5558,'Cactus',120.00,'Cute cactus for putting on your comfy table or window pane',2225,1115,1,'jeffrey@outlook.com'),
    (5560,'Cactus',120.00,'Cute cactus for putting on your comfy table or window pane',2221,1115,1,'lucia@gmail.com'),
    (5562,'Cactus',120.00,'Cute cactus for putting on your comfy table or window pane',2225,1115,1,'joe@yahoo.com'),
    (5564,'Cactus',120.00,'Cute cactus for putting on your comfy table or window pane',2225,1115,1,'lucia@gmail.com');
select * from Product;


CREATE VIEW StockLevelByStore_view AS
SELECT x.prodName, x.prodCost, x.prodDescription, x.storeid, x.stockid, x.statusid, x.manEmailAddress, x.stockName, x.stockSize, x.stockTypeID, x.StockTypeName, x.storeName, x.storeAddress, SUM(Quantity) AS Quantity
FROM(
SELECT a.prodid, a.prodName, a.prodCost, a.prodDescription, a.storeid, a.stockid, a.statusid, a.manEmailAddress, b.stockName, b.stockSize, b.stockTypeID, c.StockTypeName, d.storeName, d.storeAddress, 1 AS Quantity
FROM product a,
stock b,
stock_type c,
store d
WHERE a.stockid = b.stockid     AND
b.stocktypeid = c.stocktypeid AND
a.storeid = d.storeid AND
a.statusId =1
) x
GROUP BY x.prodName, x.storeName
ORDER BY x.ProdName, x.StoreName ASC;

select * from StockLevelByStore_view;

#Procedure to update store id of products when a manager moves products across stores
DELIMITER //
CREATE PROCEDURE UpdateStoreId(
    IN p_stockId INT,
    IN p_currentStoreId INT,
    IN p_newStoreId INT,
    IN p_numProducts INT
)
BEGIN
    DECLARE counter INT DEFAULT 0;
    DECLARE product_id INT;

    # Create a cursor to fetch the products with the specified stockId and storeid
    DECLARE cur_products CURSOR FOR
        SELECT prodId
        FROM Product
        WHERE stockId = p_stockId AND storeId=p_currentStoreId
        ORDER BY stockId;

    DECLARE CONTINUE HANDLER FOR NOT FOUND
        SET counter = p_numProducts + 1;

    # Open the cursor
    OPEN cur_products;

    # Loop through the cursor and update storeId
    productLoop: LOOP
        FETCH cur_products INTO product_id;

        IF counter >= p_numProducts THEN
            LEAVE productLoop;
        END IF;

        # Update storeId for the current product
        UPDATE Product
        SET storeId = p_newStoreId
        WHERE prodId = product_id;

        SET counter = counter + 1;
    END LOOP;

    # Close the cursor
    CLOSE cur_products;
END //
DELIMITER ;
# call procedure here
# CALL UpdateStoreId(1115,2225,2221,2);

#Procedure to run when customer purchases a product
DELIMITER //
CREATE PROCEDURE MakePurchase(
    IN p_stockId INT,
    IN p_accNumber INT,
    IN p_quantity INT,
    IN p_storeId INT
)
BEGIN
    DECLARE counter INT DEFAULT 0;
    DECLARE productId INT ;

    # Create a cursor to fetch the products with the specified stockId and storeid
    DECLARE cur_products CURSOR FOR
        SELECT prodId
        FROM Product
        WHERE stockId = p_stockId AND storeId=p_storeId
        ORDER BY stockId;

    DECLARE CONTINUE HANDLER FOR NOT FOUND
        SET counter = p_quantity + 1;

    # Open the cursor
    OPEN cur_products;

    # Loop through the cursor and update storeId
    productLoop: LOOP
        FETCH cur_products INTO productId;

        IF counter >= p_quantity THEN
            LEAVE productLoop;
        END IF;

        # Update statusId for the current product
        UPDATE Product
        SET statusId = 0
        WHERE prodId = productId;

        #insert details into purchase table
        INSERT INTO Purchase (prodId, accountNumber, purchaseDate)
        VALUES (productId,p_accNumber,current_date);

        SET counter = counter + 1;
    END LOOP;

    #close the cursor
    CLOSE cur_products;
end;
DELIMITER //


