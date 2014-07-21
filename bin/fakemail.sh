#!/bin/sh

FAKEMAIL_DIR=$1
if [ -z $FAKEMAIL_DIR ]; then
    echo Please, specify the first argument like: "$0 PATH_TO_DIR"
    exit 2
fi

if [ ! -d "$FAKEMAIL_DIR" ]; then
    echo Directory "$FAKEMAIL_DIR" not exists
    exit 1
fi

day=`date +%Y-%m-%d-%H-%M-%S-%N`
prefix=`date +%Y-%m-%d`

name="$FAKEMAIL_DIR/$prefix/letter-$day.txt"

mkdir -p -m755 -- $FAKEMAIL_DIR/$prefix
while read line
do
    echo $line >> $name
done

chmod 755 $name
/bin/true
