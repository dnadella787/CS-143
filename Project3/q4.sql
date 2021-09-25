
-- How many different locations does the affiliation "University of California" have?

SELECT COUNT(DISTINCT affilCity)
FROM LaureatePrizes 
WHERE affilName LIKE "%University of California%";