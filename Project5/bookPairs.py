from pyspark import SparkContext
import itertools 


sc = SparkContext("local", "BookPairs")


lines = sc.textFile("/home/cs143/data/goodreads.user.books")
# lines = sc.textFile("/home/cs143/data/reads3000")


book_ids = lines.map(lambda line: line.split(":")[1].split(","))
pairs = book_ids.flatMap(lambda id: itertools.combinations(id,2))
proper_pairs = pairs.filter(lambda x: x[0] != x[1])
int_pairs = proper_pairs.map(lambda pair: (int(pair[0]),int(pair[1])))


pair_one_count = int_pairs.map(lambda pair: (pair, 1))
pair_count = pair_one_count.reduceByKey(lambda x, y: x+y)


highest_count = pair_count.filter(lambda x: x[1] > 20)


highest_count.saveAsTextFile("output")



