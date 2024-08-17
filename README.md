# **Hospital Management System**

Hospital Management System using MySQL, PHP, HTML, CSS

## **Need to work on:**

1. Ability to accept the appointment by the doctor to acknowledge the patient that their appointment has been approved.
2. Implementation of export button in admin module to export all details to an excel sheet.
3. Implementation of Bill payment receipt in patient module.

## **Prerequisites**

1. Install XAMPP web server
2. Any Editor (Preferably VS Code or Notepad++)
3. Any web browser with latest version

## **Languages and Technologies used**

1. HTML5/CSS3
2. JavaScript (to create dynamically updating content)
3. Bootstrap (An HTML, CSS, and JS library)
4. XAMPP (A web server by Apache Friends)
5. PHP
6. MySQL (An RDBMS that uses SQL)
7. Jquery (used for datatables)

## **Steps to run the project in your machine**

1. Download and install XAMPP in your machine
2. Clone or download the repository
3. Extract all the files and move it to the 'htdocs' folder of your XAMPP directory.
4. Start the Apache and Mysql in your XAMPP control panel.
5. Open your web browser and type 'localhost/phpmyadmin'
6. In phpmyadmin page, create a new database from the left panel and name it as 'medicare'
7. Import the file 'medicare.sql' inside your newly created database and click ok.
8. Open a new tab and type 'localhost/foldername' in the url of your browser
9. Hurray! That's it!

## **SOFTWARES USED**

- XAMPP was installed and APACHE2 Server and MySQL were initialized. And, files were built inside opt/xampp/htdocs/medicare
- VScode was used as a text editor.
- Google Chrome was used to run the project (localhost/medicare was used as the url).

### **Starting Apache And MySQL in XAMPP:**

The XAMPP Control Panel allows you to manually start and stop Apache and MySQL. To start Apache or MySQL manually, click the ‘Start’ button under ‘Actions’.

<img src="https://github.com/user-attachments/assets/2f03cd76-dd23-4d9d-a453-0aa1bf69943a" alt="1" width="500" />

## **GETTING INTO THE PROJECT:**

Hospital Management System in php and mysql. This system has a ‘Home’ page from where the patient, doctor & admin can login into their accounts. Fig 1.1 shows the ‘Home’ page of our project.

<img src="https://github.com/user-attachments/assets/5a128692-8494-46d1-9064-64ad8733a389" alt="2" width="600" />

The ‘Home’ page consists of 3 modules:

1. Patient Module
2. Doctor Module
3. Admin Module

### **Patient Module:**

This module allows patients to create their account, book an appointment to see a doctor and see the available slots for a doctor. The registration page(in the home page itself) asks patients to enter their Name, Username, Email ID, DOB, Phone Number, radio buttons to select their gender, Address, and Password.

<img src="https://github.com/user-attachments/assets/ef16a8e0-b201-40e2-83bc-5434a9416323" alt="3" width="600" />

Once the patient has created his/her own account after clicking the ‘Register’ button, then he will be redirected to login page(Fig 1.3).

<img src="https://github.com/user-attachments/assets/2ddb8b16-0852-4095-97a8-c5bfa8e963a5" alt="4" width="600" />

Then the patient will be redirected to his/her dashboard.

<img src="https://github.com/user-attachments/assets/d981f190-bcb5-4c29-877c-829605087587" alt="5" width="600" />

The Dashboard page allows patients to perform five operations:

1. **Update details:**
    
    Here, the patients can able to update their details.
    
    <img src="https://github.com/user-attachments/assets/feb8d74c-9974-4832-9b51-3981f17d9899" alt="6" width="600" />

    
2. **Book his/her appointment:**
    
    Here, the patients can able to book their appointments to see a doctor. The appointment form(Fig 1.6) requires patients to select the doctor that they want to see, Date and Time that they want to meet with the doctor.
    
    <img src="https://github.com/user-attachments/assets/c95d8dde-2d11-4504-ad26-b870fec25bd6" alt="7" width="600" />

    
    After clicking on the ‘Book’ button, the patient will receive an alert that acknowledges the successful appointment of the patient.(See Fig 1.7)
    
    <img src="https://github.com/user-attachments/assets/9e76b89b-e40e-4ae4-a5f3-242b8bd75397" alt="8" width="600" />

    
3. **View patients’ Appointment History:**
    
    Here, the patient can see their appointment history which contains Doctor Name, Appointment Date and Time.
    
    The patient can even cancel the appointment if required by clicking on ‘cancel’ button.(See Fig 1.8).
    
    <img src="https://github.com/user-attachments/assets/c7b5fa9d-48b5-4c53-be99-29f4f7a25a9f" alt="9" width="600" />

    
4. **Search doctor:** 
    
    Here the patients can search for the doctor if required.(See Fig 1.9)
    
    <img src="https://github.com/user-attachments/assets/30a47025-c483-4011-a9d8-cbf6a6b5b506" alt="10" width="600" />

    
    Here ‘Book appointment’ button is also provided to directly book their appointment from this page.
    
5. **Feedback:**
    
    ‘Feedback’ page allows users to provide feedback or queries about the services of the hospital. Fig 1.10 shows the ‘Feedback’ page.
    
    <img src="https://github.com/user-attachments/assets/d38582e6-1bed-453c-a69f-e0f6b9e5eee0" alt="11" width="600" />

    
    The patient can also see the notifications in this page where if can get notified if the doctor cancels the appointment.
    
    <img src="https://github.com/user-attachments/assets/93ee9fe3-375b-4408-bfc7-0d3a4c514941" alt="12" width="600" />

