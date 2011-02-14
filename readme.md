﻿KISSCMS - Content Management made Simple
=======================================

Created by: Makis Tracend (makis@makesites.cc)
URL: http://www.makesites.cc/projects/kisscms

Description
-----------
A CMS lightning fast to setup and easy to use - based on KISSCMS, the simple PHP MVC framework. The main goal was the creation of an environment to easily create new content on a website while lifting unecessary barriers od extension, found in most CMSs today. 

Setup
-----
- Extract the archive and place the content of the kisscms folder wherever you want your website. 
- Open "index.php" and update the paths according to your server setup. 
- Open a browser and enter the address of yout website - the sample content should already work with no further work.
- It is advisable to login to the cms straight away (user-pass: admin) 
- The top bar that appears is your main (and only control panel for the website). Click on configuration and change the website name and admin access. 

Usage
-----
The main.php controller is assigned to be the delivery controller for all database content. This means in the current implementation all your pages should start with the "main/" directory. Being based on KISSMVC means that you extend the website with your own controllers in any other way you want to. 

To create a page, simply enter the address, ex. "main/testpage" and in pure wiki-style, the prompt to create the new page will appear. To edit/delete a page you simply click on the corresponding topbar links, available when you are logged in as admin


Copyright
---------
This work is released under the terms of the GNU General Public License:
http://www.gnu.org/licenses/gpl-2.0.txt
