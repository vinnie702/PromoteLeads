SELECT * FROM locations;

SELECT id, lastName, firstName, email, status, deleted, companyName FROM users;

SHOW TABLES;

SELECT * FROM userLocations;

SELECT * FROM userYouTubeVideos;

SELECT * FROM users u
LEFT JOIN userCompanyPositions uc ON u.id = uc.userid
LEFT JOIN userLocations ul ON u.id = ul.userid
WHERE position = 24;

SELECT * FROM contactUs;

EXPLAIN contactUs;

SELECT * FROM positions;

SELECT * FROM locationImages;
