#!/bin/bash
#echo "in logger"

version=`date +%m_%d_%Y`

rel_file="/home/ashpjin/public_html/classify/text_files/relevant_tweets.txt"
irrel_file="/home/ashpjin/public_html/classify/text_files/irrelevant_tweets.txt"
inapp_file="/home/ashpjin/public_html/classify/text_files/inappropriate_tweets.txt"

# keep the data
### Relevant Tweets ###
filename="/home/ashpjin/public_html/classify/data_versions/relevant/relevant_tweets_${version}.txt"
if [ -f $filename ];
then
	cat $rel_file >> $filename
else
	touch $filename
	cp $rel_file $filename
fi

### Irrelevant Tweets ###
filename="/home/ashpjin/public_html/classify/data_versions/irrelevant/irrelevant_tweets_${version}.txt"
if [ -f $filename ];
then
    cat $irrel_file >> $filename
else
	touch $filename
	cp $irrel_file $filename
fi

### Inappropriate Tweets ###
filename="/home/ashpjin/public_html/classify/data_versions/inappropriate/inappropriate_tweets_${version}.txt"
if [ -f $filename ];
then
    cat $inapp_file >> $filename
else
    touch $filename
    cp $inapp_file $filename
fi

# clear out the original files
> $rel_file
> $irrel_file
> $inapp_file
