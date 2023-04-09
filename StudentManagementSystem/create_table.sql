#create database sms;
use sms2;
create table student(
	Dep varchar(255),
    Course varchar(255),
    Year varchar(255) ,
    Semester varchar(255),
    Student_id varchar(255) primary key,
    Name varchar(255),
    Division varchar(255),
    Roll varchar(255),
    Gender varchar(255),
    Dob varchar(255),
    Email varchar(255),
    Phone varchar(255),
    Address varchar(255),
    Advisor varchar(255)
);
