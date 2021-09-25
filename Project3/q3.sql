
-- Find the family names associated with five or more Nobel Prizes.

SELECT familyName
FROM Laureates 
GROUP BY familyName
HAVING COUNT(*) >= 5;