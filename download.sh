#!/bin/sh

FILE=$1

scp ubuntu@mycomicslist.datapoint.rs:/home/olja/public/images/comics/$FILE \
	./public/images/comics/

