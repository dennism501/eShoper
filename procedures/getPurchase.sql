DROP PROCEDURE IF EXISTS eshoper_db.GetPurchase;
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetPurchase`(
  IN user_token VARCHAR(32))

  BEGIN

    SELECT PM.productName, PM.price FROM productMaster PM
    JOIN purchaseMaster P ON P.productId = PM.id
    JOIN user U ON U.id = P.userId
    JOIN userToken T ON T.userId = U.id

    WHERE T.token = user_token

    ORDER BY P.date;

  END;
