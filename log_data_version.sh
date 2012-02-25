#!/bin/bash
version=`date +%m_%d_%Y`

# keep the data
filename="data_versions/relevant/relevant_tweets_${version}.txt"
touch $filename
cp relevant_tweets.txt $filename
filename="data_versions/irrelevant/irrelevant_tweets_${version}.txt"
touch $filename
cp irrelevant_tweets.txt $filename
filename="data_versions/inappropriate/inappropriate_tweets_${version}.txt"
touch $filename
cp inappropriate_tweets.txt $filename

# clear out the original files
> relevant_tweets.txt
> irrelevant_tweets.txt
> inappropriate_tweets.txt

