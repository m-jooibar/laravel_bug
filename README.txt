I have been developed two logs command .
1- logs:read that require ( log file  )

Please run this command first to insert logs to database from file :
log file = "log.txt"
This log file has been located in address : "storage\app\logs\lox.txt"
===================================
2- logs:read that require ( log url )
log url = "http://localhost:8000/api/logs?serviceName=getUserLists&statusCode=301&startDate=2020-12-01%2012:30:01&endDate=2020-12-02%2012:30:01"
===================================

So we can run this commands :

php artisan logs:read log.txt
php artisan logs:read "http://localhost:8000/api/logs?serviceName=getUserLists&statusCode=301&startDate=2020-12-01%2012:30:01&endDate=2020-12-02%2012:30:01"

If we run below command
php artisan logs:read "http://localhost:8000/api/logs?serviceName=getUserLists&statusCode=301&startDate=:)&endDate=:)"
we will receive error .

The endpoint for fetch logs is : http://localhost:8000/api/logs
you can filter the logs by add some filter to url like :

http://localhost:8000/api/logs?serviceName=getUserLists&statusCode=301&startDate=2020-12-01%2012:30:01&endDate=2020-12-02%2012:30:01
http://localhost:8000/api/logs?serviceName=getUserLists&statusCode=301
http://localhost:8000/api/logs?serviceName=getUserLists
http://localhost:8000/api/logs

=======================
***********************
IMPORTANT NOTE
***********************
I made a mistake and I know it myself.
In the filter for the time intervals 
I should have put the time between the time intervals. But unfortunately, 
I set the time equal to the filter value. 
The time I spent on this project was more than 5 hours. 
Almost 6 hours. That's why I didn't try to fix that mistake. 
Thank you