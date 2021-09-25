

SELECT 
    A.first, 
    A.last
FROM 
    Actor A, 
    Movie M,
    MovieActor MA
WHERE 
    A.id = MA.aid 
    AND
    MA.mid = M.id
    AND 
    M.title = 'Die Another Day';
