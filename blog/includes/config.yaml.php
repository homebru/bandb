<?php header("Status: 403"); exit("Access denied."); ?>
---
sql: 
  host: "localhost"
  username: "bodhilog_bandb"
  password: "bandb"
  database: "bodhilog_bandb"
  prefix: "chyrp_"
  adapter: "mysql"
name: "Inn Strategy Blog"
description: 
url: "http://bandb.bodhilogic.com/blog"
chyrp_url: "http://bandb.bodhilogic.com/blog"
feed_url: 
email: "bodhilogic@gmail.com"
locale: "en_US"
theme: "stardust"
posts_per_page: 5
feed_items: 20
clean_urls: false
post_url: "(year)/(month)/(day)/(url)/"
timezone: "America/Los_Angeles"
can_register: true
default_group: 2
guest_group: 5
enable_trackbacking: true
send_pingbacks: false
enable_xmlrpc: true
enable_ajax: true
uploads_path: "/uploads/"
enabled_modules: 
enabled_feathers: 
  - "text"
routes: 
secure_hashkey: "d867813210b8ef5b83d68f9346717c67"
