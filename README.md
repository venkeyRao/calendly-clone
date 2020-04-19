Demo Calendar Slot Booking service, similar to that of Calendly, which allows people
to define their available slots on a day and other people to book them.

Available API details are mentioned below 

Auth API's

1. Register User
Url: {{base_uri}}/auth/register
Method : Post
Parameters : name, email, mobile, password,password_confirmation 

2. User Login 
Url: {{base_uri}}/auth/login
Method : Post
Parameters : username, password

3. Forgot Password 
Url: {{base_uri}}/auth/forgot-password
Method : Post
Parameters : email_id
Description : A password reset link will be sent to users email, the link will be client side application password reset form url with token. Token recived here will be used in set password API.

4. Set Password  
Url: {{base_uri}}/auth/set-password
Method : Post
Parameters : email_id, token, password

5. Logout  
Url: {{base_uri}}/auth/logout
Method : Post
Headers : Authorization Bearer {{access_token}}

6. Auth Me
Url: {{base_uri}}/auth/me
Method : Post
Headers : Authorization Bearer {{access_token}}
Description : Retrive logged in user details 

Calendly API's

1. Create Slot
Url: {{base_uri}}/calendar
Method : Post
Headers : Authorization Bearer {{access_token}}
Parameters : date, time_slot

2. Book Slot
Url: {{base_uri}}/calendar/{{id}}
Method : Post
Headers : Authorization Bearer {{access_token}}
Parameters : email ( This field is mandatory for non-registered users [without Authorization header] )

3. Delete Slot
Url: {{base_uri}}/calendar/{{id}}
Method : Delete
Headers : Authorization Bearer {{access_token}}

4. Get Slot Details 
Url: {{base_uri}}/calendar/{{id}}
Method : Get

5. Get All Slots 
Url: {{base_uri}}/calendar?status=available&scope=
Method : Get
Description : filter by status is available (Accepted values "available", "booked") and scope parameter with value created_by_me can be used get all slots created by a registered user (to use scope Authorization header with token is required)
