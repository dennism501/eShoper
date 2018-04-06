DROP PROCEDURE IF EXISTS eshoper_db.GetUsernamePassword;
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetUsernamePassword`(
  IN user_name VARCHAR(32),
  IN pass_word VARCHAR(100),
  IN usrtoken VARCHAR(40))
  BEGIN

    SELECT
      c.userName,
      c.password,
      t.token,
      u.id
    FROM credentials c
      JOIN userToken t ON t.id = c.tokenId
      JOIN user u ON u.id = c.userId

    WHERE c.password = pass_word AND c.userName = user_name AND t.token = usrtoken;

  END;