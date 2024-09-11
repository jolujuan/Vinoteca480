--
-- PostgreSQL database dump
--

-- Dumped from database version 16.3
-- Dumped by pg_dump version 16.3

-- Started on 2024-08-04 04:50:02

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 217 (class 1259 OID 17382)
-- Name: mediciones; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.mediciones (
    id integer NOT NULL,
    id_sensor integer NOT NULL,
    id_vino integer NOT NULL,
    "año" integer NOT NULL,
    color character varying(15) NOT NULL,
    temperatura double precision NOT NULL,
    graduacion double precision NOT NULL,
    ph double precision NOT NULL
);


ALTER TABLE public.mediciones OWNER TO postgres;

--
-- TOC entry 216 (class 1259 OID 17381)
-- Name: mediciones_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.mediciones_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.mediciones_id_seq OWNER TO postgres;

--
-- TOC entry 4925 (class 0 OID 0)
-- Dependencies: 216
-- Name: mediciones_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.mediciones_id_seq OWNED BY public.mediciones.id;


--
-- TOC entry 219 (class 1259 OID 17391)
-- Name: sensores; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sensores (
    id integer NOT NULL,
    id_usuario integer NOT NULL,
    nombre character varying(50) NOT NULL
);


ALTER TABLE public.sensores OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 17390)
-- Name: sensores_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sensores_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sensores_id_seq OWNER TO postgres;

--
-- TOC entry 4926 (class 0 OID 0)
-- Dependencies: 218
-- Name: sensores_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sensores_id_seq OWNED BY public.sensores.id;


--
-- TOC entry 221 (class 1259 OID 17399)
-- Name: usuario; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuario (
    id integer NOT NULL,
    nombre character varying(50) NOT NULL,
    apellido character varying(50) NOT NULL,
    email character varying(50) NOT NULL,
    "contraseña" character varying(50) NOT NULL
);


ALTER TABLE public.usuario OWNER TO postgres;

--
-- TOC entry 220 (class 1259 OID 17398)
-- Name: usuario_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.usuario_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.usuario_id_seq OWNER TO postgres;

--
-- TOC entry 4927 (class 0 OID 0)
-- Dependencies: 220
-- Name: usuario_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.usuario_id_seq OWNED BY public.usuario.id;


--
-- TOC entry 223 (class 1259 OID 17406)
-- Name: vino; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.vino (
    id integer NOT NULL,
    id_usuario integer NOT NULL,
    nombre character varying(50) NOT NULL,
    "año" integer NOT NULL
);


ALTER TABLE public.vino OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 17405)
-- Name: vino_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.vino_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.vino_id_seq OWNER TO postgres;

--
-- TOC entry 4928 (class 0 OID 0)
-- Dependencies: 222
-- Name: vino_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.vino_id_seq OWNED BY public.vino.id;


--
-- TOC entry 4749 (class 2604 OID 17385)
-- Name: mediciones id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mediciones ALTER COLUMN id SET DEFAULT nextval('public.mediciones_id_seq'::regclass);


--
-- TOC entry 4750 (class 2604 OID 17394)
-- Name: sensores id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sensores ALTER COLUMN id SET DEFAULT nextval('public.sensores_id_seq'::regclass);


--
-- TOC entry 4751 (class 2604 OID 17402)
-- Name: usuario id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario ALTER COLUMN id SET DEFAULT nextval('public.usuario_id_seq'::regclass);


--
-- TOC entry 4752 (class 2604 OID 17409)
-- Name: vino id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vino ALTER COLUMN id SET DEFAULT nextval('public.vino_id_seq'::regclass);


--
-- TOC entry 4913 (class 0 OID 17382)
-- Dependencies: 217
-- Data for Name: mediciones; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.mediciones VALUES (1, 1, 1, 2024, 'Amarillo', 15.5, 13, 3.8);
INSERT INTO public.mediciones VALUES (2, 2, 2, 2023, 'Rojo', 12.8, 12.5, 3.5);
INSERT INTO public.mediciones VALUES (3, 3, 3, 2025, 'Rojo Claro', 14.2, 14, 3.9);


--
-- TOC entry 4915 (class 0 OID 17391)
-- Dependencies: 219
-- Data for Name: sensores; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.sensores VALUES (1, 1, 'Temperatura Sensor 1');
INSERT INTO public.sensores VALUES (2, 2, 'Humedad Sensor 1');
INSERT INTO public.sensores VALUES (3, 3, 'PH Sensor 1');


