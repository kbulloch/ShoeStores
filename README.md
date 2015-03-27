#Shoe Stores

###Assessment 4, Epicodus 03.27.2015

//description

#####Description
This app lists shoe stores and their brands, using many to many relationship in
SQL databases.  A store can have many shoe brands and a brand can be stocked at
many stores.  The user can create, read, update and destroy stores.  The user
can create and read shoes.

#####Setup

Pre-requisites: Must have PHP installed.

These commands are for the user that chooses a Mac.  In your terminal, do:

git clone https://github.com/kbulloch/ShoeStores.git

cd ShoeStores/web

php -S localhost:8000

(then in a new window)

postgres

(then in a new tab)

psql

CREATE DATABASE shoes;

\c shoes;

CREATE TABLE brands (id serial PRIMARY KEY, name varchar);

CREATE TABLE stores (id serial PRIMARY KEY, name varchar);

CREATE TABLE brands_stores (id serial PRIMARY KEY, brand_id int, store_id int);

CREATE DATABASE shoes_test WITH TEMPLATE shoes;

\c shoes_test;

-----

Copyright (c) 2015 Kyle Bulloch

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
