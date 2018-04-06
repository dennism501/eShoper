DROP PROCEDURE IF EXISTS eshoper_db.RecordPurchase;
CREATE DEFINER=`root`@`localhost` PROCEDURE `RecordPurchase`(
  IN product VARCHAR(32),
  IN amount VARCHAR(100),
  IN usrtoken VARCHAR(32))
  BEGIN

    START TRANSACTION;

    /*inserts product from the user*/
    INSERT INTO productMaster(productName, price)
    VALUES (product,
            ((SELECT amount FROM taxMaster WHERE id=1 )*amount));

    /*records a purchase by a user*/
    INSERT INTO purchaseMaster(userId, productId,date)
    VALUES ((SELECT c.userId from credentials c
    where c.tokenId = (SELECT id from userToken where token = usrtoken)),
            (SELECT LAST_INSERT_ID(id) AS productId from productMaster),
            (SELECT NOW()));

    COMMIT ;


  END;