This is how the patient module works. On the whole, this module allows patients to register their account or login their account(if he/she has one), book an appointment and view his/her appointment history.

### **Doctor Module:**

The doctors can login into their account which can be done by selecting ‘Doctor’ option in login page. Fig 1.11 shows the login form for a doctor. Registration of a doctor account can be done only by admin. We will discuss more about this in Admin Module.

<img src="https://github.com/user-attachments/assets/7b62fbdc-9aa1-49de-97fd-b1058a6311c3" alt="13" width="600" />

Once the doctor clicking the ‘Login’ button, they will be redirected to their own dashboard which is shown in Fig 1.12

<img src="https://github.com/user-attachments/assets/ecd1286a-25fb-43ab-a688-2bd704bc907a" alt="14" width="600" />

The Dashboard page allows doctors to perform three operations:

1. **Update details:**
    
    Here, the patients can able to update their details.
    
    <img src="https://github.com/user-attachments/assets/1eba3153-e9fe-4244-8688-d9ab114a2421" alt="15" width="600" />

    
2. **View doctors’ Appointments:**
        
    In this page, doctor can able to see their appointments which has been booked by the patients. Fig 1.14 shows the appointment of the doctor ‘Dinesh’ which has been booked by the patient ‘Sohana’. This means that the doctor ‘Dinesh’ will have an appointment with the patient ‘Sohana’ on mentioned date.
        
    And doctor can cancel the appointment if required.
        
    <img src="https://github.com/user-attachments/assets/ffe52035-e7b1-4243-a1a8-4e6e20441e1b" alt="16" width="600" />

    
    In real-time, the doctors will have thousands of appointments. It will be easier for a doctor to search for appointment in the case of more appointments.
    

3. **Leave Scheduler:**

    Here doctor can request for a leave to admin.

   <img src="https://github.com/user-attachments/assets/f70d4014-9dfe-48bd-aa91-73b855b4bbb1" alt="17" width="600" />


Once everything is done, the doctor can logout of their account. Thus, in general, a doctor can login into his/her account, view their appointments and search for a patient. This is all about Doctor Module.

### **Admin Module:**

 This module is the heart of our project where an admin can see the list of all patients. Doctors and appointments and the feedback/queries received from the ‘Feedback’ page. Also admin can add doctor too. 

 Login into admin account can be done by selecting ‘Admin’ option in login page. Fig 1.16 shows the login page for admin.       username: admin, password: admin123

<img src="https://github.com/user-attachments/assets/7e30c6d5-5f28-4610-be76-b2b98dd275cb" alt="18" width="600" />

On clicking the ‘Login’ button, the admin will be redirected to his/her dashboard as shown in Fig 1.17.

<img src="https://github.com/user-attachments/assets/cf68e891-81e0-4978-b5f3-3c2776496e39" alt="19" width="600" />


This module allows admin to perform six major operations:

1. **Add Doctor:**
    
    Admin alone can add a new doctor since anyone can register as a doctor if we put this section on the home page. This form asks Doctor’s Name, Photo, Email ID, Username, Phone number, Languages known, Address, and Password.(See Fig 1.18)

   <img src="https://github.com/user-attachments/assets/50e70877-8e28-4665-aa87-2a5c88898108" alt="20" width="600" />

    
    After adding a new doctor, if we check the doctor’s list, we will see the details of new doctor is added to the list
    

**2. View the list of all doctors:**

Details of the doctors can also be viewed by the admin. This details include the Name of the doctor, Email, Username, Phone number, Languages known, Address as shown in Fig 1.19. Searching for a doctor can be done by search box provided.

<img src="https://github.com/user-attachments/assets/d58dd1d7-37cc-449f-a6b8-e74496f00bb6" alt="21" width="600" />

1. **View the list of all patients registered:**
    
    Admin can able to view all the patients registered. This includes the patients’ Name, Email ID, Username, Phone Number, Address. (See Fig 1.20).As like in doctor module, admin can also search for a patient by providing any of their details in the search box.

   <img src="https://github.com/user-attachments/assets/e5f44914-b19f-4100-831b-5f7920022738" alt="22" width="600" />

    
1. **View the Appointment lists:**
    
     Admin can also able to see the entire details of the appointment that shows the appointment details of the patients with their respective doctors. This includes the First Name, Last Name, Email and Contact Number of patients, doctor’s name, Appointment Date, Time. (See Fig 1.21).

    <img src="https://github.com/user-attachments/assets/de1c5f76-f5a0-4406-b6cc-5b72378858f8" alt="23" width="600" />

    
2. **Set Schedule:**
    
    Here the admin will able to either accept or reject the request for the leave which is requested by the doctor in 1.15.

    <img src="https://github.com/user-attachments/assets/2a5c5cb9-1bf5-45cc-8c68-c5e6b974d102" alt="24" width="600" />

    
3. **View User’s feedback/Queries:**
    
    Admin is allowed to view the feedback/Query that has been given by the user in the ‘Feedback’ page (Refer Fig 1.10). 

    <img src="https://github.com/user-attachments/assets/4121c84e-ad68-43f4-8adb-ca034aee32b4" alt="25" width="600" />

Taking everything into consideration, admin can able to view the details of patients and doctors, appointment details, Feedback by the user and can add a new doctor. Once everything is done, the admin can logout from his account.

