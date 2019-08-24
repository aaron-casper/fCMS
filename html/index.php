<head><meta name="viewport" content="width=device-width, initial-scale=1.0"></head>
<HTML>
<style type="text/css">
        html,body{
                border:none;padding:0;margin:2;
                background:#000000;
                color:#999999;
                margin: 0px;
}
        body{
                text-align:left;
                font-family:"Consolas",sans-serif;
}
        a{
                color:#AA7700;
}
        code{
                background:#999999;
                color:#000000;
                padding: 0px;
}
        h1{
                color:#AA7700;
}
</style>


<body>
<title>fCMS welcome page</title>
<h1>fCMS</h1>
<h2>fCMS, it's literally 5 files</h2>
<BR>
<?php
if(isset($_GET['postID'])) //look for ?postID=INT
{
$postID = $_GET['postID'];  //get postID if it exists
$db= new SQLite3('./db/content.db') or die ('cannot open database'); //database must be in ./db/content.db - /var/www/html/db/content.db when index.php is in /var/www/html/
$content = $db->query("SELECT * FROM posts WHERE id =" . $postID . ";") or die ("<H1><BR>HTTP error 418 - I'm a teapot!</H1><HR><BR><BR>  This isn't the content you're looking for<BR><BR><BR><a href='./index.php'>try the front page.</a>"); //select from database and provide return link to main page

while($row = $content->fetchArray()) //iterate through rows from DB (only 1 in this case)
{
	echo("<tr><td><H2>" . $row[1] . "</h2></td></tr><BR><tr><td>" . $row[2] . "</td></tr>"); //painful table generator, keeps content arranged neatly
	echo("<BR><HR>"); // break between posts (remove <HR> to get rid of the line
}
$db->close();  //close the DB
}
else // if no postID provided, get the top 10
{
echo "<BR><HR><tablel border=1 color='#660000' cellspacing=1 cellpadding=2>"; //start table for content handler
$db= new SQLite3('./db/content.db') or die ('cannot open database'); //open db
$content = $db->query("SELECT * FROM posts ORDER BY id DESC LIMIT 10;"); //db query, gets top 10 most recent
while($row = $content->fetchArray()){ //iterate through rows
echo("<tr><td><H2>" . $row[1] . "</h2></td></tr><BR><tr><td>" . $row[2] . "</td></tr>"); //build content table, keeps things aligned
echo("<BR><HR>"); //break between posts, same as above
}
$db->close(); //close the db
}
?>
</body>
</html>
