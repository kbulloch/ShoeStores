--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: brands; Type: TABLE; Schema: public; Owner: Guest; Tablespace: 
--

CREATE TABLE brands (
    id integer NOT NULL,
    name character varying
);


ALTER TABLE brands OWNER TO "Guest";

--
-- Name: brands_id_seq; Type: SEQUENCE; Schema: public; Owner: Guest
--

CREATE SEQUENCE brands_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE brands_id_seq OWNER TO "Guest";

--
-- Name: brands_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: Guest
--

ALTER SEQUENCE brands_id_seq OWNED BY brands.id;


--
-- Name: brands_stores; Type: TABLE; Schema: public; Owner: Guest; Tablespace: 
--

CREATE TABLE brands_stores (
    id integer NOT NULL,
    brand_id integer,
    store_id integer
);


ALTER TABLE brands_stores OWNER TO "Guest";

--
-- Name: brands_stores_id_seq; Type: SEQUENCE; Schema: public; Owner: Guest
--

CREATE SEQUENCE brands_stores_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE brands_stores_id_seq OWNER TO "Guest";

--
-- Name: brands_stores_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: Guest
--

ALTER SEQUENCE brands_stores_id_seq OWNED BY brands_stores.id;


--
-- Name: stores; Type: TABLE; Schema: public; Owner: Guest; Tablespace: 
--

CREATE TABLE stores (
    id integer NOT NULL,
    name character varying
);


ALTER TABLE stores OWNER TO "Guest";

--
-- Name: stores_id_seq; Type: SEQUENCE; Schema: public; Owner: Guest
--

CREATE SEQUENCE stores_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE stores_id_seq OWNER TO "Guest";

--
-- Name: stores_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: Guest
--

ALTER SEQUENCE stores_id_seq OWNED BY stores.id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: Guest
--

ALTER TABLE ONLY brands ALTER COLUMN id SET DEFAULT nextval('brands_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: Guest
--

ALTER TABLE ONLY brands_stores ALTER COLUMN id SET DEFAULT nextval('brands_stores_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: Guest
--

ALTER TABLE ONLY stores ALTER COLUMN id SET DEFAULT nextval('stores_id_seq'::regclass);


--
-- Data for Name: brands; Type: TABLE DATA; Schema: public; Owner: Guest
--

COPY brands (id, name) FROM stdin;
17	Niwell
18	Frezon
19	Kilkenny
20	Newberry
21	Howitzer
22	BladeRollers
\.


--
-- Name: brands_id_seq; Type: SEQUENCE SET; Schema: public; Owner: Guest
--

SELECT pg_catalog.setval('brands_id_seq', 22, true);


--
-- Data for Name: brands_stores; Type: TABLE DATA; Schema: public; Owner: Guest
--

COPY brands_stores (id, brand_id, store_id) FROM stdin;
1	1	2
2	2	1
3	2	8
4	2	11
5	2	12
6	3	17
7	4	17
8	5	17
9	2	17
10	1	17
11	1	15
12	1	18
13	10	22
14	11	22
15	12	22
16	11	22
17	11	22
18	11	22
19	11	22
20	11	22
21	11	22
22	11	22
23	11	22
24	13	22
25	14	22
26	16	24
27	15	24
28	16	23
29	16	24
30	16	26
31	17	27
32	17	28
33	18	28
34	18	29
35	19	29
36	19	28
37	20	28
38	18	30
39	18	31
40	18	32
41	21	27
42	21	33
43	22	33
44	22	34
45	18	34
46	19	34
47	17	35
\.


--
-- Name: brands_stores_id_seq; Type: SEQUENCE SET; Schema: public; Owner: Guest
--

SELECT pg_catalog.setval('brands_stores_id_seq', 47, true);


--
-- Data for Name: stores; Type: TABLE DATA; Schema: public; Owner: Guest
--

COPY stores (id, name) FROM stdin;
31	Biggletons
32	Tomhattan
33	Lazers and Fazors
34	Brons
30	Furnburrey
35	ZigZag Reselling LLC
\.


--
-- Name: stores_id_seq; Type: SEQUENCE SET; Schema: public; Owner: Guest
--

SELECT pg_catalog.setval('stores_id_seq', 35, true);


--
-- Name: brands_pkey; Type: CONSTRAINT; Schema: public; Owner: Guest; Tablespace: 
--

ALTER TABLE ONLY brands
    ADD CONSTRAINT brands_pkey PRIMARY KEY (id);


--
-- Name: brands_stores_pkey; Type: CONSTRAINT; Schema: public; Owner: Guest; Tablespace: 
--

ALTER TABLE ONLY brands_stores
    ADD CONSTRAINT brands_stores_pkey PRIMARY KEY (id);


--
-- Name: stores_pkey; Type: CONSTRAINT; Schema: public; Owner: Guest; Tablespace: 
--

ALTER TABLE ONLY stores
    ADD CONSTRAINT stores_pkey PRIMARY KEY (id);


--
-- Name: public; Type: ACL; Schema: -; Owner: epicodus
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM epicodus;
GRANT ALL ON SCHEMA public TO epicodus;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

