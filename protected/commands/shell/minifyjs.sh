#!/bin/bash
baseDir=$(cd "$(dirname "$0")"; pwd);

siteBase=$baseDir/../../..;
mainPhp=$siteBase/protected/views/layouts/main-debug.php;
outjs=$siteBase/dist/app/tp-all.js;

jsFiles=`fgrep script $mainPhp | fgrep dist | fgrep .js | cut -d ? -f3 | cut -d'>' -f2 | cut -d'"' -f1`;
cmd="java -jar /opt/installPackage/compiler/compiler.jar --js_output_file=$outjs"
for i in $jsFiles; do
	cmd="$cmd --js=$siteBase$i ";
done;
echo $cmd;
# compile
echo '[START COMPILE >>>]'
`$cmd`;
