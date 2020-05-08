# Introduction and Motivation

PlantPro is an application designed for helping field botanists and plant enthusiasts document sightings of new or existing plants. It provides a platform, similar to reddit, for submitting pictures and sighting locations for different plant while allowing users to engage with and provide feedback for these submissions. PlantPro was originally created as a final project for Dr. Matthew Stephan's Software Engineering course at Miami University. PlantPro is open source software licensed under the MIT License. 

# Getting Started

PlantPro is designed using Laravel, and is meant to run on an Ubuntu server (we the latest release, but it's up to you). In order to install PlantPro:
   1.  Get Ubuntu running on your machine or on a virtual machine if you don't already have it
   2.  [Download our build script](https://raw.githubusercontent.com/rudiejd/PlantPro/master/build/init.sh) (right click that link, save as, save it as init.sh).
   3. Navigate to the folder where you downloaded our script in terminal and run `sudo bash init.sh`.
   4. If everything is working correctly, you should receive notification from the script that PlantPro is up and running.
   5. Navigate to http://localhost in your browser to view the PlantPro website
   6. Create the first account for this website. We have this account set up with administrator privileges by default.
   7. Enjoy! Further user documentation can be found in the docs folder of this repository and developer documentation can be found as comments within our code. Feel free to modify the starting code to your liking. 
  
 # Permissions System Explanation
 
 For our default implementation of PlantPro, we chose to have four different permission levels:
 1. Admin: Can delete entire plants, promote moderators, demote moderators, promote administrators, and do everything that moderators can
 2. Moderator: Can delete anyone's plant submissions (posts about plants) and delete anyone's comments on plant submissions, and do everything that users can. Can be promoted to become an administrator
 3. User: Can create plant submissions, create plants, delete their own submissions, delete their own comments, and do everything guest can. Can be promoted to become a moderator or administrator.
4. Guest: Anyone who visits the site without logging in. Can view plants, plant submissions, and comments on plant submissions and search for plant submissions. Can register to become a user.
   
 If you want to use our software but don't like these permissions, feel free to change this permission scheme. We just thought that it would be useful to include this as a default. 
 
# Process Artifacts

Since this project was made for a software engineering class, we documented our progress in every iteration with a burndown chart and an agenda that we shared with a teaching assistant, who acted as our customer. You can view our process artifacts from each iteration in this project in a public google drive folder [here](https://drive.google.com/drive/folders/1jdhD_nS74_tMKVJsdqHthUxQ7yr7pQgN?usp=sharing)
 
 # Screenshots
 ## Administration page
 ![Administration page](https://i.imgur.com/rALzK3x.png)
 ## Example submission
 ![Example Submission](https://i.imgur.com/Oxlsa12.png)
 ## Submissions page (paginated every 15 entries)
![Submissions Page with Pagination](https://i.imgur.com/YbC133P.png)
## Search page with advanced options
![Search Page](https://i.imgur.com/NVYfryT.png)


