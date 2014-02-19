#!/bin/sh
prefix="/data/fakemail/mail"
numPath="/data/fakemail"

if [ ! -f $numPath/num ]; then
echo "0" > $numPath/num
fi
num=`cat $numPath/num`
num=$(($num + 1))
echo $num > $numPath/num
day=`date +%Y-%m-%d-%H-%M-%S-%N`
dir=`date +%Y-%m-%d`

name="$prefix/$dir/letter-$day-$num.txt"
mkdir -p -m777 -- $prefix/$dir
while read line
do
echo $line >> $name
done
chmod 777 $name
/bin/true