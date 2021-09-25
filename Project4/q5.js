db.laureates.aggregate([
    { $unwind: "$nobelPrizes" },
    { $match: { "orgName.en": { $ne: null } } },
    {
        $group:
        {
            _id: { "year": "$nobelPrizes.awardYear" },
            count: { $sum: 1 }
        }
    },
    {
        $group:
        {
            _id: { "awardYears": "$_id:year" },
            years: { $sum: 1 }
        }
    },
    { $project: { "_id": 0, "years": 1} }
]);