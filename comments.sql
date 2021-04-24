Drop database if exists comments;
Create database comments;
Use comments;

Drop table if exists comments;
Create table if not exists comments (
  	id int(11) not null auto_increment,
  	content longtext not null,
  	parent_id int(11) not null default 0,
  	post_id int(11) default null,
  	depth int(11) not null default 0,
  	primary key (id),
  	KEY post_id (post_id)
) ENGINE=InnoDB;
