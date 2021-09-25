
-- In how many years a nobel prize was awarded to an organization (as opposed to a person) 
-- in at least one category?

SELECT COUNT(DISTINCT awardYear)
FROM LaureatePrizes 
WHERE id IN (SELECT id FROM OrgLaureates) and id NOT IN (SELECT id FROM Laureates);