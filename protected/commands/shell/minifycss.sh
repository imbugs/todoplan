baseDir=$(cd "$(dirname "$0")"; pwd);
siteBase=$baseDir/../../..;
outcss=$siteBase/dist/app/tp-main.css;
rm -rf $outcss;
rm -rf $siteBase/../dist
cp -r $siteBase/dist $siteBase/../dist

wget -O $outcss 'http://localhost/min/b=dist&f=bootstrap/css/bootstrap.css,bootstrap/css/bootstrap-responsive.css,pnotify/css/jquery.pnotify.default.css,app/css/wunderlist.css,app/css/screen.css,app/css/main.css'
