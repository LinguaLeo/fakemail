#!/bin/sh

FAKEMAIL_DIR=$1
if [ -z $FAKEMAIL_DIR]; then
    echo Please, specify the first argument like: "$0 PATH_TO_DIR"
    exit 2
fi

if [ ! -d "$FAKEMAIL_DIR" ]; then
    echo Directory "$FAKEMAIL_DIR" not exists
    exit 1
fi

prefix=$FAKEMAIL_DIR/mail

if [ ! -f $FAKEMAIL_DIR/num ]; then
    echo "0" > $FAKEMAIL_DIR/num
fi

num=`cat $FAKEMAIL_DIR/num`
num=$(($num + 1))
echo $num > $FAKEMAIL_DIR/num
day=`date +%Y-%m-%d-%H-%M-%S-%N`
dir=`date +%Y-%m-%d`

name="$prefix/$dir/letter-$day-$num.txt"

mkdir -p -m755 -- $prefix/$dir
while read line
do
    echo $line >> $name
done

chmod 755 $name
/bin/true