--
-- TOC entry 4917 (class 0 OID 17399)
-- Dependencies: 221
-- Data for Name: usuario; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.usuario VALUES (1, 'Jose', 'Luis', 'jose@hotmail.com', 'password123');
INSERT INTO public.usuario VALUES (2, 'Ana', 'Sanz', 'ana.sanz@gmail.com', 'securepass456');
INSERT INTO public.usuario VALUES (3, 'Jonhy', 'Sanchez', 'john@outlook.com', 'pass789');
INSERT INTO public.usuario VALUES (4, 'admin', 'admin', 'admin', 'admin');


--
-- TOC entry 4919 (class 0 OID 17406)
-- Dependencies: 223
-- Data for Name: vino; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.vino VALUES (1, 1, 'Chardonnay', 2021);
INSERT INTO public.vino VALUES (2, 1, 'Cabernet Sauvignon', 2020);
INSERT INTO public.vino VALUES (3, 2, 'Merlot', 2019);


--
-- TOC entry 4929 (class 0 OID 0)
-- Dependencies: 216
-- Name: mediciones_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.mediciones_id_seq', 4, true);


--
-- TOC entry 4930 (class 0 OID 0)
-- Dependencies: 218
-- Name: sensores_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sensores_id_seq', 4, true);


--
-- TOC entry 4931 (class 0 OID 0)
-- Dependencies: 220
-- Name: usuario_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.usuario_id_seq', 5, true);


--
-- TOC entry 4932 (class 0 OID 0)
-- Dependencies: 222
-- Name: vino_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.vino_id_seq', 4, true);


--
-- TOC entry 4756 (class 2606 OID 17387)
-- Name: mediciones mediciones_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mediciones
    ADD CONSTRAINT mediciones_pkey PRIMARY KEY (id);


--
-- TOC entry 4759 (class 2606 OID 17396)
-- Name: sensores sensores_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sensores
    ADD CONSTRAINT sensores_pkey PRIMARY KEY (id);


--
-- TOC entry 4761 (class 2606 OID 17404)
-- Name: usuario usuario_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT usuario_pkey PRIMARY KEY (id);


--
-- TOC entry 4764 (class 2606 OID 17411)
-- Name: vino vino_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vino
    ADD CONSTRAINT vino_pkey PRIMARY KEY (id);


--
-- TOC entry 4753 (class 1259 OID 17389)
-- Name: idx_712052f98545f611; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_712052f98545f611 ON public.mediciones USING btree (id_vino);


--
-- TOC entry 4754 (class 1259 OID 17388)
-- Name: idx_712052f99ab1a25d; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_712052f99ab1a25d ON public.mediciones USING btree (id_sensor);


--
-- TOC entry 4762 (class 1259 OID 17412)
-- Name: idx_e65ea13fcf8192d; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_e65ea13fcf8192d ON public.vino USING btree (id_usuario);


--
-- TOC entry 4757 (class 1259 OID 17397)
-- Name: idx_f7493a62fcf8192d; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_f7493a62fcf8192d ON public.sensores USING btree (id_usuario);


--
-- TOC entry 4765 (class 2606 OID 17418)
-- Name: mediciones fk_712052f98545f611; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mediciones
    ADD CONSTRAINT fk_712052f98545f611 FOREIGN KEY (id_vino) REFERENCES public.vino(id);


--
-- TOC entry 4766 (class 2606 OID 17413)
-- Name: mediciones fk_712052f99ab1a25d; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mediciones
    ADD CONSTRAINT fk_712052f99ab1a25d FOREIGN KEY (id_sensor) REFERENCES public.sensores(id);


--
-- TOC entry 4768 (class 2606 OID 17428)
-- Name: vino fk_e65ea13fcf8192d; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vino
    ADD CONSTRAINT fk_e65ea13fcf8192d FOREIGN KEY (id_usuario) REFERENCES public.usuario(id);


--
-- TOC entry 4767 (class 2606 OID 17423)
-- Name: sensores fk_f7493a62fcf8192d; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sensores
    ADD CONSTRAINT fk_f7493a62fcf8192d FOREIGN KEY (id_usuario) REFERENCES public.usuario(id);


-- Completed on 2024-08-04 04:50:03

--
-- PostgreSQL database dump complete
--

