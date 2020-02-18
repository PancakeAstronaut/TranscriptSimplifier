#!/bin/bash

function count_down(){
  for((i=5; i > 0; i--)) ; do
    echo "$i..."
    sleep 1
  done
}

function nav_2_dir(){
  echo "Navigating to Deployment Location"
  cd ~/Desktop/app_deployments/CourseHistory
}

function build_files(){
  echo "Generating HTML Reports"
  php transScript.php
}

function open_and_delete(){
  echo "Giving the system time to process the files"
  echo "Opening Reports"
  count_down
  python3 ./openfiles.py
  echo "Beginning Record Disposal Process"
}

echo "#############################################################"
echo "# Welcome to the Course Display Widget                      #"
echo "# Runs a Job to display relevant transcript information     #"
echo "# PHP && Python                                             #"
echo "#############################################################"
nav_2_dir
build_files
open_and_delete

exit 0
