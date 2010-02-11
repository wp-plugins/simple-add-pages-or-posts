<?php
/**
 * Simple add pages or posts.
 *
 * @category      Wordpress Plugins
 * @package       Plugins
 * @author        Simon Dirlik, Ramon Fincken
 * @copyright     Yes, Open source
 * @version       v 1.0
*/
if (!defined('ABSPATH'))
	die("Aren't you supposed to come here via WP-Admin?");

// We need DB connection
global $wpdb;

/**
 * If submiting the form
 */
if (isset ($_POST['submitbutton']) && isset ($_POST['postorpage'])) {
	if (!isset ($_POST['titles']) || !$_POST['titles']) {
		echo '<div id="message" class="error">No titles given</div>';
	} else {
		//Is magic quotes on?
		if (get_magic_quotes_gpc()) {
			// Yes? Strip the added slashes
			$_POST = array_map('stripslashes', $_POST);
		}

		//logic
		switch ($_POST['postorpage']) {
			case 'post' :
				$page_or_post = 'post';
				break;
			case 'page' :
				$page_or_post = 'page';
				break;
		}
		$i = 0;
		
		$author = 2; // Default admin user_id
		// Check user input
		$user_query = "SELECT ID, user_login, display_name, user_email FROM $wpdb->users WHERE ID = ".intval($_POST['author_id']) . " LIMIT 1";
		$users = $wpdb->get_results($user_query);
		foreach ($users AS $row) {
			// User found, replace value of $author
			$author = $row->ID;	
		}		
		
		
		// Foreach line
		$titles = explode("\n", $_POST['titles']);
		
		if(isset($page_or_post) && !empty($page_or_post))
		{
			foreach ($titles as $title) {
				
				// Remove spaces before and after titles
				$title = trim($title);
				// No empty title?
				if (!empty ($title)) {
					$i++;
					// Create post object
					$post = array ();
					$post['post_title'] = $title;
					$post['post_type'] = $page_or_post;
					$post['post_content'] = '';
					$post['post_status'] = 'publish';
					$post['post_author'] = $author;
					// http://www.ramonfincken.com/permalink/topic184.html					
					// Insert the post into the database
					wp_insert_post($post);
				}
			}
		}
		echo '<div id="message" class="updated fade">' . $i . ' new ' . $page_or_post . 's were made.</div>';
	}
}

?>

<br/>
<form id="form1" name="form1" method="post" action="" onsubmit="return confirm('Are you sure?')">
<table>
   <tr>
      <td>Post or page:</td>
      <td><select name="postorpage">
         <option value="page">Page</option>
         <option value="post">Post</option>
      </select></td>
   <tr>
   <tr>
      <td valign="top">Titles:<br/><small>Each new post/page on a new line</small></td>
      <td><textarea name="titles" rows="6" columns="60"></textarea></td>
   </tr>
   <tr>
      <td valign="top">Author of post/page:</td>
      <td>
      <select name="author_id">
		<?php
		
		$user_query = "SELECT ID, user_login, display_name, user_email FROM $wpdb->users ORDER BY ID ASC";
		$users = $wpdb->get_results($user_query);
		foreach ($users AS $row) {
			echo '<option value="'.$row->ID.'">'.$row->display_name. '</option>';	
		}
		?>
      </select>
      </td>
   </tr>   
</table>
<input type="submit" name="submitbutton" value="Submit"
   style="margin-top: 2px;"></form>
<h3>How to use?</h3>
<p class="updated">
* Choose what you want to add: posts or pages<br />
* Type the title of each post or page on a seperate line in the textarea<br />
</p>