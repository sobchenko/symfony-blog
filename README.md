Symfony - Blog
====

A Symfony project created on November 20, 2016, 9:02 pm.

####To start project from scratch use:
* composer install
* php app/console doctrine:database:create
* php app/console doctrine:schema:create

_!!! Important:_ After initialization just open home page

---
Possible blog structure:

###posts
  * post_id (identity)
  * post_date (datetime)
  * post_author_id (int FK to users)
  * post_approved (int)
  * post_status (int)
  * post_type (varchar)
  * post_avg_rank (float)
  * post_comments (int)
  * deleted_at (datetime)
  * updated_at (datetime )
  * created_at (datetime)

###post_details
  * post_detail_id (identity)
  * post_id (FK to posts)
  * post_title  (varchar)
  * post_description (text)
  * post_content (longtext)
  * post_published (int, only one post_details can be active for one post)
  * post_author_id (int FK to users)
  * deleted_at (datetime)
  * updated_at (datetime )
  * created_at (datetime)

###post_ranks
  * post_id (FK to posts)
  * user_id (int FK to users)
  * user_post_rank (float)
  * deleted_at (datetime)
  * updated_at (datetime )
  * created_at (datetime)

###comments
  * comment_id (identity)
  * post_id (FK to posts)
  * comment (text)
  * comment_user_id (int FK to users)
  * comment_approved (int)
  * comment_like_count (int)
  * deleted_at (datetime)
  * updated_at (datetime )
  * created_at (datetime)

###users
  * user_id (identity)
  * confirmed (int)
  * first_name (varchar)
  * last_name (varchar)
  * user_avatar (varchar)
  * user_email (varchar)
  * user_phone (varchar)
  * user_city (varchar)
  * user_country (varchar)
  * user_role (varchar)
  * user_email (varchar)
  * user_password (varchar, hashed pass)
  * deleted_at (datetime)
  * updated_at (datetime )
  * created_at (datetime)

###tags
  * tag_id (identity)
  * tag_name (varchar)
  * tag_type (varchar) (possible types: city, country, group, internal tags, etc...)
  * deleted_at (datetime)
  * updated_at (datetime )
  * created_at (datetime)

###comment_tags
  * comment_id (int FK to comments)
  * tag_id (int FK to tags)
  * deleted_at (datetime)
  * created_at (datetime)

###post_tags
  * comment_id (int FK to posts)
  * tag_id (int FK to tags)
  * deleted_at (datetime)
  * created_at (datetime)

###user_tags
  * user_id (int FK to users)
  * tag_id (int FK to tags)
  * deleted_at (datetime)
  * created_at (datetime)

###user_activity
  * activity_id (identity)
  * activity_type (varchar)
  * user_id (int FK to users)
  * created_at (datetime)
