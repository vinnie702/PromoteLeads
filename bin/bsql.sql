SELECT * FROM locations;

SELECT * FROM users;

SHOW TABLES;

SELECT * FROM userLocations;


SELECT * FROM users u
LEFT JOIN userCompanyPositions uc ON u.id = uc.userid
LEFT JOIN userLocations ul ON u.id = ul.userid
WHERE position = 24;


SELECT * FROM positions;
