Demo Calendar Slot Booking service, similar to that of Calendly, which allows people
to define their available slots on a day and other people to book them. <br />

<strong> base URL: http://3.7.36.29/api   <br />
Postman Collection Imort: https://www.getpostman.com/collections/62afb905b9512757eeeb  </strong> <br />

Available API details are mentioned below  <br />

Auth API's <br />

1. Register User <br />
Url: {{base_uri}}/auth/register <br />
Method : Post <br />
Parameters : name, email, mobile, password,password_confirmation  <br />

2. User Login  <br />
Url: {{base_uri}}/auth/login <br />
Method : Post <br />
Parameters : username, password <br />

3. Forgot Password  <br />
Url: {{base_uri}}/auth/forgot-password <br />
Method : Post <br />
Parameters : email_id <br />
Description : A password reset link will be sent to users email, the link will be client side application password reset form url with token. Token recived here will be used in set password API. <br />

4. Set Password   <br />
Url: {{base_uri}}/auth/set-password <br />
Method : Post <br />
Parameters : email_id, token, password <br />

5. Logout   <br />
Url: {{base_uri}}/auth/logout <br />
Method : Post <br />
Headers : Authorization Bearer {{access_token}} <br />

6. Auth Me <br />
Url: {{base_uri}}/auth/me <br />
Method : Post <br />
Headers : Authorization Bearer {{access_token}} <br />
Description : Retrive logged in user details  <br />

Calendly API's <br />

1. Create Slot <br />
Url: {{base_uri}}/calendar <br />
Method : Post <br />
Headers : Authorization Bearer {{access_token}} <br />
Parameters : date, time_slot <br />

2. Book Slot <br />
Url: {{base_uri}}/calendar/{{id}} <br />
Method : Post <br />
Headers : Authorization Bearer {{access_token}} <br />
Parameters : email ( This field is mandatory for non-registered users [without Authorization header] ) <br />

3. Delete Slot <br />
Url: {{base_uri}}/calendar/{{id}} <br />
Method : Delete <br />
Headers : Authorization Bearer {{access_token}} <br />

4. Get Slot Details  <br />
Url: {{base_uri}}/calendar/{{id}} <br />
Method : Get <br />

5. Get All Slots  <br />
Url: {{base_uri}}/calendar?status=available&scope= <br />
Method : Get <br />
Description : filter by status is available (Accepted values "available", "booked") and scope parameter with value created_by_me can be used get all slots created by a registered user (to use scope, Authorization header with token is required) <br />
