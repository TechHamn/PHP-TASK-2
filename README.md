# Backend work sample distributed workers
Delivery

Work in your own git and send us a link to your repo.
Restrictions

You should use vanilla PHP without any framework.
The assignment

In this exercise, you’ll write a distributed worker using a database table. The worker requests each URL inside the table and stores the resulting response code. Make sure you can run several workers in parallel. Each URL may only be requested once..

Please share the database table and data in your repository.
Example table

id 	url 	status 	http_code

1 	http://google.com 	DONE 	200

1 	http://www.reddit.com 	NEW 	null

Column definitions:

Column 	Description

id 	Stores an incrementing identifier for the job

url 	Stores a common URL

status 	Contains one of the values “NEW”, “PROCESSING”, “DONE” or “ERROR”.

http_code 	Stores the resulting HTTP­code from the request.

Definition of workflow:

    Get next available job
    Call the URL for the job
    Store the returned status

