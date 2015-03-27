#Shoe Stores

###Assessment 4, Epicodus 03.27.2015

//description
//setup
//database commands

postgres

psql

CREATE DATABASE shoes;

\c shoes;

CREATE TABLE brands (id serial PRIMARY KEY, name varchar);

CREATE TABLE stores (id serial PRIMARY KEY, name varchar);

CREATE TABLE brands_stores (id serial PRIMARY KEY, brand_id int, store_id int);

CREATE DATABASE shoes_test WITH TEMPLATE shoes;

\c shoes_test;

//license
//copyright
