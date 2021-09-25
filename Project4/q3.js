db.laureates.aggregate([
    { $group: { _id: "$familyName.en", count: { $sum: 1 } } },
    { $match: { count: { $gte: 5 }, _id: { "$ne": null } } },
    { $addFields: { "familyName": "$_id" } },
    { $project: { familyName: 1, _id : 0 } }
]);

