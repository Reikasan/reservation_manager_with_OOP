# [reservation_manager_with_OOP](https://reservation-manager.reikaakuzawa.com/)
I'm reconstructing Reservation-Manager site with OOP concept

This Site is connected with [Sample Bar Site](https://sample-bar.reikaakuzawa.com/). You can make reservations from Bar Site and manage it here!
![reservation_manager_screenshot](https://user-images.githubusercontent.com/68085523/167089689-009bf759-55af-458b-88d2-cf1fe1aae866.jpg)

# Features

## 1. Flexible search option
[check it here!](https://reservation-manager.reikaakuzawa.com/reservation.php)
![rm_searchbar_screenshot](https://user-images.githubusercontent.com/68085523/171366584-0ab64ec9-b65d-4c42-847b-af59723dfb4d.jpg)
  - Combination with search word and filter options.
  - Search word is used regexp checking to prevent 'No Result' error.
  - Easy clear search filter function. Only click close button from search filters, shows new search result.
  
  
## 2. Calendar Page
[check it here!](https://reservation-manager.reikaakuzawa.com/calendar.php)
  ![rm_calendar_screenshot](https://user-images.githubusercontent.com/68085523/171368476-c27a5bb4-3790-4ff4-a046-f0bb8c395f3c.jpg)
  - With Calendar Format, easy to check the reservations.
  - This Calendar created by PHP foreach loop.


## 3. Asynclonus Flag function 
[check it here!](https://reservation-manager.reikaakuzawa.com/reservation.php)
  - To change the flag color, doesn't need to refresh page.


## 4. Login/Forgot Password Page
[check it here!](https://reservation-manager.reikaakuzawa.com/reservation.php)
  - No need real Email address to try forgot password function!
  - You can try to change password and doesn't affect login function.
  (This page saves unhashed password only for demonstration purpose) 
  
# What's next
I'm planning to add user page, customer page, and setting page to change some setting by user.
