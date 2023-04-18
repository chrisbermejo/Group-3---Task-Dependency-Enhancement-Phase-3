use projectdb;
create table project 
    (projectid int unsigned not null auto_increment primary key,
    title varchar(100) not null,
    description text not null,
    date_entered DATETIME not null)
    character set utf8mb4;
create table team
    (teamid int unsigned not null auto_increment primary key,
    name varchar(100) not null)
    character set utf8mb4;
create table member
    (memberid int unsigned not null auto_increment primary key,
    name varchar(100) not null)
    character set utf8mb4;
create table team_member
    (teamid int unsigned not null,
     memberid int unsigned not null,
     role text not null)
    character set utf8mb4;
create table task
    (taskid int unsigned not null auto_increment primary key,
    title varchar(100),
    description text,
    projectid int unsigned not null,
    memberid int unsigned not null,
    date_start datetime not null,
    date_target datetime not null,
    date_actual_start datetime default null,
    date_actual_completion datetime default null)
    character set utf8mb4;
