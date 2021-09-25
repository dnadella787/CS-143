db.laureates.aggregate([
    { $unwind: "$nobelPrizes" },
    { $unwind: "$nobelPrizes.affiliations" },
    { $match: { "nobelPrizes.affiliations.name.en": "University of California" } },
    {
        $group:
        {   
            _id:
            {
                "university": "$nobelPrizes.affiliations.name.en",
                "place": "$nobelPrizes.affiliations.city.en"
            }
        }
    },
    {
        $group:
        {
            _id:
            {
                "university": "$_id.university",
            },
            "locations": { $sum: 1 }
        }
    },
    { $project: { "locations": 1, "_id": 0 } }
]);