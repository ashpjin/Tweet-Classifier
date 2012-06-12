#!/bin/bash

random_suffix="$VAR1"
full_data_filename="full_data_$random_suffix.mallet"
user_data_filename="user_data_$random_suffix.mallet"
full_classifier_filename="full_relevancy_$random_suffix.classifier"
user_classifier_filename="user_relevancy_$random_suffix.classifier"

relevant_datapath="/home/ashpjin/public_html/classify/data_versions/relevant"
irrelevant_datapath="/home/ashpjin/public_html/classify/data_versions/irrelevant"
relevant_user_datapath="/home/ashpjin/public_html/classify/text_files/user/relevant/relevant_$random_suffix.txt"
irrelevant_user_datapath="/home/ashpjin/public_html/classify/text_files/user/irrelevant/irrelevant_$random_suffix.txt"
word_filter_path="/home/ashpjin/word_filters/stop_word_filter/lucene_stopword_list.txt"

test_data_filepath="/home/ashpjin/public_html/classify/text_files/user/datafiles/test_data_$random_suffix.txt"
results_filepath="/home/ashpjin/public_html/classify/text_files/user/results/"

cd ~/mallet-2.0.7

### create .mallet file using all data ###
bin/mallet import-dir --input $relevant_datapath $irrelevant_datapath --stoplist-file $word_filter_path --output $full_data_filename

### create classfifier using full data ###
bin/mallet train-classifier --input $full_data_filename --output-classifier $full_classifier_filename --trainer MaxEnt;

### classify using the full data ###
full_results="$results_filepath/full_results_$random_suffix.txt"
bin/mallet classify-file --input $test_data_filepath --output $full_results --classifier $full_classifier_filename
echo "hello here"
### create user .mallet file ###
#bin/mallet import-dir --input $relevant_user_datapath $irrelevant_user_datapath --stoplist-file $word_filter_path --output $user_data_filename

### create classifier using user data only
#bin/mallet train-classifier --input $user_data_filepath --output-classifier $user_classifier_filename --trainer MaxEnt;

### classify using the user data ###
user_results="$results_filepath/user_results_$random_suffix.txt"
#bin/mallet classify-file --input $test_data_filepath --output $user_results --classifier $user_classifier_filename


# get rid of the .mallet and classifiers
#rm $full_data_filename
#rm $user_data_filename
#rm $full_classifier_filename
#rm $user_classifier_filename

#rm $relevant_user_datapath
#rm $irrelevant_user_datapath

