@echo off
set /p id="Enter commit details: "
git add .
git commit -m !id!
git push origin master
doskey /history
pause