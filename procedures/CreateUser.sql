DROP PROCEDURE IF EXISTS ehsoper_db.CreateUser;
CREATE DEFINER=`root`@`localhost` PROCEDURE `CreateUser`(
  IN first_name    VARCHAR(32),
  IN last_name     VARCHAR(32),
  IN phone_number  VARCHAR(15),
  IN email_address VARCHAR(32),
  IN address_ad    VARCHAR(100),
  IN user_name     VARCHAR(32),
  IN pass_word     VARCHAR(64))
  BEGIN

    DECLARE p_email VARCHAR(32);

    SELECT email
    INTO p_email
    FROM user
    WHERE email = email_address;

    IF (p_email IS NULL)
    THEN

      START TRANSACTION;

      /*Creates a new user*/

      INSERT INTO user (
        firstName,
        lastName,
        phoneNumber,
        email,
        address)

      VALUES (first_name,
              last_name,
              phone_number,
              email_address,
              address_ad);

      /* creates user token to access the data*/
      INSERT INTO userToken (token, userId)
      VALUES (uuid(), (SELECT LAST_INSERT_ID(id)FROM user));

      /*insert into credentials*/

      INSERT INTO credentials(
        userName,
        password,
        userId,
        tokenId)

      VALUES (user_name,
              pass_word,
              (SELECT LAST_INSERT_ID(id) FROM user),
              (SELECT LAST_INSERT_ID(id) FROM userToken));


      COMMIT;

    END IF;

  END;